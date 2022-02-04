<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");


$empresa  = (isset($_REQUEST['empresa'] ) ? $_REQUEST['empresa'] : "" );
$tipoFactura  = (isset($_REQUEST['tipoFactura'] ) ? $_REQUEST['tipoFactura'] : "" );
$idImpuesto  = (isset($_REQUEST['idImpuesto'] ) ? $_REQUEST['idImpuesto'] : "" );

date_default_timezone_set("America/Bogota"); 



$oLista=new Lista("impuesto_cuenta_contable");
$oLista->setFiltro("idEmpresa","=",$empresa);
$oLista->setFiltro("idImpuesto","=",$idImpuesto);
$oLista->setFiltro("tipoFactura","=",$tipoFactura);
$aProductoCuenta=$oLista->getLista();


$msg=true; 

echo json_encode($aProductoCuenta);

?>