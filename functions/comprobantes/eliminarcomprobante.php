<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 


$idEliminar=(isset($_REQUEST['idEliminar'] ) ? $_REQUEST['idEliminar'] : "" );




$oItem=new Data("comprobante","idComprobante",$idEliminar); 
$oItem->eliminar(); 
unset($oItem);


$oLista=new Lista("comprobante_items");
$oLista->setFiltro("idComprobante","=",$idEliminar);
$comprobanteItems=$oLista->getLista();
unset($oLista);
if (!empty($comprobanteItems)) {
	foreach ($comprobanteItems as $key => $value) {
	$oItem=new Data("comprobante_items","idComprobanteItem",$value["idComprobanteItem"]);
	$oItem->eliminar();
	unset($oItem);
	}
}


$oLista=new Lista("cuenta_contable_movimientos");
$oLista->setFiltro("idComprobante","=",$idEliminar);
$movimientos=$oLista->getlista();
unset($oLista);
if (!empty($movimientos)) {
	foreach ($movimientos as $keym => $valuem) {
	$oItem=new Data("cuenta_contable_movimientos","idCuentaContableMovimientos",$valuem["idCuentaContableMovimientos"]);
	$oItem->eliminar();
	unset($oItem);
	}
}


$oItem=new Data("comprobante_recurrente","idComprobante",$idEliminar); 
$oItem->eliminar(); 
unset($oItem);
    


$msg=true; 


echo json_encode(array("msg"=>$msg));

?>