<?php
include_once("clases.php");


$dts = json_decode(file_get_contents("php://input"), true);
Logger::haz_log("GOVE", var_export($dts, true));

switch ($dts["function"]) {
    case "compruebaLogin":
        compruebaLogin($dts["email"], $dts["passwd"]);
        break;
    case "guardarDatosGenerales":
        guardarDatosGenerales($dts["id_usuario"], $dts["fecha"], $dts["peso"], $dts["grasa"], $dts["musculo"]);
        break;
    case "eliminarDatosNutricionalesGenerales":
        eliminarDatosNutricionalesGenerales($dts["id_dato_general"]);
        break;
    case "cerrarSesion":
        cerrarSesion();
        break;
    case "listarUsuarios":
        listarUsuarios($dts["nombre"], $dts["ap1"], $dts["ap2"], $dts["email"], $dts["tel"]);
        break;
}

function listarUsuarios($nombre, $ap1, $ap2, $email, $tel)
{
    die(json_encode(Usuario::listarUsuarios($nombre, $ap1, $ap2, $email, $tel)));
}

function compruebaLogin($email, $passwd)
{
    die(json_encode(Usuario::compruebaLogin($email, $passwd)));
}

function cerrarSesion()
{
    die(json_encode(Usuario::cerrarSesion()));
}

function guardarDatosGenerales($id_usuario, $fecha, $peso, $grasa, $musculo)
{
    die(json_encode(Usuario::guardarDatosGenerales($id_usuario, $fecha, $peso, $grasa, $musculo)));
}

function eliminarDatosNutricionalesGenerales($id_dato_general)
{
    die(json_encode(Usuario::eliminaDatoGeneral($id_dato_general)));
}
