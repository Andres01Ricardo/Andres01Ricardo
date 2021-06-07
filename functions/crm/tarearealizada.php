<?php

require_once("../../php/restrict.php");
include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

$codigocliente=$_POST["codigocliente"];

date_default_timezone_set("America/Bogota");
 


$idActividad = $_POST["idActividad"];
$Datos["estado"] = "realizada";

// echo $idActividad;
// echo $Datos["estado"];


	

	$oItem=new Data("actividades","idActividad",$idActividad); 
	foreach($Datos  as $key => $value){
	$oItem->$key=$value; 
	}
	$oItem->guardar(); 
	unset($oItem);


	
  header('location: ../../llamadas/',$codigocliente);
 ?>
 