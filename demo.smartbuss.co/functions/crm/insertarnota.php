<?php
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

$codigocliente=$_POST["idCliente"];

date_default_timezone_set("America/Bogota");
 
// $codigocliente;

$aDatos["fechaCreacion"]=$_POST["fechaActual"]; 
$aDatos["horaCreacion"]=$_POST["horaActual"]; 
$aDatos["creador"]=$_POST["creador"];
$aDatos["motivo"]=$_POST["nota"];
$aDatos["idCliente"]=$_POST["idCliente"];
$aDatos["tipo"]="nota";
$aDatos["icono"]="3";

$oItem=new Data("actividades","idActividad"); 
    foreach($aDatos  as $key => $value){
        $oItem->$key=$value; 
    }
    $oItem->guardar(); 
    $codigo=$oItem->ultimoId(); 
    unset($oItem);
  header('location: ../../notas/',$codigocliente);
 ?>
 