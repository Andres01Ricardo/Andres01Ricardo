<?php

require_once("../../php/restrict.php");
include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

$codigocliente=$_POST["codigocliente"];

date_default_timezone_set("America/Bogota");
 

$aDatos["tipo"]="llamada";
$aDatos["fechaCreacion"]=$_POST["fecha"]; 
$aDatos["horaCreacion"]=$_POST["hora"]; 
$aDatos["motivo"]=$_POST["motivo"];
$aDatos["creador"]=$_POST["creador"];
$aDatos["duracion"]=$_POST["duracion"];
$aDatos["icono"]="1";
$aDatos["idCliente"]=$_POST["codigocliente"];


$aDatos["estado"]=$_POST["radiollamada"];


// echo	$aDatos["tipo"];
// echo	$aDatos["fechaCreacion"];
// echo	$aDatos["horaCreacion"];
// echo	$aDatos["motivo"];
// echo	$aDatos["creador"];
// echo	$aDatos["duracion"];
// echo	$aDatos["icono"];
// echo	$aDatos["idCliente"];

// echo	$aDatos["estado"];

$oItem=new Data("actividades","idActividad"); 
    foreach($aDatos  as $key => $value){
        $oItem->$key=$value; 
    }
    $oItem->guardar(); 
    $codigo=$oItem->ultimoId(); 
    unset($oItem);



if ($_POST["tarea"] != "" and $_POST["empleadoEncargado"] != "" and $_POST["vencimiento"] != "") {
	
	$tDatos["motivo"]=$_POST["tarea"];
	$tDatos["encargado"]=$_POST["empleadoEncargado"];
	$tDatos["vencimiento"]=$_POST["vencimiento"];

	$tDatos["fechaCreacion"]=$_POST["fecha"]; 
	$tDatos["horaCreacion"]=$_POST["hora"]; 
	$tDatos["creador"]=$_POST["creador"];
	$tDatos["tipo"]="tarea";
	$tDatos["icono"]="4";	
	$tDatos["estado"]="pendiente";
    $tDatos["idCliente"]=$_POST["codigocliente"];
	
	$oItem=new Data("actividades","idActividad"); 
    foreach($tDatos  as $key => $value){
        $oItem->$key=$value; 
    }
    $oItem->guardar(); 
    $codigo=$oItem->ultimoId(); 
    unset($oItem);

}	
	$cDatos["fechaUltimoContacto"]=$aDatos["fechaCreacion"];

	$oItem=new Data("t_clientes","codigoCliente",$codigocliente); 
	foreach($cDatos  as $key => $value){
	$oItem->$key=$value; 
	}
	$oItem->guardar(); 
	unset($oItem);


	
  header('location: ../../llamadas/',$codigocliente);
 ?>
 