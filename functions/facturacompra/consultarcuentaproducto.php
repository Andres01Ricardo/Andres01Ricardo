<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();


$producto  = (isset($_REQUEST['producto'] ) ? $_REQUEST['producto'] : "" );
$empresa  = (isset($_REQUEST['empresa'] ) ? $_REQUEST['empresa'] : "" );
$tipoFactura  = (isset($_REQUEST['tipoFactura'] ) ? $_REQUEST['tipoFactura'] : "" );

date_default_timezone_set("America/Bogota"); 


$oLista=new Lista("producto_cuenta_contable");
$oLista->setFiltro("idProducto","=",$producto);
$oLista->setFiltro("idEmpresa","=",$empresa);
$oLista->setFiltro("tipoFactura","=",$tipoFactura);
$aProductoCuenta=$oLista->getLista();

$oItem=new Data("cuenta_contable","idCuentaContable",$aProductoCuenta[0]["idEmpresaCuenta"]);
$aCuentaContable=$oItem->getDatos();
unset($oItem);






$msg=true; 

echo json_encode($aProductoCuenta);

?>