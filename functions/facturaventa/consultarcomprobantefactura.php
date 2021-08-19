<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");
include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");
include_once($CLASS . "control.php");

require_once("../../class/facturaventa.php"); 

date_default_timezone_set("America/Bogota"); 

$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );

date_default_timezone_set("America/Bogota"); 

if(!isset($_SESSION)){ session_start(); }

$oParametro=new FacturaVenta(); 
$dParametro=$oParametro->getFacturaComprobante($idEmpresa);


echo json_encode($dParametro);

?>