<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 


$idEliminar=(isset($_REQUEST['idEliminar'] ) ? $_REQUEST['idEliminar'] : "" );





$oItem=new Data("empleado","idEmpleado",$idEliminar); 
$oItem->eliminar(); 
unset($oItem);

$oItem=new Data("empleado_informacion_laboral","idEmpleado",$idEliminar); 
$oItem->eliminar(); 
unset($oItem);

$oItem=new Data("empleado_empresa","idEmpleado",$idEliminar); 
$oItem->eliminar(); 
unset($oItem);

$oItem=new Data("empleado_usuario","idEmpleado",$idEliminar); 
$oItem->eliminar(); 
unset($oItem);






$msg=true; 


echo json_encode(array("msg"=>$msg));

?>