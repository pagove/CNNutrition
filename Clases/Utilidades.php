<?php
include_once("../clases.php");
class Utilidades
{

    public static function getClienteIp()
    {
        if (isset($_SERVER['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        }
        return false;
    }

    public static function getPID()
    {
        return getmygid();
    }

    public static function encripta($passwd)
    {
        return hash("sha256", $passwd, false);
    }

    public static function creaCriterioQuery($campos, $query, $op = "or")
    {
        $ret = "";
        $total = count($campos);
        foreach ($campos as $k => $v) {
            $ret .= " $v::varchar ilike '%$query%' ";
            if ($k < $total - 1) $ret .= " $op ";
        }

        return $ret;
    }
}
