<?php
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");
require_once("../../class/empresa.php"); 
require_once("../../class/facturacompra.php"); 
require_once("../../class/facturaventa.php"); 
$oEmpresa=new Empresa(); 
date_default_timezone_set("America/Bogota"); 



$oFactura=new FacturaCompra(); 
$oFacturaVenta=new FacturaVenta();

$meses[1]="Enero"; 
$meses[2]="Febrero"; 
$meses[3]="Marzo"; 
$meses[4]="Abril"; 
$meses[5]="Mayo"; 
$meses[6]="Junio"; 
$meses[7]="Julio"; 
$meses[8]="Agosto"; 
$meses[9]="Septiembre"; 
$meses[10]="Octubre"; 
$meses[11]="Noviembre"; 
$meses[12]="Diciembre"; 



for ($i=1; $i <= 12; $i++) {

	$aFacturas=$oFactura->getFacturasRecibidas(array("fecha"=>date("Y")."-".str_pad($i, 2, "0", STR_PAD_LEFT))); 

	$fraCompra=0; 
	foreach($aFacturas as $iFra){
	  $fraCompra+=$iFra["subtotal"]; 
	}

	$fraVenta=0; 
	$aFacturasV=$oFacturaVenta->getFacturasVenta(array("fecha"=>date("Y")."-".str_pad($i, 2, "0", STR_PAD_LEFT)));
	foreach($aFacturasV as $iFra){
	  $fraVenta+=$iFra["subtotal"]; 
	}

	$iFact["periodo"]=date("Y")."-".str_pad($i, 2, "0", STR_PAD_LEFT);
	$iFact["compra"]=$fraCompra;
	$iFact["venta"]=$fraVenta;
	$aFacturacion[]=$iFact; 
}
echo json_encode(array("facturacion"=>$aFacturacion));

?>