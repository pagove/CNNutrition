<?php
include_once("Utilidades.php");
include_once("BDMySql.php");
include_once("Logger.php");
include_once("DatosConexion.php");
class Conexion
{
    private static $REMOTE = true;
    private static $TEST = true;
    public static $pool = array();

    public static function conecta()
    {

        if (!@self::$pool[Utilidades::getPID()]) {
            try {
                $d = DatosConexion::getDatosConexion(self::$REMOTE, self::$TEST);
                $strCon = "mysql:host=$d->host;dbname=$d->database";
                $con = new BDMySql($strCon, $d->user, $d->passwd);
                self::$pool[Utilidades::getPID()] = $con;
            } catch (PDOException $e) {
                Logger::haz_log(__CLASS__, $e->getMessage());
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
        if (self::$pool[Utilidades::getPID()]->getInTransaction()) die("Transacción en curso");
        self::autoCloseAll();
        BDMySql::setInTransaction(true);
        Logger::haz_log(__CLASS__, "SET_IN_TRANSACTION -> TRUE");
    }

    public static function autoEndTransaction($ok, $msg, $msgError)
    {
        if ($ok) {
            $okAux = self::$pool[Utilidades::getPID()]->con->commit();
            if ($okAux) {
                BDMySql::setInTransaction(false);
                return new TRetorno($ok, $msgError);
            }
        } else {
            $okAux = self::$pool[Utilidades::getPID()]->con->rollBack();
            if ($okAux) {
                BDMySql::setInTransaction(false);
                return new TRetorno($ok, $msgError);
            } else {
                Logger::haz_log(__CLASS__, "ERROR CON AUTOENDTRANSACTION");
                die("Error con autoEndTransaction");
            }
        }
    }
}
