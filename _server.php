<?php
include_once("Clases/Logger.php");
include_once("Modulos/Usuario.php");

$dts = json_decode(file_get_contents("php://input"), true);
Logger::haz_log("GOVE", var_export($dts, true));
switch ($dts["function"]) {
    case "compruebaLogin":{
        compruebaLogin($dts["email"], $dts["passwd"]);
        break;
    }
}

function compruebaLogin($email, $passwd){
    die( json_encode(Usuario::compruebaLogin($email, $passwd)));
}