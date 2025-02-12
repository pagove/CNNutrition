<?php
class BDMySql
{
    public $con;
    private $in_transaction = false;
    private $in_transaction_error = false;
    public $ultimo_error;

    public function __construct($strCon, $user, $pass)
    {
        try {
            $this->con = new PDO($strCon, $user, $pass);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            Logger::haz_log(__CLASS__, $e->getMessage());
            die("Error conectando a la base de datos: " . $e->getMessage());
        }
    }

    public function setInTransaction($intransacition)
    {
        $this->in_transaction = $intransacition;
    }
    public function begin()
    {
        if ($this->in_transaction) return true;
        $this->ultimo_error = "";
        return $this->ejecuta("BEGIN");
    }
    public function rollback()
    {
        $this->ejecuta("ROLLBACK");
    }
    public function commit()
    {
        if ($this->in_transaction_error) return $this->rollback();
        return $this->ejecuta("COMMIT");
    }


    /**  
     * PDO::FETCH_ASSOC -> devuelve un array indexado por el nombre de la columna en la bd
     * PDO::FETCH_OBJ -> devuelve un array de objetos donde los atributos tienen el nombre de la columna de la bd
     */
    public function consulta($sql, &$filas = "", $as_object = false)
    {
        $stmt = $this->con->query($sql);
        $ret = $as_object ? $stmt->fetchAll(PDO::FETCH_ASSOC) : $stmt->fetchAll(PDO::FETCH_OBJ);
        $filas = count($ret);
        return $ret;
    }

    public function getObject($sql)
    {
        $r = self::getAll($sql, "", true);
        if (count($r) > 0) {
            return self::getAll($sql, "", true)[0];
        }
        return null;
    }
    public function getAll($sql, $indice = "", $as_object = false)
    {
        if ($as_object) {
            $stmt = $this->con->query($sql);
            $dts = $stmt->fetchAll(PDO::FETCH_OBJ);
            if ($indice) {
                if (is_array($indice)) {
                    $key = "";
                    $vector = array();
                    foreach ($dts as $o) {
                        if (is_array($indice)) {
                            $v = &$vector;
                            foreach ($indice as $c) {
                                $key = $o->$c;
                                if (!isset($v[$key])) $v[$key] = null;
                                $v = &$v[$key];
                            }
                            $v = $o;
                        }
                    }
                    return $vector;
                } else {
                    if (property_exists($dts[0], $indice)) {
                        $ret = array();
                        foreach ($dts as $d) {
                            $ret[$d->$indice][] = $d;
                        }
                        return $ret;
                    }
                }
            } else {
                return $dts;
            }
        } else {
            $stmt = $this->con->query($sql);
            $dts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($indice) {
                if (is_array($indice)) {
                    $key = "";
                    $vector = array();
                    foreach ($dts as $o) {
                        if (is_array($indice)) {
                            $v = &$vector;
                            foreach ($indice as $c) {
                                $key = $o[$c];
                                if (!isset($v[$key])) $v[$key] = null;
                                $v = &$v[$key];
                            }
                            $v = $o;
                        }
                    }
                    return $vector;
                } else {
                    $ret = array();
                    foreach ($dts as $d) {
                        $ret[$d[$indice]][] = $d;
                    }
                    return $ret;
                }
            } else {
                return $dts;
            }
        }
        return array();
    }

