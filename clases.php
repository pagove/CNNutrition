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
    //$path .= ";$_ruta\\$dir"; //buscar como detectar SO y cambiar barras (/,\) y separadores (;,:)
}
set_include_path($path);

function autoIncludeClases($class)
{
    include $class . ".php";
}
/*
function recursiveFindFile($directory, $filename)
{
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
    foreach ($iterator as $file) {

        if (basename($file) == $filename . ".php") {
            return str_replace('\\', "/", __DIR__ . "/" . $file->getPathname());
        }
    }
    return false;
}
*/
spl_autoload_register("autoIncludeClases");
