<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



// $tipoDocumento  = (isset($_REQUEST['tipoDocumento'] ) ? $_REQUEST['tipoDocumento'] : "" );
// $comprobante  = (isset($_REQUEST['comprobante'] ) ? $_REQUEST['comprobante'] : "" );
$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );



$oLista = new Lista('cuenta_bancaria');
$oLista->setFiltro("idEmpresa","=",$idEmpresa);
$aCuentas=$oLista->getLista();
unset($oLista);


echo json_encode($aCuentas);

?>


