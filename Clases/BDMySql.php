<?php
include_once("BDMySql.php");
include_once("Logger.php");
class BDMySql
{

    private $con;
    private static $in_transaction = false;

    public static $ultimo_error;

    public function __construct($strCon, $user, $pass)
    {
        try {
            $this->con = new PDO($strCon, $user, $pass);
        } catch (PDOException $e) {
            Logger::haz_log(__CLASS__,$e->getMessage());
            die("Error conectando a la base de datos: " . $e->getMessage());
        }
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

    public function getObject($sql){
        return self::getAll($sql, "",true)[0];
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

    public static function each($sql)
    {
    }

    public  function secEjecuta($instruccion, $tabla, $datos = array(), $claves = array())
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
            Logger::haz_log(__CLASS__,$msg);
            $this->ultimo_error = $msg;
            return new TRetorno(false, $msg);
        }
        return new TRetorno(true);
    }
    public  function ejecuta($sql)
    {
        try{
            if($this->con->exec($sql)) return true;
        } catch(PDOException $e){
            $msg = $e->getCode() . " , " . $e->getMessage();
            Logger::haz_log(__CLASS__,$msg);
            Logger::haz_log(__CLASS__,$sql);
            $this->ultimo_error = $msg . " -- " .$sql;
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
    public function insert($tabla, $datos)
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

    public static function array2set($v, $in = true, $parentesis = true, $comillas = true)
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
    

    public static function setInTransaction($in_transaction){
        self::$in_transaction = $in_transaction;
    }
    public function getInTransaction(){
        return self::$in_transaction;
    }
}
