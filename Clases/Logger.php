<?php

class Logger
{
    private static $directorio_var_log = '/var/log';
    private static $archivo_en_var_log =  "/var/log/messages.log";
    private static $levels = array("UNDEFINED", "ERROR", "WARNING", "DEBUG", "INFO");

    private static $log_color = array(
        "UNDEFINED" => "\033[37m", //gris
        "ERROR" => "\033[31m", //rojo
        "WARNING" => "\033[33m", //amarillo
        "DEBUG" => "\033[36m", //cian
        "INFO" => "\033[32m" //verde
    );

    public static function haz_log($clave, $message, $level = 0)
    {
        if (($level < 0 || $level > count(self::$levels))) {
            self::haz_log($clave, $message);
        }
        self::comprobarFichero();

        $timestamp = date('Y-m-d H:i:s');

        $key_levels = $level ? "[" . self::$levels[$level] . "]" : "";

        $color_log = self::$log_color[self::$levels[$level]] ?: "";

        $logEntry =  $color_log . $key_levels . "[" . $timestamp . "] $clave: " . $message . PHP_EOL;

        if ($color_log) $logEntry .= "\033[0m"; //quitar el color si lo tiene

        // Escribir el mensaje en el archivo de logs
        if (!error_log($logEntry, 3, self::$archivo_en_var_log)) {
            echo "Error al guardar el log.";
        }
    }

    public static function err_log($clave, $message)
    {
        Utilidades::getBacklogTrace($clave);
        self::haz_log($clave, $message, 1);
    }

    public static function warn_log($clave, $message)
    {
        self::haz_log($clave, $message, 2);
    }

    public static function dev_log($clave, $message)
    {
        self::haz_log($clave, $message, 3);
    }

    public static function info_log($clave, $message)
    {
        self::haz_log($clave, $message, 4);
    }

    private static function comprobarFichero()
    {
        if (!file_exists(self::$archivo_en_var_log)) {
            // Si el archivo no existe, intenta crear la ruta completa
            if (!file_exists(self::$directorio_var_log)) {
                // Si el directorio no existe, créalo
                if (mkdir(self::$directorio_var_log, 0777, true)) {
                    echo "Directorio creado con éxito: " . self::$directorio_var_log . "<br>";
                } else {
                    echo "Error al crear el directorio: " . self::$directorio_var_log . "<br>";
                }
            }

            // A continuación, crea el archivo
            if (touch(self::$archivo_en_var_log)) {
                echo "Archivo creado con éxito: " . self::$archivo_en_var_log . "<br>";
            } else {
                echo "Error al crear el archivo: " . self::$archivo_en_var_log . "<br>";
            }
        }

        // A partir de aquí, puedes trabajar con el archivo en /var/log

    }
}