    public function getAllAsArray($sql)
    {
        $stmt = $this->con->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get($sql)
    {
        $stmt = $this->con->query($sql);
        $v = $stmt->fetch(PDO::FETCH_ASSOC);
        return reset($v);
    }

    public function getSqlForService($sql, $funcion = null)
    {
        $ret = array();
        $reg = $this->getAll($sql, "", true);
        foreach ($reg as $o) {
            if ($funcion) $funcion($o);
            if ($o) $ret[] = $o;
        }
        return $ret;
    }
    /**
     * Puede lanzar un delete o un update pasandole un array de datos y clave
     */
    public function secEjecuta($instruccion, $tabla, $datos = array(), $claves = array())
    {
        $sql = "$instruccion $tabla ";
        foreach ($datos as $key => $o) {
            $sql .= " $key = :$key ,";
        }
        $sql = substr($sql, 0, -1);
        foreach ($claves as $clave) {
            $sql .= " WHERE $clave = :$clave AND ";
        }
        $sql = substr($sql, 0, -4);
        $sql .= ";";
        $stmt = $this->con->prepare($sql);
        foreach ($datos as $d) {
            $stmt->bindValue(":" . $d, $d);
        }
        foreach ($claves as $c) {
            $stmt->bindValue(":" . $c, $c);
        }

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            $msg = $e->getCode() . " , " . $e->getMessage();
            Logger::haz_log(__CLASS__, $msg);
            $this->ultimo_error = $msg;
            return new TRetorno(false, $msg);
        }
        return new TRetorno(true);
    }

    public function ejecuta($sql)
    {
        try {
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if ($this->con->exec($sql) !== false) return true;
            return false;
        } catch (PDOException $e) {
            $msg = $e->getCode() . " , " . $e->getMessage();
            Logger::haz_log(__CLASS__, $msg);
            Logger::haz_log(__CLASS__, $sql);
            $this->ultimo_error = $msg . " -- " . $sql;
            return false;
        }
    }

    public function ejecuta2($sql, &$afectadas)
    {
        try {
            $afectadas = $this->con->exec($sql);
            if ($afectadas !== false) return true;
        } catch (PDOException $e) {
            $msg = $e->getCode() . " , " . $e->getMessage();
            Logger::haz_log(__CLASS__, $msg);
            Logger::haz_log(__CLASS__, $sql);
            $this->ultimo_error = $msg . " -- " . $sql;
            return false;
        }
    }

    public function insertOrUpdate($tabla, $datos, $claves)
    {
        $r = self::select($tabla, $datos, $claves);
        if (count($r)) return self::update($tabla, $datos, $claves);
        return self::insert($tabla, $datos);
    }

