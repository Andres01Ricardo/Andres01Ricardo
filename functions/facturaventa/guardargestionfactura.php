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

$idFacturaVenta=$datos["idFacturaVenta"];

$aDatos["estado"]=2; 

if($datos["comprobante"]!=""){
    if ($datos["abono"]!="") {
        $aDatos["estado"]=4;
    }
    // else{

    // $aDatos["estado"]=3; 
    // }
    $aDatos["fechaPagoReal"]=$datos["fechaPagoReal"]; 

}
if ($datos["radioPago"]==1) {
    $aDatos["saldo"]=0;
    $aDatos["estado"]=3;
    $totalFactura=str_replace("$", "", str_replace(".", "", $datos['totalPago']));
}
if ($datos["radioPago"]==2) {

$oItem=new Data("factura_venta","idFacturaVenta",$datos["idFacturaVenta"]); 
$fDatos=$oItem->getDatos(); 
$totalFactura=str_replace("$", "", str_replace(".", "", $datos['totalPago']));
unset($oItem);
$totalAbono=str_replace("$", "", str_replace(".", "", $datos["abono"]));
    $aDatos["saldo"]=floatval($totalFactura) - floatval( $totalAbono);



    $abonos["valor"]=floatval($totalAbono);
    $abonos["fechaRegistro"]=date("Y-m-d H:i:s");
    $abonos["idUsuarioRegistra"]=$_SESSION["idUsuario"];
    $abonos["idFacturaVenta"]=$datos["idFacturaVenta"];
    $abonos["comprobanteIngreso"]=$datos["comprobante"];
    
    $oItem=new Data("factura_venta_abono","idFacturaVentaAbono"); 

    foreach ($abonos as $keyA => $valueA) {

        $oItem->$keyA=$valueA; 

    }

    $oItem->guardar(); 

    unset($oItem);




}

$oItem=new Data("factura_venta","idFacturaVenta",$datos["idFacturaVenta"]); 

foreach ($aDatos as $key => $value) {

    $oItem->$key=$value; 

}

$oItem->guardar(); 

unset($oItem);




foreach ($item as $key => $value) {

    $aItem["idProductoServicio"]=$value["idProducto"]; 

    $aItem["detalleProducto"]=$value["producto"]; 

     $aItem["idFacturaVenta"]= $datos["idFacturaVenta"];

     $aItem["descripcion"]=$value["descripcion"];


     $aItem["cantidad"]=$value["cantidad"];
     $aItem["idUnidad"]=$value["idUnidad"];
     $aItem["valorUnitario"]=str_replace("$", "", str_replace(".", "", $value["valorUnitario"]));
     $aItem["subtotal"]=str_replace("$", "", str_replace(".", "", $value["subtotal"]));
     $aItem["iva"]=$value["iva"];
     $aItem["total"]=str_replace("$", "", str_replace(".", "", $value["total"]));

    $oItem=new Data("factura_venta_item","idFacturaVentaItem",$value["idFacturaVentaItem"]); 

    foreach($aItem  as $key => $valor){

        $oItem->$key=$valor; 

    }
    

    $oItem->guardar(); 

    unset($oItem);

}


// $oItem=new Data("factura_venta_gestion","idFacturaVentaGestion"); 

// foreach($aGestion  as $key => $value){

//     $oItem->$key=$value; 

// }

// $oItem->guardar(); 

// unset($oItem);










$oItem=new Data("factura_venta_gestion","idFacturaVenta",$idFacturaVenta);
$gestionExiste=$oItem->getDatos();
unset($oItem);


 



$aGestion["fechaRegistro"]=date("Y-m-d H:i:s"); 

