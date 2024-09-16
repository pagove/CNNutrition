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


    public static function encripta_hash($passwd)
    {
        return hash("sha256", $passwd, false);
    }

    public static function encriptar($data)
    {

        $metodo_cifrado = 'AES-256-CBC';

        $iv_length = openssl_cipher_iv_length($metodo_cifrado);
        $iv = openssl_random_pseudo_bytes($iv_length);

        $encrypted = openssl_encrypt($data, $metodo_cifrado, DatosConexion::getAESpasswd(), 0, $iv);

        return base64_encode($iv . $encrypted);
    }

    public static function desencriptar($data_encriptada)
    {
        $metodo_cifrado = 'AES-256-CBC';

        $data_encriptada = base64_decode($data_encriptada);

        $iv_length = openssl_cipher_iv_length($metodo_cifrado);

        $iv = substr($data_encriptada, 0, $iv_length);
        $encrypted = substr($data_encriptada, $iv_length);

        return openssl_decrypt($encrypted, $metodo_cifrado, DatosConexion::getAESpasswd(), 0, $iv);
    }
}
