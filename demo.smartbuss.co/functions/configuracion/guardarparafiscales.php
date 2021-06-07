<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");
include_once($CLASS . "control.php");

date_default_timezone_set("America/Bogota"); 
$oControl=new Control();
$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$oLista = new Lista('aportes_parafiscales');
$oLista->setFiltro("anio","=",$datos["anio"]);
$aListas=$oLista->getLista();
unset($oLista);


$datos["cajaCompensacion"]=$oControl->eliminarMoneda($datos["cajaCompensacion"]);
$datos["riesgo1"]=$oControl->eliminarMoneda($datos["riesgo1"]);
$datos["riesgo2"]=$oControl->eliminarMoneda($datos["riesgo2"]);
$datos["riesgo3"]=$oControl->eliminarMoneda($datos["riesgo3"]);
$datos["riesgo4"]=$oControl->eliminarMoneda($datos["riesgo4"]);
$datos["riesgo5"]=$oControl->eliminarMoneda($datos["riesgo5"]);

if(count($aListas)>0){
$oItem=new Data("aportes_parafiscales","idAportesParafiscales",$aListas[0]["idAportesParafiscales"]); 
}else{
$oItem=new Data("aportes_parafiscales","idAportesParafiscales"); 
}
foreach($datos  as $key => $value){
    $oItem->$key=$value; 
}
$oItem->guardar(); 
unset($oItem);

$msg=true; 

echo json_encode(array("msg"=>$msg));
?>