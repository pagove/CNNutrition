<?php
class Tarifa
{
    public static function getTarifas()
    {
        $obd = Conexion::conecta();
        $sql = "select * from Tarifas";
        return $obd->getAll($sql, "", true);
    }
}
