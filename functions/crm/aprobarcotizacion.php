<?php

require_once("../../php/restrict.php");
include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");


$idCotizacion=(isset($_REQUEST['id'] ) ? $_REQUEST['id'] : '' );
$url=$idCotizacion; 
if($idCotizacion==""){
echo '<script>window.history.back()</script>'; 
}

date_default_timezone_set("America/Bogota");
 

$Datos["estado"] = 2;

	$oItem=new Data("cotizacion","idCotizacion",$idCotizacion); 
	foreach($Datos  as $key => $value){
	$oItem->$key=$value; 
	}
	$oItem->guardar(); 
	unset($oItem);


	
  header('location: ../../cotizacion');
 ?>