<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");


$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );



$oLista=new Lista("comprobante_recurrente");
$oLista->setFiltro("idEmpresa","=",$idEmpresa);
$aComprobanteR=$oLista->getLista();
unset($oLista);


echo json_encode($aComprobanteR);

?>


