<?php
header("content-type: text/plain"); // si no es ver html
include_once "clases.php";


$inicial = 1000 * 2;
$porcentaje = 8 / 365;
echo $porcentaje . "\n";
$sumatorio_mensual = 100 * 2;
for ($i = 0; $i < 30; $i++) { //30 años
    for ($j = 0; $j < 12; $j++) { // 12 meses al año
        for ($t = 0; $t < 30; $t++) { // 30 dias al mes
            echo $inicial . "\n";
            $inicial += (($inicial * $porcentaje) / 100);
        }

        $inicial += $sumatorio_mensual;
    }
}

echo $inicial / 2;

die();
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
