<?php
/*

SIEMPRE COGE EL PATH QUE HAY DENTRO DEL INCLUDE_PATH EN EL SCRIPT DE WEBSTATION


include_once("Clases/Logger.php");
//Modificando la ruta de inclusión path
$_ruta = dirname(__FILE__);
Logger::haz_log("autoIncludeClases__FILE__", __FILE__, 3);
$document_root = $_SERVER['DOCUMENT_ROOT'];
$directories = array("Clases", "Clases/Mail", "Modulos");

$os = PHP_OS;

$barras = "/";
$separadores = ":";
if ($os == "WINNT") {
    $barras = "\\";
    $separadores = ";";
}

$path = get_include_path() . $separadores . $document_root;

foreach ($directories as $dir) {
    $path .= $separadores . $_ruta . $barras . $dir;
}
Logger::haz_log("include_path", $path, 3);
set_include_path($path);
*/
function autoIncludeClases($class)
{
    include_once $class . ".php";
    Logger::haz_log("autoIncludeClases", "$class.php");
}

spl_autoload_register("autoIncludeClases");

function error_handler($e)
{
    Logger::haz_log("Handler_Error", json_encode($e));
}

set_exception_handler("error_handler");

function miManejadorDeErrores($errno, $errstr, $errfile, $errline)
{
    Utilidades::getBacklogTrace("CLASS");
    Logger::haz_log("CLASS", "Error [$errno]: $errstr en el archivo $errfile en la línea $errline");
}
set_error_handler("miManejadorDeErrores");

function errorFatalHandler()
{
    $error = error_get_last();
    if ($error !== NULL) {
        Logger::haz_log("FATAL_ERROR", Utilidades::getBacklogTrace());
        $tipo_error = $error['type'];
        $mensaje_error = $error['message'];
        $archivo_error = $error['file'];
        $linea_error = $error['line'];
        Logger::haz_log("FATAL_ERROR", "Error fatal [$tipo_error]: $mensaje_error en el archivo $archivo_error en la línea $linea_error");
    }
}

register_shutdown_function('errorFatalHandler');
