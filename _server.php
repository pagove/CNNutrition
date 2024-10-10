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
    case "registraUsuario":
        registraUsuario(
            $dts["nombre"],
            $dts["ap1"],
            $dts["ap2"],
            $dts["email"],
            $dts["tel"],
            $dts["nacimiento"],
            $dts["sexo"],
            $dts["altura"],
            $dts["tarifa"],
            $dts["passwd"],
            $dts["patologias"],
            $dts["aversion"]
        );
        break;
        aceptarTerminosYCondiciones($dts["id_usuario"], $dts["ip_usuario"]);
    case "aceptarTerminosYCondiciones":
        aceptarTerminosYCondiciones($dts["id_usuario"], $dts["ip_usuario"]);
        break;
    case "editarUsuario":
        editarUsuario(
            $dts["id_usuario"],
            $dts["nombre"],
            $dts["ap1"],
            $dts["ap2"],
            $dts["email"],
            $dts["tel"],
            $dts["nacimiento"],
            $dts["sexo"],
            $dts["altura"],
            $dts["tarifa"],
            $dts["patologias"],
            $dts["aversion"]
        );
        break;
    case "enviarMailRGPD":
        enviarMailRGPD($dts["email"], $dts["id_usuario"], $dts["nombre"], $dts["ap1"], $dts["ap2"]);
        break;
    case "guardarPlieguesCutaneos":
        guardarPlieguesCutaneos(
            $dts["id_usuario"],
            $dts["fecha"],
            $dts["tricipital"],
            $dts["subescapular"],
            $dts["supraliaco"],
            $dts["abdominal"],
            $dts["muslo"],
            $dts["gemelo"]
        );
        break;
}

function guardarPlieguesCutaneos($id_usuario, $fecha, $tricipital, $subescapular, $supraliaco, $abdominal, $muslo, $gemelo)
{
    die(json_encode(Usuario::guardarPlieguesCutaneos($id_usuario, $fecha, $tricipital, $subescapular, $supraliaco, $abdominal, $muslo, $gemelo)));
}

function enviarMailRGPD($email, $id_usuario, $nombre, $ap1, $ap2)
{
    die(json_encode(Usuario::enviarMailRGPD($email, $id_usuario, $nombre, $ap1, $ap2)));
}

function editarUsuario($id_usuario, $nombre, $ap1, $ap2, $email, $tel, $nacimiento, $sexo, $altura, $tarifa, $patologias, $aversion)
{
    die(json_encode(Usuario::editarUsuario($id_usuario, $nombre, $ap1, $ap2, $email, $tel, $nacimiento, $sexo, $altura, $tarifa, $patologias, $aversion)));
}

function aceptarTerminosYCondiciones($id_usuario, $ip_usuario)
{
    die(json_encode(Usuario::setPrivacidad($id_usuario, $ip_usuario)));
}

function registraUsuario($nombre, $ap1, $ap2, $email, $tel, $fecha_nac, $sexo, $altura, $tarifa, $passwd, $patologias, $aversiones)
{

    die(json_encode(Usuario::registraUsuario($nombre, $ap1, $ap2, $email, $tel, $fecha_nac, $sexo, $altura, $tarifa, $passwd, $patologias, $aversiones)));
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
