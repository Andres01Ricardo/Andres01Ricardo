<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota");

$id  = (isset($_REQUEST['idEmpleado'] ) ? $_REQUEST['idEmpleado'] : "" );

if(!isset($_SESSION)){ session_start(); }

$oLista = new Lista('empleado_informacion_laboral');
$oLista->setFiltro("idEmpleado","=",$id);
$oLista->setFiltro("idEmpresa","=",$_SESSION["idEmpresa"]);
$oLista->setFiltro("estado","=",1);
$lista=$oLista->getLista();
unset($oLista); 

if(!empty($lista)){
	$oItem = new Data('seguridad_social',"idSeguridadSocial", $lista[0]["idFondoCesantias"]);
    $aCesantias=$oItem->getDatos();
    unset($oItem);

    $oItem = new Data('seguridad_social',"idSeguridadSocial", $lista[0]["idFondoPensiones"]);
    $aPension=$oItem->getDatos();
    unset($oItem);

    $oItem = new Data('seguridad_social',"idSeguridadSocial", $lista[0]["idEps"]);
    $aEps=$oItem->getDatos();
    unset($oItem);
}

echo json_encode(array("eps"=>$aEps["nombre"],"pensiones"=>$aPension["nombre"],"cesantias"=>$aCesantias["nombre"]));
?>