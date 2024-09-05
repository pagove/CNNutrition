<?php

//Modificando la ruta de inclusión path
$_ruta = dirname(__FILE__);
$directories = array("Clases", "Modulos");
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
set_include_path($path);

function autoIncludeClases($class)
{
    include $class . ".php";
}

spl_autoload_register("autoIncludeClases");
