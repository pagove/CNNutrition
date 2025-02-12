<?php

class Conexion
{
    public static $pool = array();
    public static $in_transaction = false;
    public static $autobegin = false;

    public static function conecta()
    {
        if (!array_key_exists(Utilidades::getPID(), self::$pool)) {
            try {
                $d = DatosConexion::getDatosConexion();
                $strCon = "mysql:host=$d->host;dbname=$d->database";
                $con = new BDMySql($strCon, $d->user, $d->passwd);
                self::$pool[Utilidades::getPID()] = $con;
                if (self::$autobegin && !self::$in_transaction) {
                    $con->begin();
                    self::$autobegin = false;
                }
            } catch (PDOException $e) {
                Logger::err_log(__CLASS__, $e->getMessage());
                die("Sin conexión a la base de datos:" . $e->getMessage());
            }
        }

        return self::$pool[Utilidades::getPID()];
    }

    public static function autoCloseAll()
    {
        self::$pool = array();
    }

    public static function setAutoBeginTransaction()
    {
        if (self::$in_transaction) die("Transacción en curso");
        self::autoCloseAll();
        self::$autobegin = true;
        return true;
    }

    public static function autoEndTransaction($ok, $msg, $msgError, $syslog = "")
    {
        if ($ok) {
            $okAux = self::$pool[Utilidades::getPID()]->con->commit();
            if ($okAux) {
                self::$pool[Utilidades::getPID()]->setInTransaction(false);
                return new TRetorno(true, $msg, null, $syslog);
            } else {
                self::$pool[Utilidades::getPID()]->setInTransaction(false);
                return new TRetorno(false, $msgError, null, $syslog);
            }
        } else {
            $okAux = self::$pool[Utilidades::getPID()]->con->rollBack();
            if ($okAux) {
                self::$pool[Utilidades::getPID()]->setInTransaction(false);
                return new TRetorno(false, self::$pool[Utilidades::getPID()]->ultimo_error, null, $syslog);
            } else {
                Logger::err_log(__CLASS__, "ERROR CON AUTOENDTRANSACTION");
                die("Error con autoEndTransaction");
            }
        }
    }
}
