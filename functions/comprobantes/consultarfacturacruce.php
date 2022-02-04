<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

require_once("../../class/comprobantes.php"); 

// include_once("../../class/comprobantes.php");


$idTipoDocumento  = (isset($_REQUEST['idTipoDocumento'] ) ? $_REQUEST['idTipoDocumento'] : "" );
$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );


if ($idTipoDocumento==7) {

	$oLista=new Comprobantes();
	$facturas=$oLista->getFacturaCompra($idEmpresa);
	unset($oLista);
}

if ($idTipoDocumento==15) {
	$oLista=new Comprobantes();
	$facturas=$oLista->getFacturaVenta($idEmpresa);
	unset($oLista);
}


echo json_encode(array("facturas"=>$facturas));

?>
