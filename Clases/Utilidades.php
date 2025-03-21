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
        $clave = DatosConexion::getAESpasswd();

        // Verificar si la clave tiene 32 bytes (256 bits)
        if (strlen($clave) !== 32) {
            throw new Exception("Clave de cifrado incorrecta. Debe ser de 32 bytes.");
        }

        $iv_length = openssl_cipher_iv_length($metodo_cifrado);
        $iv = openssl_random_pseudo_bytes($iv_length, $crypto_strong);

        // Verificar si se generó un IV válido
        if ($iv === false || !$crypto_strong) {
            throw new Exception("No se pudo generar un IV seguro.");
        }

        $encrypted = openssl_encrypt($data, $metodo_cifrado, $clave, OPENSSL_RAW_DATA, $iv);

        if ($encrypted === false) {
            throw new Exception("Error al cifrar los datos.");
        }

        return base64_encode($iv . $encrypted);
    }

    public static function desencriptar($data_encriptada)
    {
        $metodo_cifrado = 'AES-256-CBC';
        $clave = DatosConexion::getAESpasswd();

        // Verificar si la clave tiene 32 bytes (256 bits)
        if (strlen($clave) !== 32) {
            throw new Exception("Clave de cifrado incorrecta. Debe ser de 32 bytes.");
        }

        $data_encriptada = base64_decode($data_encriptada);
        $iv_length = openssl_cipher_iv_length($metodo_cifrado);

        // Verificar que los datos encriptados sean mayores que la longitud del IV
        if (strlen($data_encriptada) < $iv_length) {
            throw new Exception("Los datos encriptados son inválidos.");
        }

        $iv = substr($data_encriptada, 0, $iv_length);
        $encrypted = substr($data_encriptada, $iv_length);

        $decrypted = openssl_decrypt($encrypted, $metodo_cifrado, $clave, OPENSSL_RAW_DATA, $iv);

        if ($decrypted === false) {
            throw new Exception("Error al descifrar los datos.");
        }

        return $decrypted;
    }

    public static function array2set($v, $in = true, $parentesis = true, $comillas = true)
    {
        Logger::dev_log("---------------", var_export($v, true));
        Logger::dev_log("---------------", debug_backtrace());
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

    public static function getBacklogTrace($tag = "")
    {
        $trace = debug_backtrace();
        $ret = "";

        foreach ($trace as $fn) {
            $class = array_key_exists("class", $fn) ? $fn["class"] . "::" : "";
            $fun_args =  array_key_exists("args", $fn) && array_key_exists("function", $fn) ? $fn["function"] . "(" .   implode(",", $fn["args"]) . ")" : "";
            $line = array_key_exists("line", $fn) ? "ln(" . $fn["line"] . ")" : "";
            $file = array_key_exists("file", $fn) ? $fn["file"] . ":" : "";
            if ($tag) {
                $err =  "$file $line $class $fun_args ";
                if ($err) {
                    Logger::haz_log($tag, $err);
                } else {
                    Logger::haz_log("Utilidades::getBacklogTrace($tag)", var_export($fn, true));
                }
            } else {
                $ret .= "$file $line $class $fun_args \n";
            }
        }
        if (!$tag) return $ret;
    }

    public static function getUrlWeb()
    {
        if (DatosConexion::imDesarrollo()) {
            return "http://192.168.1.3:8080";
        } else {
            return "https://gove.synology.me";
        }
    }
}
