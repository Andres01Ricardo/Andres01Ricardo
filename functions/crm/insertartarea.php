<?php
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

$codigocliente=$_POST["codigocliente"];

date_default_timezone_set("America/Bogota");
 
// $codigocliente;

$aDatos["fechaCreacion"]=$_POST["fecha"]; 
$aDatos["horaCreacion"]=$_POST["hora"]; 
$aDatos["creador"]=$_POST["creador"];
$aDatos["encargado"]=$_POST["empleadoEncargado"];
$aDatos["vencimiento"]=$_POST["vencimiento"];
$aDatos["motivo"]=$_POST["tarea"];
$aDatos["idCliente"]=$_POST["codigocliente"];
$aDatos["tipo"]="tarea";
$aDatos["icono"]="4";
$aDatos["estado"]="pendiente";

$oItem=new Data("actividades","idActividad"); 
    foreach($aDatos  as $key => $value){
        $oItem->$key=$value; 
    }
    $oItem->guardar(); 
    $codigo=$oItem->ultimoId(); 
    unset($oItem);
  header('location: ../../tareas/',$codigocliente);
 ?>
 