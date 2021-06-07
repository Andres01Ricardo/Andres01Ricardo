<?php

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

require_once("../../class/dashboard.php"); 


date_default_timezone_set("America/Bogota"); 

$oFacturaVenta=new Dashboard(); 
$dFacturaVentaSumada=$oFacturaVenta->getFacturaVentaSumada();

$oFacturaCompra=new Dashboard(); 
$dFacturaCompraSumada=$oFacturaCompra->getFacturaCompraSumada();

$oGastosOperacionales=new Dashboard(); 
$dGastosOperacionales=$oGastosOperacionales->getGastosOperacionales();


$oGastosOperacionalesVentas=new Dashboard(); 
$dGastosOperacionalesVentas=$oGastosOperacionalesVentas->getGastosOperacionalesVentas();


echo json_encode(array("facturaVentaSumada"=>$dFacturaVentaSumada,"facturaCompraSumada"=>$dFacturaCompraSumada,"gastosOperacionales"=>$dGastosOperacionales,"gastosOperacionalesVentas"=>$dGastosOperacionalesVentas));



?>