<?php
class Tarifa
{
    public static function getTarifas()
    {
        Logger::haz_log("GOVE", "PASA");
        $obd = Conexion::conecta();
        $sql = "select * from Tarifas";
        return $obd->getAll($sql, "", true);
    }
}