    public function select($tabla, $datos, $claves)
    {
        $sql = "SELECT * FROM $tabla WHERE ";
        foreach ($claves as $k => $v) {
            $sql .= "$k=$v AND ";
        }
        substr($sql, 0, -4);
        return self::consulta($sql);
    }
    public function update($tabla, $datos, $claves)
    {
        $sql = "UPDATE $tabla SET ";
        foreach ($datos as $k => $v) {
            $sql .= "$k=$v, ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= " WHERE ";
        foreach ($claves as $k => $v) {
            $sql .= "$k=$v AND ";
        }
        $sql = substr($sql, 0, -4);
        return self::ejecuta($sql);
    }
    public function insert2($tabla, $datos)
    {
        $sql = "INSERT INTO $tabla (";
        foreach ($datos as $k => $v) {
            $sql .= "$k,";
        }
        $sql = substr($sql, 0, -1);
        $sql .= ") VALUES (";
        foreach ($datos as $k => $v) {
            $sql .= "$v,";
        }
        $sql = substr($sql, 0, -1);
        $sql .= ")";
        return self::ejecuta($sql);
    }

    public function array2set($v, $in = true, $parentesis = true, $comillas = true)
    {
        if ($comillas) {
            $v = array_map(function ($el) {
                return "'" . $el . "'";
            }, $v);
        }

        $v = implode(",", $v);
        $v = $parentesis ? "($v)" : $v;
        $v = $in ? " in $v " : $v;
        return $v;
    }


    public  function tableMetaData($table)
    {
        $sql = " DESCRIBE $table";
        $ret = array();
        $regs = self::getAll($sql, "", true);
        foreach ($regs as $r) {
            $ret[$r->Field] = $r;
        }
        return $ret;
    }

    public function insert($tabla, $datos, $returning = "")
    {
        $obd = Conexion::conecta();
        $ok = true;
        $msg = "";
        $metaData = self::tableMetaData($tabla);
        $sql = "insert into $tabla (";
        $values = " values (";
        if ($returning && !array_key_exists($returning, $metaData)) {
            Logger::haz_log("BDMySql_insert", "Returning col ($returning) not in $tabla");
            $obd->ultimo_error = "Returning col ($returning) not in $tabla";
            return false;
        }
        //if (is_object($datos)) $datos = array($datos);
        foreach ($metaData as $col => $m) {
            /** Comprobar defaults o autoincrements */
            if (!array_key_exists($col, $datos) && (isset($m->Default) || isset($m->Extra))) continue;
            /** Campo no indica en los datos */
            if (!array_key_exists($col, $datos)) {
                if ($m->Null == "NO") {
                    $ok = false;
                    $msg = "Columna $col no indicada en el array de datos";
                    break;
                } else {
                    continue;
                }
            }
            /** Comprobar tipos de datos*/
            $v = @$datos[$col];
            $tv = gettype($v);
            switch ($tv) {
                case "boolean":
                    if ($m->Type == "tinyint(1)") {
                        $sql .= "$col,";
                        $_v = $v ? 1 : 0;
                        $values .= "$_v,";
                    } else {
                        $ok = false;
                        $msg = "El tipo de $v($tv) no corresponde con $col(" . $m->Type . ")";
                        break 2;
                    }
                    echo "boolean";
                    break;
                case "integer":
                    if (substr($m->Type, 0, 3) == "int") {
                        $tam = str_replace("int(", "", $m->Type);
                        $tam = substr($tam, 0, -1);
                        if (strlen($v) < $tam) {
                            $sql .= "$col,";
                            $values .= "$v,";
                        } else {
                            $ok = false;
                            $msg = "El tipo de $v($tv) no corresponde con $col(" . $m->Type . ")";
                            break 2;
                        }
                    } else {
                        if ($m->Type == "tinyint(1)") {
                            if ($v == 0 || $v == 1) {
                                $sql .= "$col,";
                                $values .= "$v,";
                            } else {
                                $ok = false;
                                $msg = "El tipo de $v($tv(" . strlen(strval($v)) . ") no corresponde con $col(" . $m->Type . ")";
                                break 2;
                            }
                        } else {
                            $ok = false;
                            $msg = "El tipo de $v($tv) no corresponde con $col(" . $m->Type . ")";
                            break 2;
                        }
                    }
                    break;
                case "double":
                    if ($m->Type == "double" || $m->Type == "decimal") {
                        $sql .= "$col,";
                        $values .= "$v,";
                    } else {
                        $ok = false;
                        $msg = "El tipo de $v($tv) no corresponde con $col(" . $m->Type . ")";
                        break 2;
                    }
                    break;
                case "string":
                    //$v = $obd->quote($v);
                    if ($m->Type == "date") {
                        if (strlen($v) == 10) {
                            $sql .= "$col,";
                            $values .= "'$v',";
                        } else {
                            $ok = false;
                            $msg = "El tipo de $v(date) no corresponde con $col(" . $m->Type . ")";
                            break 2;
                        }
                    } else {
                        $length_c = substr($m->Type, 8);
                        $length_c = substr($length_c, 0, -1);
                        if (strlen($v) <= $length_c) {
                            $sql .= "$col,";
                            $values .= "'$v',";
                        } else {
                            $ok = false;
                            $msg = "El tipo de $v($tv(" . strlen($v) . ") ) no corresponde con $col(" . $m->Type . ")";
                            break 2;
                        }
                    }
                    break;

                case "array":
                case "object":
                case "NULL":
                    //por implementar, no se da el caso.
                    break;
            }
        }
        if (!$ok) {
            $this->ultimo_error = $msg;
            Logger::haz_log("BDMySql_insert", $msg);
            return false;
        } else {
            $sql = substr($sql, 0, -1);
            $values = substr($values, 0, -1);
            $sql .= ") $values )";
            if ($returning) {
                $sql .= "returning $returning;";
                $ok = $obd->get($sql);
            } else {
                $sql .= ";";
                $ok = $obd->ejecuta($sql);
            }
            return $ok;
        }
    }
}
