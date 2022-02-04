<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");
include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");
include_once($CLASS . "control.php");

require_once("../../class/facturaventa.php"); 

date_default_timezone_set("America/Bogota"); 

$documentoEmpleado  = (isset($_REQUEST['documentoEmpleado'] ) ? $_REQUEST['documentoEmpleado'] : "" );


date_default_timezone_set("America/Bogota"); 

if(!isset($_SESSION)){ session_start(); }
	

$oItem=new Data("empleado","numeroDocumento",$documentoEmpleado); 
$aValidate=$oItem->getDatos(); 
unset($oItem); 

if (empty($aValidate)) {

	//no existe el empleado
	$msg=true;
	$empleado="";
}


if (!empty($aValidate)) {

	//ya existe el empleado
	$msg=false;
	$empleado=$aValidate;
}

	


echo json_encode(array("msg"=>$msg,"empleado"=>$empleado));

?>