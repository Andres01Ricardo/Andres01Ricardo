<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 


$idFactura=(isset($_REQUEST['idFactura'] ) ? $_REQUEST['idFactura'] : "" );




$oItem=new Data("factura_venta","idFacturaVenta",$idFactura); 
$oItem->eliminar(); 
unset($oItem);


$oItem=new Data("factura_venta_item","idFacturaVenta",$idFactura); 
$oItem->eliminar();
unset($oItem);


$oItem=new Lista("factura_venta_comprobante");
$oItem->setFiltro("idFacturaVenta","=",$idFactura); 
// $oItem->setFiltro("idFacturaVenta","=",$idFactura); 
$facturaVentaComprobante=$oItem->getLista();
unset($oItem);


if (!empty($facturaVentaComprobante)) {
    	foreach ($facturaVentaComprobante as $key => $value) {

    		$oItem=new Data("comprobante","idComprobante",$value["idComprobante"]); 
			$oItem->eliminar(); 
			unset($oItem);


			$oLista=new Lista("comprobante_items");
			$oLista->setFiltro("idComprobante","=",$value["idComprobante"]);
			$comprobanteItems=$oLista->getLista();
			unset($oLista);
			if (!empty($comprobanteItems)) {
				foreach ($comprobanteItems as $keyC => $valueC) {
				$oItem=new Data("comprobante_items","idComprobanteItem",$valueC["idComprobanteItem"]);
				$oItem->eliminar();
				unset($oItem);
				}
			}




    		$oItem=new Data("factura_venta_comprobante","idFacturaVentaComprobante",$value["idFacturaVentaComprobante"]);
    		$oItem->eliminar();
    		unset($oItem);
    	}
    }    




$msg=true; 


echo json_encode(array("msg"=>$msg));

?>