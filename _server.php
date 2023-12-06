<?php
include_once("Clases/Logger.php");
include_once("Modulos/Usuario.php");

$dts = json_decode(file_get_contents("php://input"), true);
Logger::haz_log("GOVE", var_export($dts, true));
switch ($dts["function"]) {
    case "compruebaLogin":
        compruebaLogin($dts["email"], $dts["passwd"]);
        break;
    case "guardarDatosGenerales":
        guardarDatosGenerales($dts["id_usuario"], $dts["fecha"],$dts["peso"], $dts["grasa"], $dts["musculo"]);
        break;
    case "eliminarDatosNutricionalesGenerales":
        eliminarDatosNutricionalesGenerales($dts["id_dato_general"]);
        break;
}

function compruebaLogin($email, $passwd){
    die( json_encode(Usuario::compruebaLogin($email, $passwd)));
}

function guardarDatosGenerales($id_usuario, $fecha, $peso, $grasa, $musculo){
    die(json_encode(Usuario::guardarDatosGenerales($id_usuario,$fecha,$peso,$grasa,$musculo)));
}

function eliminarDatosNutricionalesGenerales($id_dato_general){
die(json_encode(Usuario::eliminaDatoGeneral($id_dato_general)));
}
