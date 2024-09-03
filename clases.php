<?php
include_once "Clases/Logger.php";

function autoIncludeClases($class)
{
    $directories = array("Clases", "Modulos", "PhpFiles");
    foreach ($directories as $dir) {
        $path = recursiveFindFile($dir, $class);
        if ($path) {
            Logger::haz_log("GOVE", $path);
            include $path;
        }
    }
}

function recursiveFindFile($directory, $filename)
{
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
    foreach ($iterator as $file) {

        if (basename($file) == $filename . ".php") {
            return str_replace('\\', "/", $file->getPathname());
        }
    }
    return false;
}

spl_autoload_register(function ($class) {
    autoIncludeClases($class);
});
