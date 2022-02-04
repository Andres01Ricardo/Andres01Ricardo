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
$aData["idNovedades"]=6;
$aData["idUsuarioRegistra"]=$_SESSION["idUsuario"];
$aData["estado"]=1;

$oItem=new Data("empresa_novedad","idEmpresaNovedad"); 
foreach ($aData as $key => $value) {
  $oItem->$key=$value; 
}
$oItem->guardar(); 
$idNovedad=$oItem->ultimoId();
unset($oItem); 


$oLista = new Lista('empleado_informacion_laboral');
$oLista->setFiltro("idEmpresa","=",$_SESSION["idEmpresa"]);
$oLista->setFiltro("idEmpleado","=",$datos["idEmpleado"]);
$lista=$oLista->getLista();
unset($oLista); 


$empleado["valorSalario"]=str_replace("$", "", str_replace(".", "", $datos["valorSalario"]));

$oItem=new Data("empleado_informacion_laboral","idEmpleadoInformacionLaboral",$lista[0]["idEmpleadoInformacionLaboral"]); 
foreach ($empleado as $keyE => $valueE) {
  $oItem->$keyE=$valueE; 
}
$oItem->guardar(); 
unset($oItem); 


$aCambio["idEmpresaNovedad"]=$idNovedad; 
$aCambio["idEmpleado"]=$datos["idEmpleado"]; 
$aCambio["salarioAnterior"]=$lista[0]["valorSalario"]; 
$aCambio["fechaAplicacionCambio"]=$datos["fechaCambioSalario"]; 
$aCambio["nuevoSalario"]=str_replace("$", "", str_replace(".", "", $datos["valorSalario"]));
$aCambio["estado"]=1;

$oItem=new Data("empleado_cambio_salario","idEmpleadoCambioSalario"); 
foreach ($aCambio as $key => $value) {
  $oItem->$key=$value; 
}
$oItem->guardar(); 
unset($oItem); 


echo json_encode(array("msg"=>true));
?>