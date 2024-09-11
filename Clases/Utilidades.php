<?php
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

    public static function autoCallFunction()
    {
        $function = reset(array_keys($_GET));
        if (function_exists($function)) {
            call_user_func($function());
            die();
        }
    }


    public static function registraUsuario($nombre, $ap1, $ap2, $email, $tel, $fecha_nac, $sexo, $altura, $tarifa, $passwd, $patologias, $aversiones)
    {
        Logger::haz_log("INSERTA_USUARIO", "$nombre, $ap1, $ap2, $email, $tel, $fecha_nac, $sexo, $altura, $tarifa, $passwd, $patologias, $aversiones");
    }



    public static function ifutf8_encode($string)
    {
        // Detectar la codificación actual de la cadena
        $currentEncoding = mb_detect_encoding($string, 'UTF-8, ISO-8859-1, Windows-1252', true);

        // Si la codificación detectada no es UTF-8
        if ($currentEncoding !== 'UTF-8') {
            // Convertir la cadena a UTF-8
            $string = mb_convert_encoding($string, 'UTF-8', $currentEncoding);
        }

        return $string;
    }


    public static function ifutf8_decode($string, $targetEncoding = 'ISO-8859-1')
    {
        // Detectar la codificación actual de la cadena
        $currentEncoding = mb_detect_encoding($string, 'UTF-8, ISO-8859-1, Windows-1252', true);

        // Si la codificación detectada es UTF-8
        if ($currentEncoding === 'UTF-8') {
            // Convertir la cadena de UTF-8 a la codificación deseada
            $string = mb_convert_encoding($string, $targetEncoding, 'UTF-8');
        }

        return $string;
    }
}
