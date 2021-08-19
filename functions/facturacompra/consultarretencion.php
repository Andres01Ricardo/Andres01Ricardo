<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



// require_once("../../class/facturacompra.php"); 



$empresa  = (isset($_REQUEST['empresa'] ) ? $_REQUEST['empresa'] : "" );
$tipoFactura  = (isset($_REQUEST['tipoFactura'] ) ? $_REQUEST['tipoFactura'] : "" );
$idImpuesto  = (isset($_REQUEST['idImpuesto'] ) ? $_REQUEST['idImpuesto'] : "" );

date_default_timezone_set("America/Bogota"); 


// print_r($empresa);
// print_r($tipoFactura);



// $oParametro=new FacturaCompra(); 
// $aProductoCuenta=$oParametro->getCuentaTotal($empresa,$tipoFactura);


// print_r($aProductoCuenta);


$oLista=new Lista("impuesto_cuenta_contable");
$oLista->setFiltro("idEmpresa","=",$empresa);
$oLista->setFiltro("idImpuesto","=",$idImpuesto);
$oLista->setFiltro("tipoFactura","=",$tipoFactura);
$aProductoCuenta=$oLista->getLista();

// $oItem=new Data("cuenta_contable","idCuentaContable",$aProductoCuenta[0]["idEmpresaCuenta"]);
// $aCuentaContable=$oItem->getDatos();
// unset($oItem);






$msg=true; 

echo json_encode($aProductoCuenta);

?>