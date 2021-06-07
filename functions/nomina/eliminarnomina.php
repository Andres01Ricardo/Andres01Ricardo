<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 


$idEliminar=(isset($_REQUEST['idEliminar'] ) ? $_REQUEST['idEliminar'] : "" );
$tipoNovedad=(isset($_REQUEST['tipoNovedad'] ) ? $_REQUEST['tipoNovedad'] : "" );




$oItem=new Data("nomina","idNomina",$idEliminar); 
$oItem->eliminar(); 
unset($oItem);




$oItem=new Data("nomina_empleado","idNomina",$idEliminar); 

$aDatos=$oItem->getDatos(); 



$idNominaEmpleado=$aDatos["idNominaEmpleado"];

$oItem->eliminar();
unset($oItem);
    
   
$oItem=new Data("nomina_empleado_adiciones","idNominaEmpleado",$idNominaEmpleado); 
$oItem->eliminar(); 
unset($oItem);

$oItem=new Data("nomina_empleado_deducciones","idNominaEmpleado",$idNominaEmpleado); 
$oItem->eliminar(); 
unset($oItem);

$oItem=new Data("nomina_empleado_parafiscales","idNominaEmpleado",$idNominaEmpleado); 
$oItem->eliminar(); 
unset($oItem);

$oItem=new Data("nomina_empleado_provisiones","idNominaEmpleado",$idNominaEmpleado); 
$oItem->eliminar(); 
unset($oItem);





$msg=true; 


echo json_encode(array("msg"=>$msg));

?>