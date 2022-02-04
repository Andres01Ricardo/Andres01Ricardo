<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");





$tipoDocumento  = (isset($_REQUEST['tipoDocumento'] ) ? $_REQUEST['tipoDocumento'] : "" );
$comprobante  = (isset($_REQUEST['comprobante'] ) ? $_REQUEST['comprobante'] : "" );
$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );
$numero  = (isset($_REQUEST['numero'] ) ? $_REQUEST['numero'] : "" );



// $oLista = new Lista('parametros_documentos');

// $oLista->setFiltro("tipo","=",$idTipoDocumento);
// $oLista->setFiltro("idEmpresa","=",$idEmpresa);

// $lista=$oLista->getLista();

// $error=true;

$oLista=new Lista("comprobante");
$oLista->setFiltro("idTipo","=",$tipoDocumento);
$oLista->setFiltro("comprobante","=",$comprobante);
$oLista->setFiltro("idEmpresa","=",$idEmpresa);
$oLista->setFiltro("numero","=",$numero);
$aComprobante=$oLista->getLista();
unset($oLista);

if (empty($aComprobante)) {
	$msg=true;
}


if (!empty($aComprobante)) {
	$msg=false;
}



echo json_encode(array("comprobante"=>$msg));

?>


