<?php
header("content-type: text/plain"); // si no es ver html
include_once "clases.php";

print_r(Usuario::getDatosGenerales(1));

die();
include_once("Modulos/Usuario.php");

print_r(Usuario::listarUsuarios("", "", "", "", ""));
die();
$host = "192.168.1.3";
$database = "CNutrition";
$strCon = "mysql:host=$host;dbname=$database";

$conFake = new BDMySql($strCon, "root", "mariaDBpasswd1!");
$conReal = Conexion::conecta();


die();
$r = Usuario::getDatosNutricionalesGenerales(1);

var_dump($r);
