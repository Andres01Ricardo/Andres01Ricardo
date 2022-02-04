<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

require_once("../../class/comprobantes.php"); 

// include_once("../../class/comprobantes.php");


$idTipoDocumento  = (isset($_REQUEST['idTipoDocumento'] ) ? $_REQUEST['idTipoDocumento'] : "" );
$idTercero  = (isset($_REQUEST['idTercero'] ) ? $_REQUEST['idTercero'] : "" );
$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );


if ($idTipoDocumento==7) {

	$oLista=new Comprobantes();
	$facturas=$oLista->getFacturaCompraTercero($idEmpresa,$idTercero);
	unset($oLista);
}

if ($idTipoDocumento==15) {
	$oLista=new Comprobantes();
	$facturas=$oLista->getFacturaVentaTercero($idEmpresa,$idTercero);
	unset($oLista);
}


echo json_encode(array("facturas"=>$facturas));

?>
