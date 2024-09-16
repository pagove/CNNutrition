<?php
header("content-type: text/plain"); // si no es ver html
include_once "clases.php";

$date = date("Y-m-d");
$tc = 22;
$obd = Conexion::conecta();
print_r($obd->insert("ClientesMes", array("totalClientes" => $tc, "fecha" => $date), "id"));

die();
$a = array("codigo" => 0);

print_r(array_key_exists("codigo", $a));

die();
print_r(SendEmail::send("pablogomve@gmail.com", "Prueba1", "HOLA"));

die();
$date = date("Y-m-d");
$tc = 22;
$obd = Conexion::conecta();
print_r($obd->insert("ClientesMes", array("totalClientes" => $tc, "fecha" => $date)));


die();
$obd = Conexion::conecta();
$m = $obd->tableMetaData("Usuarios");
print_r($m["Prueba1"]->Type);
print_r($m);
die();
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
