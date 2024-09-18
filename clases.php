<?php
include_once("Clases/Logger.php");
//Modificando la ruta de inclusión path
$_ruta = dirname(__FILE__);
Logger::haz_log("autoIncludeClases__FILE__", __FILE__);
$document_root = $_SERVER['DOCUMENT_ROOT'];
$directories = array($document_root, "Clases", "Clases/Mail", "Modulos");
$path = get_include_path();

$os = PHP_OS;

$barras = "/";
$separadores = ":";
if ($os == "WINNT") {
    $barras = "\\";
    $separadores = ";";
}

foreach ($directories as $dir) {
    $path .= $separadores . $_ruta . $barras . $dir;
}
Logger::haz_log("include_path", $path);
set_include_path($path);

function autoIncludeClases($class)
{
    Logger::haz_log("autoIncludeClases", __FILE__);
    Logger::haz_log("autoIncludeClases", "$class.php");
    include $class . ".php";
}

spl_autoload_register("autoIncludeClases");

function error_handler($e)
{
    Logger::haz_log("Error", json_encode($e));
}

set_exception_handler("error_handler");
