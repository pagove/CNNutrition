<?php
include_once("Modulos/Usuario.php");

$r = Usuario::getDatosNutricionalesGenerales(1);

var_dump($r);
?>