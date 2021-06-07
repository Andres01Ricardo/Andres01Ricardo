<?php

require_once("../../php/restrict.php");
include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota");
 


$codigoetapa=$_POST["codigoEtapaCambiar"];
$Datos["nombreEtapa"] = $_POST["nombreEtapaCambiar"];
$Datos["color"] = $_POST["coloretapacambiar"];




	$oItem=new Data("t_etapas","codigo",$codigoetapa); 
	foreach($Datos  as $key => $value){
	$oItem->$key=$value; 
	}
	$oItem->guardar(); 
	unset($oItem);


	
  header('location: ../../pipeline');
 ?>