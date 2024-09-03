<?php
//include_once("Clases/Conexion.php");
//include_once("Clases/Utilidades.php");
//include_once("Clases/TRetorno.php");
//include_once("Clases/Logger.php");
include_once("../clases.php");
class Tarifa
{

    public static function getTarifas()
    {
        $obd = Conexion::conecta();
        $sql = "select * from Tarifas";
        return $obd->getAll($sql, "", true);
    }
}
