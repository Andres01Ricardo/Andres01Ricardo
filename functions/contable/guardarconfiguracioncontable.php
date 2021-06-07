<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );
$banco  = (isset($_REQUEST['banco'] ) ? $_REQUEST['banco'] : "" );


if(!isset($_SESSION)){ session_start(); }


if ($datos["idCuentaContableivaFacturaVenta"]!="") {
   
    $impuestosFacturaVenta["impuesto"]="iva venta";
    $impuestosFacturaVenta["idEmpresa"]=$datos["idEmpresa"];
    $impuestosFacturaVenta["idEmpresaCuenta"]=$datos["idCuentaContableivaFacturaVenta"];
    $impuestosFacturaVenta["naturaleza"]=$datos["naturalezaNuevaIvaVenta"];
    $impuestosFacturaVenta["tipoDocumento"]=$datos["tipoDocumentoIvaVenta"];

    $oItem=new Data("impuesto_cuenta_contable","idImpuestoCuentaContable");  
        foreach($impuestosFacturaVenta  as $keya => $valuea){
            $oItem->$keya=$valuea; 
        }
        $oItem->guardar(); 
        unset($oItem);
}
if ($datos["idCuentaContableRetencionVentas"]!="") {
    $impuestosFacturaVentaR["impuesto"]="retencion venta";
    $impuestosFacturaVentaR["idEmpresa"]=$datos["idEmpresa"];
    $impuestosFacturaVentaR["idEmpresaCuenta"]=$datos["idCuentaContableRetencionVentas"];
    $impuestosFacturaVentaR["naturaleza"]=$datos["naturalezaNuevaRetencionVenta"];
    $impuestosFacturaVentaR["tipoDocumento"]=$datos["tipoDocumentoRetencionVentas"];

    $oItem=new Data("impuesto_cuenta_contable","idImpuestoCuentaContable"); 
        foreach($impuestosFacturaVentaR  as $keya => $valuea){
            $oItem->$keya=$valuea; 
        }
        $oItem->guardar(); 
        unset($oItem);
}


if ($datos["idCuentaContableReteicaBucaramangaVenta"]!="") {

    $impuestosFacturaVentaR["impuesto"]="reteica venta";
    $impuestosFacturaVentaR["idEmpresa"]=$datos["idEmpresa"];
    $impuestosFacturaVentaR["idEmpresaCuenta"]=$datos["idCuentaContableReteicaBucaramangaVenta"];
    $impuestosFacturaVentaR["naturaleza"]=$datos["naturalezaNuevaReteicaBucaramangaVenta"];
    $impuestosFacturaVentaR["tipoDocumento"]=$datos["tipoDocumentoReteicaBucaramangaVenta"];

    $oItem=new Data("impuesto_cuenta_contable","idImpuestoCuentaContable"); 

        foreach($impuestosFacturaVentaR  as $keya => $valuea){
            $oItem->$keya=$valuea; 
        }
        $oItem->guardar(); 
        unset($oItem);
}

if ($datos["idCuentaContableIvaCompra"]!="") {
    $impuestosFacturaCompra["impuesto"]="iva Compra";
    $impuestosFacturaCompra["idEmpresa"]=$datos["idEmpresa"];
    $impuestosFacturaCompra["idEmpresaCuenta"]=$datos["idCuentaContableIvaCompra"];
    $impuestosFacturaCompra["naturaleza"]=$datos["naturalezaNuevaIvaCompra"];
    $impuestosFacturaCompra["tipoDocumento"]=$datos["tipoDocumentoIvaCompra"];

    $oItem=new Data("impuesto_cuenta_contable","idImpuestoCuentaContable");  

        foreach($impuestosFacturaCompra  as $keya => $valuea){

            $oItem->$keya=$valuea; 

        }

        $oItem->guardar(); 



        unset($oItem);
}
if ($datos["idCuentaContableRetencionCompra"]!="") {

    $impuestosFacturaCompraR["impuesto"]="retencion Compra";
    $impuestosFacturaCompraR["idEmpresa"]=$datos["idEmpresa"];
    $impuestosFacturaCompraR["idEmpresaCuenta"]=$datos["idCuentaContableRetencionCompra"];
    $impuestosFacturaCompraR["naturaleza"]=$datos["naturalezaNuevaRetencionCompra"];
    $impuestosFacturaCompraR["tipoDocumento"]=$datos["tipoDocumentoRetencionCompra"];

    $oItem=new Data("impuesto_cuenta_contable","idImpuestoCuentaContable"); 

        foreach($impuestosFacturaCompraR  as $keya => $valuea){

            $oItem->$keya=$valuea; 

        }
        $oItem->guardar(); 
        unset($oItem);

}

