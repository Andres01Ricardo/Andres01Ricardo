<?php

require_once("../../php/restrict.php");
include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota");
 


$codigocliente=$_POST["codigoClienteCambiar"];
$Datos["etapa"] = $_POST["idEtapa"];

// echo $idActividad;
// echo $Datos["estado"];


	

	$oItem=new Data("t_clientes","codigoCliente",$codigocliente); 
	foreach($Datos  as $key => $value){
	$oItem->$key=$value; 
	}
	$oItem->guardar(); 
	unset($oItem);


	
  header('location: ../../informacionadicional/',$codigocliente);
 ?>
 