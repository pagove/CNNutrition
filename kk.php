<?php
include_once("Modulos/Usuario.php");

$host = "192.168.1.3";
$database = "CNutrition";
$strCon = "mysql:host=$host;dbname=$database";

$conFake = new BDMySql($strCon, "root", "mariaDBpasswd1!");
$conReal = Conexion::conecta();


die();
$r = Usuario::getDatosNutricionalesGenerales(1);

var_dump($r);
