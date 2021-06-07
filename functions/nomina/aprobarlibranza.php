<?php

require_once("../../php/restrict.php");
include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");


$idLibranza=$_GET['idLibranza'];

date_default_timezone_set("America/Bogota");
 

$Datos["estadoSolicitud"] = 'Aprobada';

	$oItem=new Data("libranza","idLibranza",$idLibranza); 
	foreach($Datos  as $key => $value){
	$oItem->$key=$value; 
	}
	$oItem->guardar(); 
	unset($oItem);


	
  header('location: ../../verlibranza');
 ?>