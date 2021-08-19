<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

require_once("../../class/comprobantes.php"); 


$idComprobanteRecurrente  = (isset($_REQUEST['idComprobanteRecurrente'] ) ? $_REQUEST['idComprobanteRecurrente'] : "" );



$oLista=new Data("comprobante_recurrente","idComprobanteRecurrente",$idComprobanteRecurrente);
$aComprobanteR=$oLista->getDatos();
unset($oLista);


$oLista=new Comprobantes();
$aComprobante = $oLista->getComprobanteItems($aComprobanteR["idComprobante"]);
unset($oLista);

// $oLista=new Lista("comprobante_items");
// $oLista->setFiltro("idComprobante","=",$aComprobanteR["idComprobante"]);
// $aComprobante=$oLista->getLista();
// unset($oLista);

echo json_encode($aComprobante);

?>
