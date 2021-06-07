<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");
include_once($CLASS . "control.php");

$oControl=new Control();

date_default_timezone_set("America/Bogota"); 

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

if(!isset($_SESSION)){ session_start(); }

$aData["idEmpresa"]=$_SESSION["idEmpresa"];
$aData["idEmpleado"]=$datos["idEmpleado"];
$aData["fechaRegistro"]=date("Y-m-d H:i:s");
$aData["idNovedades"]=7;
$aData["idUsuarioRegistra"]=$_SESSION["idUsuario"];
$aData["estado"]=1;

$oItem=new Data("empresa_novedad","idEmpresaNovedad"); 
foreach ($aData as $key => $value) {
  $oItem->$key=$value; 
}
$oItem->guardar(); 
$idNovedad=$oItem->ultimoId();
unset($oItem); 


$aCambio["idEmpresaNovedad"]=$idNovedad; 
$aCambio["idEmpleado"]=$datos["idEmpleado"]; 
$aCambio["idAuxilioExtralegal"]=$datos["idAuxilio"]; 
$aCambio["otroAuxilio"]=$datos["otroAuxilio"]==""?"NULL":$datos["otroAuxilio"]; 
$aCambio["valorAuxilio"]=str_replace("$", "", str_replace(".", "", $datos["valorAuxilio"])); 
$aCambio["estado"]=1;

$oItem=new Data("empleado_auxilios_extralegales","idEmpleadoAuxiliosExtralegales"); 
foreach ($aCambio as $key => $value) {
  $oItem->$key=$value; 
}
$oItem->guardar(); 
unset($oItem); 


echo json_encode(array("msg"=>true));
?>