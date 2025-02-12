<?php
include_once("clases.php");


$dts = json_decode(file_get_contents("php://input"), true);
Logger::haz_log("PETICION_BACKEND", var_export($dts, true));

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
    case "reEnviarRGPD":
        reEnviarRGPD($dts["id_usuario"]);
        break;
    case "aceptarTerminosYCondiciones":
        aceptarTerminosYCondiciones($dts["id_usuario"], $dts["ip_usuario"]);
        break;
    case "guardarPlieguesCutaneos":
        guardarPlieguesCutaneos($dts["id_usuario"], $dts["tricipital"], $dts["subescapular"], $dts["supraliaco"], $dts["abdominal"], $dts["muslo_anterior"], $dts["gemelo"]);
        break;
    case "eliminarPlieguesCutaneos":
        eliminarPlieguesCutaneos($dts["id_pliegue"]);
        break;
    case "guardaPerimetros":
        guardaPerimetros(
            $dts["id_usuario"],
            $dts["cinturaSuperiorAbdominal"],
            $dts["abdominal"],
            $dts["cadera"],
            $dts["muslo"],
            $dts["gemelo"],
            $dts["brazo_contraido"],
            $dts["brazo_relajado"]
        );
        break;
    case "eliminaPerimetros":
        eliminaPerimetros($dts["id_perimetro"]);
        break;
    case "updateCliente":
        updateCliente(
            $dts["id_usuario"],
            $dts["nombre"],
            $dts["apellido1"],
            $dts["apellido2"],
            $dts["patologias"],
            $dts["aversiones"],
            $dts["movil"],
            $dts["sexo"],
            $dts["altura"],
            $dts["fechaNacimiento"],
            $dts["id_tarifa"]
        );
        break;
}

function updateCliente($id_usuario, $nombre, $apellido1, $apellido2, $patologias, $aversiones, $movil, $sexo, $altura, $fechaNacimiento, $id_tarifa)
{
    die(json_encode(Usuario::updateCliente($id_usuario, $nombre, $apellido1, $apellido2, $patologias, $aversiones, $movil, $sexo, $altura, $fechaNacimiento, $id_tarifa)));
}

function eliminaPerimetros($id_perimetro)
{
    die(json_encode(Usuario::eliminaPerimetros($id_perimetro)));
}

function guardaPerimetros($id_usuario, $cinturaSuperiorAbdominal, $abdominal, $cadera, $muslo, $gemelo, $brazo_contraido, $brazo_relajado)
{
    die(json_encode(Usuario::guardaPerimetros($id_usuario, $cinturaSuperiorAbdominal, $abdominal, $cadera, $muslo, $gemelo, $brazo_contraido, $brazo_relajado)));
}

function eliminarPlieguesCutaneos($id_pliegue)
{
    die(json_encode(Usuario::eliminarPlieguesCutaneos($id_pliegue)));
}
function guardarPlieguesCutaneos($id_usuario, $tricipital, $subescapular, $supraliaco, $abdominal, $musloAnterior, $gemelo)
{
    die(json_encode(Usuario::guardarPlieguesCutaneos($id_usuario, $tricipital, $subescapular, $supraliaco, $abdominal, $musloAnterior, $gemelo)));
}

function reEnviarRGPD($id_usuario)
{
    die(json_encode(Usuario::reEnviarRGPD($id_usuario)));
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
