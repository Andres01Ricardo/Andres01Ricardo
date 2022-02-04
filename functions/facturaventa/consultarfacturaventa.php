<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");
include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");
include_once($CLASS . "control.php");

require_once("../../class/facturaventa.php"); 

date_default_timezone_set("America/Bogota"); 

$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );

$nroFactura  = (isset($_REQUEST['nroFactura'] ) ? $_REQUEST['nroFactura'] : "" );

date_default_timezone_set("America/Bogota"); 

if(!isset($_SESSION)){ session_start(); }


$oLista=new Lista("factura_venta");
$oLista->setFiltro("idEmpresa","=",$idEmpresa);
$oLista->setFiltro("nroFactura","=",$nroFactura);
$factura=$oLista->getLista();
unset($oLista);

if (empty($factura)) {
	$msg=true;
}

if (!empty($factura)) {
	$msg=false;
}


echo json_encode(array("msg"=>$msg));

?>