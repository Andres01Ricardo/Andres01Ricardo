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

$aData["idNovedades"]=4;

$aData["idUsuarioRegistra"]=$_SESSION["idUsuario"];

$aData["estado"]=1;



$oItem=new Data("empresa_novedad","idEmpresaNovedad"); 

foreach ($aData as $key => $value) {

  $oItem->$key=$value; 

}

$oItem->guardar(); 

$idNovedad=$oItem->ultimoId();

unset($oItem); 



$aHoras["idEmpresaNovedad"]=$idNovedad; 

$aHoras["idEmpleado"]=$datos["idEmpleado"]; 

$aHoras["fechaSolicitud"]=$datos["fechaSolicitud"]; 

$aHoras["tipoPermiso"]=$datos["tipoPermiso"]; 

$aHoras["fechaInicio"]=$datos["fechaInicioVacaciones"]; 

$aHoras["fechaFin"]=$datos["fechaFinalVacaciones"]; 

$aHoras["fechaReinicioActividades"]=$datos["fechaReinicioFunciones"]; 

$aHoras["cantidadDias"]=$datos["totalDias"]; 

$aHoras["estado"]=1;
if ($datos["tipo"]==1) {
	$aHoras["tipo"]='disfrutadas';
}
if ($datos["tipo"]==2) {
	$aHoras["tipo"]='trabajadas';
}



$oItem=new Data("empleado_vacaciones","idEmpleadoVacaciones"); 

foreach ($aHoras as $key => $value) {

  $oItem->$key=$value; 

}

$oItem->guardar(); 

unset($oItem); 





echo json_encode(array("msg"=>true));

?>