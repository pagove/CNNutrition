<?php
//include_once("Clases/Conexion.php");
//include_once("Clases/Utilidades.php");
//include_once("Clases/TRetorno.php");
//include_once("Clases/Logger.php");
include_once("../clases.php");
session_start();
class Usuario
{

    public static function compruebaLogin($usr, $passwd)
    {
        Logger::haz_log("Cliente_CompruebaLogin", "Comprobando login");
        $obd = Conexion::conecta();
        $sql = "SELECT id, email, passwd, rol FROM Usuarios WHERE email='$usr' and baja=0";
        $ret = $obd->getObject($sql);
        if (!$ret) {
            Logger::haz_log("Cliente_CompruebaLogin", "Usuario no encontrado");
            return new TRetorno(false, "Usuario/contraseña incorrectos");
        } else {
            if ($ret->passwd == Utilidades::encripta($passwd)) {
                $dts = new stdClass();
                $dts->id = $ret->id;
                $dts->rol = $ret->rol;
                $_SESSION["id_usuario"] = $ret->id;
                return new TRetorno(true, "", $dts);
            } else {
                Logger::haz_log("Cliente_CompruebaLogin", "Contraseña incorrecta $usr");
                return new TRetorno(false, "Usuario/contraseña incorrectos");
            }
        }
    }

    public static function cerrarSesion()
    {
        Logger::haz_log("cerrarSesion", "Cerrando sesion");
        $ok = session_destroy();
        if (!$ok) Logger::haz_log("cerrarSesion", "Error cerrando la sesion");
        return new TRetorno($ok, $ok ? "" : "Error cerrando la sesion");
    }

    public static function getDatosGenerales($idUsuario)
    {
        $obd = Conexion::conecta();
        $sql = "SELECT nombre, apellido1, apellido2, email, movil, sexo,altura,patologias, aversiones
                FROM Usuarios
                WHERE id=$idUsuario";
        Logger::haz_log("GOVE", $sql);
        return $obd->getObject($sql);
    }

    public static function getTarifaUsuario($idUsuario)
    {
        $obd = Conexion::conecta();
        $sql = "SELECT t.titulo
                FROM Usuarios u
                INNER JOIN Tarifas t ON u.id_tarifa=t.id
                WHERE u.id=$idUsuario";
        return $obd->get($sql);
    }

    public static function getDatosNutricionalesGenerales($idUsuario)
    {
        $obd = Conexion::conecta();
        $sql = "SELECT * FROM DatosGenerales WHERE id_usuario=$idUsuario and eliminada <> 1 ORDER BY fecha DESC LIMIT 10";
        return $obd->getAll($sql, "", true);
    }

    public static function getPlieguesCutaneos($idUsuario)
    {
        $obd = Conexion::conecta();
        $sql = "SELECT * FROM PlieguesCutaneos WHERE id_usuario=$idUsuario ORDER BY fecha DESC LIMIT 10";
        return $obd->getAll($sql, "", true);
    }

    public static function getPerimetros($idUsuario)
    {
        $obd = Conexion::conecta();
        $sql = "SELECT * FROM Perimetros WHERE id_usuario=$idUsuario ORDER BY fecha DESC LIMIT 10";
        return $obd->getAll($sql, "", true);
    }

    public static function guardarDatosGenerales($id_usuario, $fecha, $peso, $grasa, $musculo)
    {
        $obd = Conexion::conecta();
        $sql = "INSERT INTO DatosGenerales (id_usuario, fecha, peso, grasaAVG, musculoAVG) VALUES ($id_usuario, '$fecha', $peso, $grasa, $musculo)";
        $ok = $obd->ejecuta($sql);
        $msg = $ok ? "" : $obd->ultimo_error;
        return new TRetorno($ok, $msg);
    }

    public static function eliminaDatoGeneral($id_dato_general)
    {
        $obd = Conexion::conecta();
        $sql = "UPDATE DatosGenerales set eliminada=1 where id=$id_dato_general";
        $ok = $obd->ejecuta($sql);
        $msg = $ok ? "" : $obd->ultimo_error;
        return new TRetorno($ok, $msg);
    }

    public static function guardarPlieguesCutaneos($id_usuario, $tricipital, $subescapular, $supraliaco, $abdominal, $musloAnterior, $gemelo) {}

    public static function eliminaPliegueCutaneo($id_usuario, $id_pliegue) {}

    public static function guardaPerimetros($id_usuario, $cinturaSuperiorAbdominal, $abdominal, $cadera, $muslo, $gemelo, $brazoContraido, $brazoRelajado) {}

    public static function eliminaPerimetros($id_usuario, $id_perimetro) {}

    public static function listarUsuarios($nombre, $ap1, $ap2, $email, $tel)
    {
        $obd = Conexion::conecta();
        $query = "";
        $query .= $nombre ? " and LOWER(nombre) like LOWER('%$nombre%') " : "";
        $query .= $ap1 ? " and LOWER(apellido1) like LOWER('%$ap1%') " : "";
        $query .= $ap2 ? " and LOWER(apellido2) like LOWER('%$ap2%') " : "";
        $query .= $email ? " and LOWER(email) like LOWER('%$email%') " : "";
        $query .= $tel ? " and movil=$tel " : "";

        $sql = " select * from Usuarios where true $query";
        Logger::haz_log("GOVE", $sql);
        return $obd->getAll($sql, "", true);
    }
}
