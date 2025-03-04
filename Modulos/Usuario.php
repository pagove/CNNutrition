<?php
@session_start();
class Usuario
{

    private static $SYSLOG = "USUARIO";

    /**
     * LOGIN
     */
    public static function compruebaLogin($usr, $passwd)
    {

        $obd = Conexion::conecta();
        $sql = "SELECT id, email, passwd, rol FROM Usuarios WHERE email='$usr' and baja=0";
        $ret = $obd->getObject($sql);
        if (!$ret) {
            return new TRetorno(false, "Usuario/contraseña incorrectos", null, self::$SYSLOG);
        } else {
            if ($ret->passwd == Utilidades::encripta_hash($passwd)) {
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

    /**
     * Datos generales
     */

    public static function getDatosUsuario($id_usuario)
    {
        $obd = Conexion::conecta();
        $sql = "SELECT *
                FROM Usuarios
                WHERE id=$id_usuario";
        return $obd->getObject($sql);
    }

    public static function updateCliente($id_usuario, $nombre, $apellido1, $apellido2, $patologias, $aversiones, $movil, $sexo, $altura, $fechaNacimiento, $id_tarifa)
    {
        $dts = (object)array(
            "nombre" => "'" . $nombre . "'",
            "apellido1" => "'" . $apellido1 . "'",
            "apellido2" => "'" . $apellido2 . "'",
            "patologias" => "'" . $patologias . "'",
            "aversiones" => "'" . $aversiones . "'",
            "movil" => "'" . $movil . "'",
            "sexo" => "'" . $sexo . "'",
            "altura" => $altura,
            "fechaNacimiento" => "'" . $fechaNacimiento . "'",
            "id_tarifa" => $id_tarifa
        );
        $key = (object)array("id" => $id_usuario);
        $obd = Conexion::conecta();
        $ok = $obd->update("Usuarios", $dts, $key);
        $msg = $ok ? "" : $obd->ultimo_error;
        return new TRetorno($ok, $msg, null, self::$SYSLOG);
    }

    /**
     * TARIFA
     */
    public static function getTarifaUsuario($idUsuario)
    {
        $obd = Conexion::conecta();
        $sql = "SELECT t.titulo
                FROM Usuarios u
                INNER JOIN Tarifas t ON u.id_tarifa=t.id
                WHERE u.id=$idUsuario";
        return $obd->get($sql);
    }


    /**
     * DATOS NUTRICIONALES
     */

    /**
     * DATOS GENERALES
     */
    public static function guardarDatosGenerales($id_usuario, $fecha, $peso, $grasa, $musculo)
    {
        $obd = Conexion::conecta();
        $sql = "INSERT INTO DatosGenerales (id_usuario, fecha, peso, grasaAVG, musculoAVG) VALUES ($id_usuario, '$fecha', $peso, $grasa, $musculo)";
        $ok = $obd->ejecuta($sql);
        $msg = $ok ? "" : $obd->ultimo_error;
        return new TRetorno($ok, $msg);
    }
    public static function getDatosNutricionalesGenerales($idUsuario, $cantidad)
    {
        $obd = Conexion::conecta();
        $sql = "SELECT * FROM DatosGenerales WHERE id_usuario=$idUsuario and eliminada <> 1 ORDER BY fecha DESC LIMIT $cantidad";
        return $obd->getAll($sql, "", true);
    }

    public static function eliminaDatoGeneral($id_dato_general)
    {
        $obd = Conexion::conecta();
        $sql = "UPDATE DatosGenerales set eliminada=1 where id=$id_dato_general";
        $ok = $obd->ejecuta($sql);
        $msg = $ok ? "" : $obd->ultimo_error;
        return new TRetorno($ok, $msg);
    }

    /**
     * PLIEGUES CUTANEOS
     */
    public static function getPlieguesCutaneos($idUsuario, $cantidad)
    {
        $obd = Conexion::conecta();
        $sql = "SELECT * FROM PlieguesCutaneos WHERE id_usuario=$idUsuario and eliminada<>'1' ORDER BY fecha DESC LIMIT $cantidad";
        return $obd->getAll($sql, "", true);
    }

    public static function guardarPlieguesCutaneos($id_usuario, $tricipital, $subescapular, $supraliaco, $abdominal, $musloAnterior, $gemelo)
    {
        $obd = Conexion::conecta();
        $fecha = date("Y-m-d");
        $insertStruct = array(
            "id_usuario" => $id_usuario,
            "fecha" => $fecha,
            "tricipital35" => $tricipital,
            "gemelo" => $gemelo,
            "musloAnterior" => $musloAnterior,
            "abdominal" => $abdominal,
            "subescapular" => $subescapular,
            "supraliaco" => $supraliaco
        );
        $ok = $obd->insert("PlieguesCutaneos", $insertStruct);
        $msg = $ok ? "" : $obd->ultimo_error;
        return new TRetorno($ok, $msg, null, self::$SYSLOG);
    }

    public static function eliminarPlieguesCutaneos($id_pliegue)
    {
        $obd = Conexion::conecta();
        $sql = "UPDATE PlieguesCutaneos set eliminada=1 where id=$id_pliegue";
        $ok = $obd->ejecuta($sql);
        $msg = $ok ? "" : $obd->ultimo_error;
        return new TRetorno($ok, $msg);
    }

    /**
     * PERIMETROS
     */

    public static function getPerimetros($idUsuario, $cantidad)
    {
        $obd = Conexion::conecta();
        $sql = "SELECT * FROM Perimetros WHERE id_usuario=$idUsuario and eliminada<>'1' ORDER BY fecha DESC LIMIT $cantidad";
        return $obd->getAll($sql, "", true);
    }

    public static function guardaPerimetros($id_usuario, $cinturaSuperiorAbdominal, $abdominal, $cadera, $muslo, $gemelo, $brazo_contraido, $brazo_relajado)
    {
        $obd = Conexion::conecta();
        $fecha = date("Y-m-d");
        $insertStruct = array(
            "id_usuario" => $id_usuario,
            "fecha" => $fecha,
            "cinturaSuperiorAbdominal" => $cinturaSuperiorAbdominal,
            "abdominal" => $abdominal,
            "cadera" => $cadera,
            "muslo" => $muslo,
            "gemelo" => $gemelo,
            "brazoContraido" => $brazo_contraido,
            "brazoRelajado" => $brazo_relajado
        );
        $ok = $obd->insert("Perimetros", $insertStruct);
        $msg = $ok ? "" : $obd->ultimo_error;
        return new TRetorno($ok, $msg, null, self::$SYSLOG);
    }

    public static function eliminaPerimetros($id_perimetro)
    {
        $obd = Conexion::conecta();
        $sql = "update Perimetros set eliminada='1' where id='$id_perimetro'";
        $ok = $obd->ejecuta($sql);
        $msg = $ok ? "" : $obd->ultimo_error;
        return new TRetorno($ok, $msg);
    }

    /**
     * FUNCIONES GENERALES
     */
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
        $_passwd = Utilidades::encripta_hash($passwd);
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

        $ok = $obd->insert("Usuarios", $insertStruct, "id");
        if ($ok) {
            $ret = self::enviarRGPD($ok, $nombre, $ap1, $ap2, $passwd);
            $ok = $ret->ok;
            return Conexion::autoEndTransaction($ok, "Usuario creado correctamente", $ret->msg, self::$SYSLOG);
        } else {
            return Conexion::autoEndTransaction(false, $obd->ultimo_error, $obd->ultimo_error, self::$SYSLOG);
        }
    }

    /**
     * RGPD
     */
    public static function enviarRGPD($id, $nombre, $ap1, $ap2, $passwd)
    {

        if (DatosConexion::imTest()) {
            $email = "pablogomve@gmail.com";
        }
        $extra_params = Utilidades::encriptar(json_encode((object)array(
            "id" => $id,
            "nombre" => $nombre,
            "ap1" => $ap1,
            "ap2" => $ap2,
            "fecha_envio" => date("Y-m-d H:i:s")
        )));


        $urlWeb =  Utilidades::getUrlWeb();
        $urlCesionDatos = "$urlWeb/PhpFiles/PoliticasPrivacidad.php?param=$extra_params";
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
        return SendEmail::send($email, "Mensaje de bienvenida", "", $html);
    }

    public static function reEnviarRGPD($idUsuario)
    {
        $u = self::getDatosUsuario($idUsuario);
        $passwd = Utilidades::desencriptar($u->passwd);
        return self::enviarRGPD($u->id, $u->nombre, $u->apellido1, $u->apellido2, "");
    }

    public static function getPrivacidad($id_usuario)
    {
        $obd = Conexion::conecta();
        $sql = "select acepta_rgpd,fecha_aceptacion_rgpd,ip_aceptacion_rgpd
                from Usuarios
                where id='$id_usuario'";
        return $obd->getObject($sql);
    }

    public static function setPrivacidad($id_usuario, $ip_usuario)
    {
        $obd = Conexion::conecta();
        $sql = "update Usuarios set acepta_rgpd='1',
                 ip_aceptacion_rgpd='$ip_usuario', fecha_aceptacion_rgpd=CURRENT_TIMESTAMP()
                where id=$id_usuario";
        $filas = 0;
        $ok = $obd->ejecuta2($sql, $filas);
        if ($filas && $ok) {
            return new TRetorno(true, "", array("filas_afectadas" => $filas));
        } else {
            return new TRetorno($ok, $obd->ultimo_error, array("filas_afectadas" => $filas), self::$SYSLOG);
        }
    }
}
