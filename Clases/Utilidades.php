<?php

class Utilidades {

    public static function getClienteIp(){
        if(isset($_SERVER['REMOTE_ADDR'])){
            return $_SERVER['REMOTE_ADDR'];
        }
        return false;
    }

    public static function getPID(){
        return getmygid();
    }

    public static function encripta($passwd) {
        return hash("sha256", $passwd, false);
    }
}
?>