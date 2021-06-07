<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );





if(!isset($_SESSION)){ session_start(); }

$oItem=new Data("factura_compra","idFacturaCompra",$datos["idFacturaCompra"]); 
$fDatos=$oItem->getDatos(); 
$totalFactura=$fDatos['total'];
unset($oItem);


$aDatos["estado"]=3; 

$aDatos["fechaPagoReal"]=$datos["fechaPago"]; 

$oItem=new Data("factura_compra","idFacturaCompra",$datos["idFacturaCompra"]); 

foreach ($aDatos as $key => $value) {

    $oItem->$key=$value; 

}

$oItem->guardar(); 

unset($oItem);



$oItem=new Data("factura_compra_gestion","idFacturaCompra",$datos["idFacturaCompra"]); 

$oItem->comprobanteEgreso=$datos["comprobante"]; 

$oItem->guardar(); 

unset($oItem);



$oItem=new Data("cuenta_bancaria","idCuentaBancaria",$datos["cuentaBancaria"]); 

$aDatos=$oItem->getDatos(); 

$saldoActual=$aDatos["saldoActual"];

$nuevoSaldo=$saldoActual - $totalFactura;
$cuatropormil=$aDatos['aplicaCuatroMil'];
unset($oItem);



$bDatos["idCuentaBancaria"]=$datos["cuentaBancaria"];
$bDatos["idTipoMovimiento"]=1;
$bDatos["fechaRegistro"]=date("Y-m-d H:i:s");
$bDatos["valorIngreso"]=0;
$bDatos["valorEgreso"]=$totalFactura;  
$bDatos["saldoAnterior"]=$saldoActual;
$bDatos["saldoActual"]=$nuevoSaldo;
$bDatos["descripcionMovimiento"]='pago de factura '.$datos["numeroFactura"].' del proveedor '.$datos["proveedor"]; 

$oItem=new Data("cuenta_bancaria_movimientos","idCuentaBancariaMovimientos"); 
    foreach($bDatos  as $key => $value){
        $oItem->$key=$value; 
    }
    $oItem->guardar(); 
   
    unset($oItem);


if ($cuatropormil==1) {

	$valorcuatromil = $totalFactura*4/1000;
	$nuevoSaldoActual = $nuevoSaldo - $valorcuatromil;
	$bDatos["idCuentaBancaria"]=$datos["cuentaBancaria"];
	$bDatos["idTipoMovimiento"]=1;
	$bDatos["fechaRegistro"]=date("Y-m-d H:i:s");
	$bDatos["valorIngreso"]=0;
	$bDatos["valorEgreso"]=$valorcuatromil;  
	$bDatos["saldoAnterior"]=$nuevoSaldo;
	$bDatos["saldoActual"]=$nuevoSaldoActual;
	$bDatos["descripcionMovimiento"]='pago de 4xmil de factura '.$datos["numeroFactura"].' del proveedor '.$datos["proveedor"]; 

$oItem=new Data("cuenta_bancaria_movimientos","idCuentaBancariaMovimientos"); 
    foreach($bDatos  as $key => $value){
        $oItem->$key=$value; 
    }
    $oItem->guardar(); 
     
    unset($oItem);

    $nuevoSaldo = $nuevoSaldoActual;
}


$oItem=new Data("cuenta_bancaria","idCuentaBancaria",$datos["cuentaBancaria"]); 

$oItem->saldoActual=$nuevoSaldo; 

$oItem->guardar(); 

unset($oItem);

$msg=true; 



echo json_encode(array("msg"=>$msg));

?>