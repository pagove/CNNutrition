<?php
session_start();
class Usuario
{

    private static $SYSLOG = "USUARIO";
    public static function compruebaLogin($usr, $passwd)
    {

        $obd = Conexion::conecta();
        $sql = "SELECT id, email, passwd, rol FROM Usuarios WHERE email='$usr' and baja=0";
        $ret = $obd->getObject($sql);
        if (!$ret) {
            return new TRetorno(false, "Usuario/contraseña incorrectos", null, self::$SYSLOG);
        } else {
            if ($ret->passwd == Utilidades::encripta($passwd)) {
                $dts = new stdClass();
                $dts->id = $ret->id;
                $dts->rol = $ret->rol;
                $_SESSION["id_usuario"] = $ret->id;
                return new TRetorno(true, "", $dts, self::$SYSLOG);
            } else {
                return new TRetorno(false, "Usuario/contraseña incorrectos", array("usuario" => $usr, "passwd" => $passwd), self::$SYSLOG);
            }
        }
    }

    public static function cerrarSesion()
    {
        $ok = session_destroy();
        return new TRetorno($ok, $ok ? "" : "Error cerrando la sesion", null, self::$SYSLOG);
    }

    public static function getDatosGenerales($idUsuario)
    {
        $obd = Conexion::conecta();
        $sql = "SELECT nombre, apellido1, apellido2, email, movil, sexo,altura,patologias, aversiones
                FROM Usuarios
                WHERE id=$idUsuario";
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
        return $obd->getAll($sql, "", true);
    }

    public static function registraUsuario($nombre, $ap1, $ap2, $email, $tel, $fecha_nac, $sexo, $altura, $tarifa, $passwd, $patologias, $aversiones)
    {
        Conexion::setAutoBeginTransaction();
        $ok = true;
        $obd = Conexion::conecta();
        $_passwd = Utilidades::encripta($passwd);
        $insertStruct = array(
            "id_tarifa" => intval($tarifa),
            "email" => "$email",
            "passwd" => "$_passwd",
            "nombre" => "$nombre",
            "apellido1" => "$ap1",
            "apellido2" => "$ap2",
            "patologias" => "$patologias",
            "aversiones" => "$aversiones",
            "movil" => "$tel",
            "sexo" => "$sexo",
            "altura" => $altura,
            "fechaNacimiento" => "$fecha_nac",
            "rol" => 1,
            "baja" => 0,
            "changePasswd" => 1
        );

        $ok = $obd->insert("Usuarios", $insertStruct);
        if ($ok) {
            if (DatosConexion::imRemote() || DatosConexion::imTest()) {
                $email = "pablogomve@gmail.com";
            }

            $urlWeb = DatosConexion::imRemote() ? "localhost" : "http://gove.synology.me";
            $urlCesionDatos = DatosConexion::imRemote() ? "localhost/PhpFiles/PoliticasPrivacidad.php" : "http://gove.synology.me/PhpFiles/PoliticasPrivacidad.php";
            $html = "<p>Desde nuestra clínica le damos la bienvenida y agradecemos la confianza que ha depositado en nosotros.<br>
                    Puede consultar sus datos a través de nuestra página web <a href=\"$urlWeb\">CNNutrition</a>-
                    accediendo con usuario y clave: 
                    <ul>
                    <li><b>Usuario:</b>$email</li>
                    <li><b>Contrasea: </b>$passwd</li>
                    </ul>
                    </p>
                    <br>
                    <p>
                    Para que podamos acceder a sus datos es necesario que acepte nuestras <b>políticas de privacidad y cesión de datos</b>
                    haciendo click en el siguiente enlace <a href=\"$urlCesionDatos\">Políticas de privacidad</a>.
                    </p>
                    <p>Un cordial saludo.</p>";

            $ret = SendEmail::send($email, "Mensaje de bienvenida", "", $html);
            $ok = $ok && $ret->ok;
            return Conexion::autoEndTransaction($ok, "Usuario creado correctamente", $ret->msg, self::$SYSLOG);
        } else {
            return Conexion::autoEndTransaction(false, $obd->ultimo_error, $obd->ultimo_error, self::$SYSLOG);
        }
    }
}
