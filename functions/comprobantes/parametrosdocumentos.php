<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");





$idTipoDocumento  = (isset($_REQUEST['idTipoDocumento'] ) ? $_REQUEST['idTipoDocumento'] : "" );
$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );



$oLista = new Lista('parametros_documentos');

$oLista->setFiltro("tipo","=",$idTipoDocumento);
$oLista->setFiltro("idEmpresa","=",$idEmpresa);

$lista=$oLista->getLista();

$error=true;



echo json_encode(array("comprobante"=>$lista));

?>