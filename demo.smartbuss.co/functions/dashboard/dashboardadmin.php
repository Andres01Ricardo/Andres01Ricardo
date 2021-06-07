<?php
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");
require_once("../../class/empresa.php"); 

$oEmpresa=new Empresa(); 
date_default_timezone_set("America/Bogota"); 

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

	$oLista=new Lista("factura_compra"); 
	$oLista->setFiltro("fechaPago","LIKE",date("Y")."-".str_pad($i, 2, "0", STR_PAD_LEFT)); 
	$oLista->setFiltro("estado","!=",3); 
	$aLista=$oLista->getLista(); 
	unset($oItem);

	$valorC=0;
	foreach ($aLista as $key => $value) {
		$valorC+=$value["subtotal"]; 
	}

	$oLista=new Lista("factura_venta"); 
	$oLista->setFiltro("fechaFactura","LIKE",date("Y")."-".str_pad($i, 2, "0", STR_PAD_LEFT)); 
	$aLista2=$oLista->getLista(); 
	unset($oItem);

	$valorV=0;
	foreach ($aLista2 as $key => $value) {
		$valorV+=$value["subtotal"]; 
	}

	$iFact["periodo"]=date("Y")."-".str_pad($i, 2, "0", STR_PAD_LEFT);
	$iFact["compra"]=$valorC;
	$iFact["venta"]=$valorV;
	$aFacturacion[]=$iFact; 
}
echo json_encode(array("facturacion"=>$aFacturacion));

?>