if ($datos["idCuentaContableReteicaBucaramangaCompra"]!="") {

    $impuestosFacturaCompraR["impuesto"]="reteica Compra";
    $impuestosFacturaCompraR["idEmpresa"]=$datos["idEmpresa"];
    $impuestosFacturaCompraR["idEmpresaCuenta"]=$datos["idCuentaContableReteicaBucaramangaCompra"];
    $impuestosFacturaCompraR["naturaleza"]=$datos["naturalezaNuevaReteicaBucaramangaCompra"];
    $impuestosFacturaCompraR["tipoDocumento"]=$datos["tipoDocumentoReteicaBucaramangaCompra"];

    $oItem=new Data("impuesto_cuenta_contable","idImpuestoCuentaContable"); 
        foreach($impuestosFacturaCompraR  as $keya => $valuea){
            $oItem->$keya=$valuea; 
        }
        $oItem->guardar(); 
        unset($oItem);
}
 

    foreach ($banco as $key => $value) {
        if ($value["idCuentaContable"]!="") {
                $bancoC["idCuentaBancaria"]=$value["idCuenta"];
                $bancoC["idEmpresa"]=$datos["idEmpresa"];
                $bancoC["idEmpresaCuenta"]=$value["idCuentaContable"];
                 $oItem=new Data("banco_cuenta_contable","idBancoCuentaContable"); 
                foreach($bancoC  as $keyEC => $valueEC){
                    $oItem->$keyEC=$valueEC; 
                }
                $oItem->guardar(); 
                unset($oItem);
            }
        
    }
        

if ($datos["idCuentaContableTotalPagarVenta"]) {

    $ventaCuentaContable["concepto"]="TotalPagarVenta";
    $ventaCuentaContable["idEmpresa"]=$datos["idEmpresa"];
    $ventaCuentaContable["idEmpresaCuenta"]=$datos["idCuentaContableTotalPagarVenta"];
    $ventaCuentaContable["naturaleza"]=$datos["naturalezaNuevaTotalPagarVenta"];
    $ventaCuentaContable["tipoDocumento"]=$datos["tipoDocumentoTotalPagarVenta"];

    $oItem=new Data("venta_cuenta_contable","idVentaCuentaContable"); 
        foreach($ventaCuentaContable  as $keya => $valuea){
            $oItem->$keya=$valuea; 
        }
        $oItem->guardar(); 
        unset($oItem);
}

if ($datos["idCuentaContableTotalPagarCompra"]!="") {
    $compraCuentaContable["concepto"]="TotalPagarCompra";
    $compraCuentaContable["idEmpresa"]=$datos["idEmpresa"];
    $compraCuentaContable["idEmpresaCuenta"]=$datos["idCuentaContableTotalPagarCompra"];
    $compraCuentaContable["naturaleza"]=$datos["naturalezaNuevaTotalPagarCompra"];
    $compraCuentaContable["tipoDocumento"]=$datos["tipoDocumentoTotalPagarCompra"];

    $oItem=new Data("compra_cuenta_contable","idCompraCuentaContable"); 

        foreach($compraCuentaContable  as $keya => $valuea){
            $oItem->$keya=$valuea; 
        }
        $oItem->guardar(); 
        unset($oItem);
}

       $msg=true; 


    echo json_encode(array("msg"=>$msg));

?>