$aGestion["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 

$aGestion["totalDeduccion"]=str_replace("$", "", str_replace(".", "", $datos["totalDeduccion"]));

$aGestion["valorAmortizacion"]=str_replace("$", "", str_replace(".", "", $datos["amortizacion"]));

$aGestion["totalPagar"]=str_replace("$", "", str_replace(".", "", $datos["totalPago"]));

$aGestion["comprobanteIngreso"]=$datos["comprobante"]; 



if (!empty($gestionExiste)) {
    $oItem=new Data("factura_venta_gestion","idFacturaVenta",$idFacturaVenta);

    foreach($aGestion  as $keyfcg => $valuefcg){

        $oItem->$keyfcg=$valuefcg; 

    }

    $oItem->guardar(); 

    unset($oItem);
}
if (empty($gestionExiste)) {
    $aGestion["idFacturaVenta"]=$datos["idFacturaVenta"]; 

    $oItem=new Data("factura_venta_gestion","idFacturaVentaGestion"); 

    foreach($aGestion  as $keyfcg => $valuefcg){

        $oItem->$keyfcg=$valuefcg; 

    }

    $oItem->guardar(); 

    unset($oItem);
}







foreach ($impuesto as $key => $value) {

    $aImpuesto["idFacturaVenta"]=$datos["idFacturaVenta"]; 

    $aImpuesto["tipoDeduccion"]=$value["tipoDeduccion"]; 

    if($value["idConcepto"]!=""){

        $aImpuesto["idConcepto"]=$value["idConcepto"]; 

    }

    if($value["baseImpuestos"]!=""){

        $aImpuesto["baseImpuestos"]=$value["baseImpuestos"]; 

    }

    $aImpuesto["concepto"]=$value["concepto"]; 

    $aImpuesto["valor"]=$value["valor"]; 





    $oItem=new Data("factura_venta_deduccion","idFacturaVentaDeduccion"); 

    foreach($aImpuesto  as $key => $valor){

        $oItem->$key=$valor; 

    }

    $oItem->guardar();
    

    unset($oItem);

}


if ($datos["cuentaBancaria"]!="" or $datos["caja"]!="") {
    
         $oItem=new Data("factura_venta","idFacturaVenta",$datos["idFacturaVenta"]); 
        $fDatos=$oItem->getDatos(); 
        unset($oItem);
if ($datos["radioPago"]==1) {
        $totalFactura=$totalFactura;

}
if ($datos["radioPago"]==2) {
    $totalFactura=$totalAbono;
}


if ($datos["formaPago"]==1) {
    $oItem=new Data("cuenta_bancaria","idCuentaBancaria",$datos["cuentaBancaria"]); 
    $idCuenta=$datos["cuentaBancaria"];
    
}
if ($datos["formaPago"]==2) {
    $oItem=new Data("cuenta_bancaria","idCuentaBancaria",$datos["caja"]);
    $idCuenta=$datos["caja"]; 
    
}
    


         

        $cuentaDatos=$oItem->getDatos(); 

        $saldoActual=$cuentaDatos["saldoActual"];

        $nuevoSaldo=$saldoActual + $totalFactura;
        $cuatropormil=$cuentaDatos['aplicaCuatroMil'];
        unset($oItem);

        $oItem=new Data("tercero","idTercero",$fDatos["idCliente"]); 

        $clienteDatos=$oItem->getDatos(); 
        unset($oItem);


        $bDatos["idCuentaBancaria"]=$idCuenta;
        $bDatos["idTipoMovimiento"]=3;
        $bDatos["fechaRegistro"]=date("Y-m-d H:i:s");
        $bDatos["valorIngreso"]=$totalFactura;
        $bDatos["valorEgreso"]=0;  
        $bDatos["saldoAnterior"]=$saldoActual;
        $bDatos["saldoActual"]=$nuevoSaldo;
        $bDatos["descripcionMovimiento"]='pago de factura '.$fDatos["nroFactura"].' del cliente '.$clienteDatos["razonSocial"]; 

        $oItem=new Data("cuenta_bancaria_movimientos","idCuentaBancariaMovimientos"); 
            foreach($bDatos  as $key => $value){
                $oItem->$key=$value; 
            }
            $oItem->guardar(); 
           
            unset($oItem);


           

        $oItem=new Data("cuenta_bancaria","idCuentaBancaria",$idCuenta); 

        $oItem->saldoActual=$nuevoSaldo; 

        $oItem->guardar(); 
        

        unset($oItem);
        
}








if ($datos["radioPago"]==1) {
    $totalFactura=$totalFactura;
    $descripcionPago='Pago';
    $estado=3;
}
if ($datos["radioPago"]==2) {
    $totalFactura=$totalAbono;
    $descripcionPago='Abono';
    $estado=4;
}

    $oLista=new Lista("compra_cuenta_contable");
    $oLista->setFiltro("concepto","=",'1');
    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
    $oLista->setFiltro("tipoFactura","like",'venta');
    $aCC=$oLista->getLista();

if (!empty($aCC)) {
    if ($datos["radioEnlazar"]==1) {


        if (!empty($datos["cuentaContableTotal"])) {
            $oLista=new Lista("compra_cuenta_contable");
            $oLista->setFiltro("concepto","=",'1');
            $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
            $oLista->setFiltro("tipoFactura","=",'venta');
            $oLista->setFiltro("idEmpresaCuenta","=",$datos["cuentaContableTotal"]);
            $aCCT=$oLista->getLista();
            unset($oLista);
            $tipoDocumentoTotal=$aCCT[0]['tipoDocumento'];
        }
        if (empty($datos["cuentaContableTotal"])) {
            
            // $idCuentaContableTotal=$aCC[0]["idEmpresaCuenta"];
            $tipoDocumentoTotal=$aCC[0]['tipoDocumento'];
        }    
    

    $oLista=new Lista("parametros_documentos");
    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
    $oLista->setFiltro("idParametrosDocumentos","=",$tipoDocumentoTotal);
    $aNumero=$oLista->getLista();
    unset($oLista);
    // print_r($aNumero);

    $numeroComprobante=intval($aNumero[0]["numeracionActual"]);

    $aDatos["idTipo"]=$aNumero[0]["tipo"]; 
    $aDatos["comprobante"]=$aNumero[0]["comprobante"]; 
    $aDatos["fecha"]=$datos["fechaPagoReal"]; 
    $aDatos["fechaRegistro"]=date('Y-m-d'); 
    $aDatos["usuarioRegistra"]=$_SESSION["idUsuario"]; 
    $aDatos["archivo"]=$sFoto; 
    $aDatos["observaciones"]='Factura de venta No. '.$datos["nroFactura"]; 
    $aDatos["idEmpresa"]=$datos["idEmpresa"]; 
    $aDatos["numero"]=$numeroComprobante; 

    
    $oItem=new Data("comprobante","idComprobante"); 
    foreach($aDatos  as $key => $value){
        $oItem->$key=$value; 
    }
    $oItem->guardar(); 
    $idComprobante=$oItem->ultimoId(); 
    unset($oItem);
    $nCom["numeracionActual"]=$numeroComprobante+1;
    
    $oItem=new Data("parametros_documentos","idParametrosDocumentos",$aNumero[0]["idParametrosDocumentos"]); 
    foreach($nCom  as $keyC => $valueC){
        $oItem->$keyC=$valueC; 
    }
    $oItem->guardar(); 
    unset($oItem);
        
    }

    if ($datos["radioEnlazar"]==2) {
        $idComprobante=$datos["enlazarFactura"];

        $oItem=new Data("comprobante","idComprobante",$idComprobante); 
        $aComprobanteConsulta=$oItem->getDatos();
        unset($oItem);

        $aDatos["observaciones"]=$aComprobanteConsulta["observaciones"].' y '.$datos["nroFactura"]; 

        $oItem=new Data("comprobante","idComprobante",$idComprobante); 
        foreach($aDatos  as $key => $value){
            $oItem->$key=$value; 
        }
        $oItem->guardar(); 
        unset($oItem);
    }

        if ($datos['formaPago']==1) {
            $idCuentaB=$datos["cuentaBancaria"];
        }
        if ($datos['formaPago']==2) {
            $idCuentaB=$datos["caja"];
        }

        $oLista=new Lista("banco_cuenta_contable");
        $oLista->setFiltro("idCuentaBancaria","=",$idCuentaB);
        $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
        $aBanco=$oLista->getLista();
        unset($oLista);

     
        $oItem=new Data("cuenta_contable","idCuentaContable",$aBanco[0]["idEmpresaCuenta"]);
        $aCuentaContableB=$oItem->getDatos();
        unset($oItem);
        
        $aItem["idComprobante"]=$idComprobante; 
        $aItem["idCuentaContable"]=$aBanco[0]["idEmpresaCuenta"];
        $aItem["idCentroCosto"]=" ";
        $aItem["idTercero"]=$datos["idCliente"];
        $aItem["descripcion"]=$aCuentaContableB["nombre"]; 
        $aItem["naturaleza"]='debito';
        $aItem["tipoTercero"]='p';
        if ($datos["radioPago"]==1) {
            $valorPago=$datos["totalPago"]; 
        }
        if ($datos["radioPago"]==2) {
            $valorPago=$datos["abono"]; 
        }
        $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aItem["fecha"]=$datos["fechaPagoReal"]; 
        $aItem["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$valorPago)));
        $aItem["saldoCredito"]=0;
        $aItem["base"]=0;

        $oItem=new Data("comprobante_items","idComprobanteItem"); 
            foreach($aItem  as $keycc => $valuecc){
                $oItem->$keycc=$valuecc; 
            }
            $oItem->guardar(); 
            unset($oItem);


        if (!empty($datos["cuentaContableTotal"])) {       
            $idCuentaContableTotal=$datos["cuentaContableTotal"];
        }
        if (empty($datos["cuentaContableTotal"])) {

            $idCuentaContableTotal=$aCC[0]["idEmpresaCuenta"];
        }

        $aCompra["idComprobante"]=$idComprobante; 
        $aCompra["idCuentaContable"]=$idCuentaContableTotal;
        $aCompra["idCentroCosto"]=" ";
        $aCompra["idTercero"]=$datos["idCliente"];
        $aCompra["descripcion"]=$descripcionPago.' de la factura '.$datos["nroFactura"];
        $aCompra["naturaleza"]='credito';
        $aCompra["tipoTercero"]='p';
        $aCompra["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aCompra["fecha"]=$datos["fechaPagoReal"]; 
        $aCompra["saldoDebito"]=0;
        $aCompra["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$valorPago)));
        $aCompra["base"]=0;

        $oItem=new Data("comprobante_items","idComprobanteItem"); 
        foreach($aCompra  as $keyImpuesto => $valueImpuesto){
            $oItem->$keyImpuesto=$valueImpuesto; 
        }
        $oItem->guardar(); 
        unset($oItem);


        $aFacturaComprobante["idFacturaVenta"]=$idFacturaVenta;
        $aFacturaComprobante["idComprobante"]=$idComprobante;
        $aFacturaComprobante["estado"]=$estado;

        $oItem=new Data("factura_venta_comprobante","idFacturaVentaComprobante"); 
        foreach($aFacturaComprobante  as $keyFC => $valueFC){
            $oItem->$keyFC=$valueFC; 
        }
        $oItem->guardar(); 
        unset($oItem);

    

    }



    


$msg=true; 



echo json_encode(array("msg"=>$msg));

?>