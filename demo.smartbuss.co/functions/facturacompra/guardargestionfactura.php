<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );

$impuesto  = (isset($_REQUEST['impuesto'] ) ? $_REQUEST['impuesto'] : "" );





if(!isset($_SESSION)){ session_start(); }



$aDatos["estado"]=2; 

if($datos["comprobante"]!=""){

    $aDatos["estado"]=3; 

    $aDatos["fechaPagoReal"]=$datos["fechaPagoReal"]; 

}

$oItem=new Data("factura_compra","idFacturaCompra",$datos["idFacturaCompra"]); 

foreach ($aDatos as $key => $value) {

    $oItem->$key=$value; 

}

$oItem->guardar(); 

unset($oItem);



foreach ($item as $key => $value) {

    $aItem["idProductoServicio"]=$value["idProducto"]; 

    $aItem["detalleProducto"]=$value["producto"]; 

    $oItem=new Data("factura_compra_item","idFacturaCompraItem",$value["idFacturaCompraItem"]); 

    foreach($aItem  as $key => $valor){

        $oItem->$key=$valor; 

    }

    $oItem->guardar(); 

    unset($oItem);

}



$aGestion["idFacturaCompra"]=$datos["idFacturaCompra"]; 

$aGestion["fechaRegistro"]=date("Y-m-d H:i:s"); 

$aGestion["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 

$aGestion["totalDeduccion"]=$oControl->eliminarMoneda($datos["totalDeduccion"]); 

$aGestion["valorAmortizacion"]=$oControl->eliminarMoneda($datos["amortizacion"]); 

$aGestion["totalPagar"]=$oControl->eliminarMoneda($datos["totalPago"]); 

$aGestion["comprobanteEgreso"]=$datos["comprobante"]; 



$oItem=new Data("factura_compra_gestion","idFacturaCompraGestion"); 

foreach($aGestion  as $key => $value){

    $oItem->$key=$value; 

}

$oItem->guardar(); 

unset($oItem);



foreach ($impuesto as $key => $value) {

    $aImpuesto["idFacturaCompra"]=$datos["idFacturaCompra"]; 

    $aImpuesto["tipoDeduccion"]=$value["tipoDeduccion"]; 

    if($value["idConcepto"]!=""){

        $aImpuesto["idConcepto"]=$value["idConcepto"]; 

    }

    if($value["baseImpuestos"]!=""){

        $aImpuesto["baseImpuestos"]=$value["baseImpuestos"]; 

    }

    $aImpuesto["concepto"]=$value["concepto"]; 

    $aImpuesto["valor"]=$value["valor"]; 





    $oItem=new Data("factura_compra_deduccion","idFacturaCompraDeduccion"); 

    foreach($aImpuesto  as $key => $valor){

        $oItem->$key=$valor; 

    }

    $oItem->guardar(); 

    unset($oItem);

}


if ($datos["cuentaBancaria"]=!"") {
    

$oItem=new Data("factura_compra","idFacturaCompra",$datos["idFacturaCompra"]); 
$fDatos=$oItem->getDatos(); 
$totalFactura=$fDatos['total'];
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
}



$msg=true; 



echo json_encode(array("msg"=>$msg));

?>