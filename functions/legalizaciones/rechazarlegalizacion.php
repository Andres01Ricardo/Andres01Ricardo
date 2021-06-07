<?php
header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");



date_default_timezone_set("America/Bogota"); 


$idLegalizacion=$_GET["idLegalizacion"];
$idUsuario = $_GET["idUsuario"];

if(!isset($_SESSION)){ session_start(); }
 

$Datos["estado"] = 3;

	$oItem=new Data("legalizaciones","idLegalizacion",$idLegalizacion); 
	foreach($Datos  as $key => $value){
	$oItem->$key=$value; 
	}

	$oItem->guardar(); 
	unset($oItem);


	header('location: ../../historiallegalizacion/'.$idUsuario);
	

 ?>