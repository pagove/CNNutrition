<?php
class Tarifa
{
    public static function getTarifas($id_tarifa = "")
    {
        $obd = Conexion::conecta();
        $query = $id_tarifa ? " and id='$id_tarifa' " : "";
        $sql = "select * from Tarifas where true $query";
        return $obd->getAll($sql, "", true);
    }
}
