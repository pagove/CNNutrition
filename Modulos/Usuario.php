<?php
include_once("Clases/Conexion.php");
include_once("Clases/Utilidades.php");
include_once("Clases/TRetorno.php");
include_once("Clases/Logger.php");
 Class Usuario {

    public static function compruebaLogin($usr, $passwd){
        $obd = Conexion::conecta();
        $sql = "SELECT id, email, passwd FROM Usuarios WHERE email='$usr' and baja=0";
        $ret = $obd->getAll($sql, "",true);
        if(!$ret){
            Logger::haz_log("Cliente_CompruebaLogin", "Usuario no encontrado");
            return new TRetorno(false, "Usuario/contraseña incorrectos");
        } else {
            if($ret->passwd == Utilidades::encripta($passwd)) {
                Logger::haz_log("Cliente_CompruebaLogin", "Login correcto $usr");
                $dts = new stdClass();
                $dts->id = $ret->id;
                return new TRetorno(true,"", $dts);
            } else {
                Logger::haz_log("Cliente_CompruebaLogin", "Contraseña incorrecta $usr");
                return new TRetorno(false,"Usuario/contraseña incorrectos");

            }
        }
    }
    public static function getDatosGenerales($idUsuario){
        $obd = Conexion::conecta();
        $sql = "SELECT nombre, apellido1, apellido2, email, movil, sexo,altura,patologias, aversiones
                FROM Usuarios
                WHERE id=$idUsuario";
        return $obd->getAll($sql, "",true);
    }
    public static function getTarifaUsuario($idUsuario){
        $obd = Conexion::conecta();
        $sql = "SELECT t.titulo
                FROM Usuarios u
                INNER JOIN Tarifas t ON u.id_tarifa=t.id
                WHERE u.id=$idUsuario";
        return $obd->get($sql);
    }

    public static function getDatosNutricionalesGenerales($idUsuario){
        $obd = Conexion::conecta();
        $sql = "SELECT * FROM DatosGenerales ORDER BY fecha DESC LIMIT 10";
        return $obd->getAll($sql, "",true);
    }

    public static function getPlieguesCutaneos($idUsuario){
        $obd = Conexion::conecta();
        $sql = "SELECT * FROM PlieguesCutaneos ORDER BY fecha DESC LIMIT 10";
        return $obd->getAll($sql, "",true);
    }

    public static function getPerimetros($idUsuario){
        $obd = Conexion::conecta();
        $sql = "SELECT * FROM Perimetros ORDER BY fecha DESC LIMIT 10";
        return $obd->getAll($sql, "",true);
    }

    public static function guardarDatosGenerales($id_usuario, $fecha, $peso, $porcenGrasa, $musculo){
        
    }
    
    public static function eliminaDatoGeneral($id_usuario, $id_datoGeneral){
    
    }
    
    public static function guardarPlieguesCutaneos($id_usuario, $tricipital, $subescapular, $supraliaco, $abdominal, $musloAnterior, $gemelo){
    
    }
    
    public static function eliminaPliegueCutaneo($id_usuario, $id_pliegue){
    
    }
    
    public static function guardaPerimetros($id_usuario, $cinturaSuperiorAbdominal, $abdominal, $cadera, $muslo, $gemelo, $brazoContraido, $brazoRelajado){
    
    }
    
    public static function eliminaPerimetros($id_usuario, $id_perimetro){
        
    }
}