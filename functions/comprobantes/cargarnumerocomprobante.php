<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");





$tipoDocumento  = (isset($_REQUEST['tipoDocumento'] ) ? $_REQUEST['tipoDocumento'] : "" );
$comprobante  = (isset($_REQUEST['comprobante'] ) ? $_REQUEST['comprobante'] : "" );
$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );



// $oLista = new Lista('parametros_documentos');

// $oLista->setFiltro("tipo","=",$idTipoDocumento);
// $oLista->setFiltro("idEmpresa","=",$idEmpresa);

// $lista=$oLista->getLista();

// $error=true;

$oLista=new Lista("parametros_documentos");
$oLista->setFiltro("tipo","=",$tipoDocumento);
$oLista->setFiltro("comprobante","=",$comprobante);
$oLista->setFiltro("idEmpresa","=",$idEmpresa);
$aNumero=$oLista->getLista();
unset($oLista);
// $oLista=new Data("parametros_documentos","idParametrosDocumentos",$comprobante);
// $oLista->setFiltro("tipo","=",$tipoDocumento);
// $oLista->setFiltro("idParametrosDocumentos","=",$comprobante);
// $oLista->setFiltro("idEmpresa","=",$idEmpresa);
// $aNumero=$oLista->getDatos();
// unset($oLista);

echo json_encode(array("comprobanteNumero"=>$aNumero));

?>


