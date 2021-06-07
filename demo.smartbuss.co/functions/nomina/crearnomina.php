<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");
include_once($CLASS . "control.php");

$oControl=new Control();

date_default_timezone_set("America/Bogota"); 

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );
$adiciones  = (isset($_REQUEST['adiciones'] ) ? $_REQUEST['adiciones'] : "" );
$ley  = (isset($_REQUEST['ley'] ) ? $_REQUEST['ley'] : "" );
$deducciones  = (isset($_REQUEST['deducciones'] ) ? $_REQUEST['deducciones'] : "" );

if(!isset($_SESSION)){ session_start(); }

$periodo=explode("-",$datos["periodo"]);
$datos["tiempoPago"]=$datos["tiempoPago"]==""?0:$datos["tiempoPago"]; 

$oLista = new Lista('nomina');
$oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
$oLista->setFiltro("periodoMes","=",$periodo[0]);
$oLista->setFiltro("periodoAnio","=",$periodo[1]);
$oLista->setFiltro("tiempoPago","=",$datos["tiempoPago"]);
$aNomina=$oLista->getLista();
unset($oLista); 

if(!empty($aNomina)){
	$idNomina=$aNomina[0]["idNomina"]; 
}else{
	$aDatos["fechaRegistro"]=date("Y-m-d H:i:s"); 
	$aDatos["idEmpresa"]=$datos["idEmpresa"]; 
	$aDatos["periodoMes"]=$periodo[0]; 
	$aDatos["periodoAnio"]=$periodo[1]; 
	$aDatos["tiempoPago"]=$datos["tiempoPago"]; 
	$aDatos["estado"]=1; 
	$oItem=new Data("nomina","idNomina"); 
	foreach ($aDatos as $key => $value) {
	  $oItem->$key=$value; 
	}
	$oItem->guardar(); 
	$idNomina=$oItem->ultimoId();
	unset($oItem);
}

$oLista = new Lista('nomina_empleado');
$oLista->setFiltro("idNomina","=",$idNomina);
$oLista->setFiltro("idEmpleado","=",$datos["idEmpleado"]);
$aEmpleado=$oLista->getLista();
unset($oLista);

if(!empty($aEmpleado)){
	$msg=false; 
}else{
$aDatosEmpleado["fechaRegistro"]=date("Y-m-d H:i:s"); 
$aDatosEmpleado["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
$aDatosEmpleado["idNomina"]=$idNomina; 
$aDatosEmpleado["idEmpleado"]=$datos["idEmpleado"]; 
$aDatosEmpleado["salarioEmpleado"]=$oControl->eliminarMoneda($datos["salario"]); 
$aDatosEmpleado["valorPagar"]=$oControl->eliminarMoneda($datos["valorPagar"]); 
$oItem=new Data("nomina_empleado","idNominaEmpleado"); 
foreach ($aDatosEmpleado as $key => $value) {
  $oItem->$key=$value; 
}
$oItem->guardar(); 
$idNominaEmpleado=$oItem->ultimoId();
unset($oItem);

foreach($adiciones as $itemAdicion){
	$aAdicion["concepto"]=$itemAdicion["producto"]; 
	$aAdicion["idNominaEmpleado"]=$idNominaEmpleado; 
	$aAdicion["valor"]=$oControl->eliminarMoneda($itemAdicion["valor"]); 
	$oItem=new Data("nomina_empleado_adiciones","idNominaEmpleadoAdiciones"); 
	foreach ($aAdicion as $key => $value) {
	  $oItem->$key=$value; 
	}
	$oItem->guardar(); 
	unset($oItem);
}

foreach($ley as $itemLey){
	$aDeduccion["concepto"]=$itemLey["producto"]; 
	$aDeduccion["idNominaEmpleado"]=$idNominaEmpleado; 
	$aDeduccion["valor"]=$oControl->eliminarMoneda($itemLey["valor"]); 
	$aDeduccion["tipoDeduccion"]=$itemLey["tipoDeduccion"]==1?2:1; 
	$aDeduccion["tipoConcepto"]=$itemLey["tipoConcepto"]; 
	$oItem=new Data("nomina_empleado_parafiscales","idNominaEmpleadoParafiscales"); 
	foreach ($aDeduccion as $key => $value) {
	  $oItem->$key=$value; 
	}
	$oItem->guardar(); 
	unset($oItem);
}

foreach($deducciones as $itemDeduccion){
	$iDeducir["concepto"]=$itemDeduccion["producto"]; 
	$iDeducir["idNominaEmpleado"]=$idNominaEmpleado; 
	$iDeducir["valor"]=$oControl->eliminarMoneda($itemDeduccion["valor"]); 
	$oItem=new Data("nomina_empleado_deducciones","idNominaEmpleadoDeducciones"); 
	foreach ($iDeducir as $key => $value) {
	  $oItem->$key=$value; 
	}
	$oItem->guardar(); 
	unset($oItem);
}
$msg=true;
}
 
echo json_encode(array("msg"=>$msg));
?>