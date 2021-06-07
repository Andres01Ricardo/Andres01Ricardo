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

        $oItem=new Data("cliente","idCliente",$fDatos["idCliente"]); 

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






// $oLista=new Lista("venta_cuenta_contable");
//     $oLista->setFiltro("concepto","=",'PagoVenta');
//     $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
//     $aCC=$oLista->getLista();


// if (!empty($aCC)) {

// $tipo=$aCC[0]["tipoDocumento"];
// $t=explode("-", $tipo);
// $oItem=new Lista("tipos_documento_contable");
// $aLetra=$oItem->getLista();
// unset($oItem);
// $letra=$t[0];
// // print_r($t[0]);
// // print_r($aLetra);
// foreach ($aLetra as $keyL => $valueL) {
//     if ($valueL["letra"]==$letra) {
//         $idT=$valueL["idTiposDocumento"];
//     }
// }



// $oLista=new Lista("parametros_documentos");
// $oLista->setFiltro("tipo","=",$idT);
// $oLista->setFiltro("comprobante","=",$t[1]);
// $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
// $aNumero=$oLista->getLista();
// unset($oLista);


// $numeroComprobante=intval($aNumero[0]["numeracionActual"]);



// $aDatos["idTipo"]=$idT; 

// $aDatos["comprobante"]=$t[1]; 

// $aDatos["fecha"]=$datos["fechaPagoReal"]; 

// $aDatos["fechaRegistro"]=date('Y-m-d'); 

// $aDatos["usuarioRegistra"]=$_SESSION["idUsuario"]; 

// $aDatos["archivo"]=$sFoto; 

// $aDatos["observaciones"]='Factura de venta No. '.$datos["nroFactura"]; 

// $aDatos["idEmpresa"]=$datos["idEmpresa"]; 

// $aDatos["numero"]=$numeroComprobante; 

// $oItem=new Data("comprobante","idComprobante"); 

// foreach($aDatos  as $key => $value){

//     $oItem->$key=$value; 

// }

// $oItem->guardar(); 

// $idComprobante=$oItem->ultimoId(); 

// unset($oItem);


// $nCom["numeracionActual"]=$numeroComprobante+1;

// $oItem=new Data("parametros_documentos","idParametrosDocumentos",$aNumero[0]["idParametrosDocumentos"]); 

// foreach($nCom  as $keyC => $valueC){

//     $oItem->$keyC=$valueC; 

// }

// $oItem->guardar(); 
// unset($oItem);


// $oItem=new Data("cliente","idCliente",$datos["idCliente"]);
// $aCliente=$oItem->getDatos();
// unset($oItem);



//     $concepto='BancoPagoVenta';

//      $oLista=new Lista("venta_cuenta_contable");
//     $oLista->setFiltro("concepto","=",$concepto);
//     $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
//     $aImpuestoCuenta=$oLista->getLista();
//     unset($oLista);

//     $oItem=new Data("empresa_cuenta_contable","idEmpresaCuentaContable",$aImpuestoCuenta[0]["idEmpresaCuenta"]);
//     $aEmpresaCuenta=$oItem->getDatos();
//     unset($oItem);

//     $oItem=new Data("cuenta_contable","idCuentaContable",$aEmpresaCuenta["idCuentaContable"]);
//     $aCuentaContable=$oItem->getDatos();
//     unset($oItem);


//     $oLista=new Lista("banco_cuenta_contable");
//     $oLista->setFiltro("idCuentaBancaria","=",$datos["cuentaBancaria"]);
//     $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
//     $aBanco=$oLista->getLista();
//     unset($oLista);

//     $oItem=new Data("empresa_cuenta_contable","idEmpresaCuentaContable",$aBanco[0]["idEmpresaCuenta"]);
//     $aEmpresaCuentaB=$oItem->getDatos();
//     unset($oItem);

//     $oItem=new Data("cuenta_contable","idCuentaContable",$aEmpresaCuentaB["idCuentaContable"]);
//     $aCuentaContableB=$oItem->getDatos();
//     unset($oItem);


//     if ($aImpuestoCuenta[0]["naturaleza"]==1) {
//         $naturaleza='credito';
//     }
//     if ($aImpuestoCuenta[0]["naturaleza"]==2) {
//         $naturaleza='debito';
//     }
    

//     $aItem["idComprobante"]=$idComprobante; 

//     $aItem["cuenta"]=$aCuentaContableB["codigoCuenta"].'-'.$aCuentaContableB["nombre"]; 

//     $aItem["centroCosto"]=" ";

//     $aItem["tercero"]=$aCliente["nit"].'-'.$aCliente["razonSocial"]; 

//     $aItem["descripcion"]='banco pago factura'; 

//     $aItem["dc"]=$naturaleza; 

//     if ($datos["radioPago"]==1) {
//         $valorPago=$datos["totalPago"]; 
//     }

//     if ($datos["radioPago"]==2) {
//         $valorPago=$datos["abono"]; 
//     }

//     $aItem["valor"]=$valorPago;

//     $aItem["tipoTercero"]="c";


   


//         $oItem=new Data("comprobante_items","idComprobanteItem"); 

//         foreach($aItem  as $keycc => $valuecc){

//             $oItem->$keycc=$valuecc; 

//         }

//         $oItem->guardar(); 

//         unset($oItem);


//      if ($aCuentaContable["naturaleza"]=='credito' and $aItem["dc"]=='debito') {
//          $aCuenta["saldo"]=$aEmpresaCuentaB["saldo"]-str_replace("$", "", str_replace(".", "", $valorPago));
//         }
//         if ($aCuentaContable["naturaleza"]=='credito' and $aItem["dc"]=='credito') {
//          $aCuenta["saldo"]=$aEmpresaCuentaB["saldo"]+str_replace("$", "", str_replace(".", "", $valorPago));
//         }
//         if ($aCuentaContable["naturaleza"]=='debito' and $aItem["dc"]=='debito') {
//              $aCuenta["saldo"]=$aEmpresaCuentaB["saldo"]+str_replace("$", "", str_replace(".", "", $valorPago));
//         }
//         if ($aCuentaContable["naturaleza"]=='debito' and $aItem["dc"]=='credito') {
//          $aCuenta["saldo"]=$aEmpresaCuentaB["saldo"]-str_replace("$", "", str_replace(".", "", $valorPago));
//         }


//         $oItem=new Data("empresa_cuenta_contable","idEmpresaCuentaContable",$aEmpresaCuentaB["idEmpresaCuentaContable"]); 

//         foreach($aCuenta  as $keycc => $valuecc){

//             $oItem->$keycc=$valuecc; 

//         }

//         $oItem->guardar(); 

//         unset($oItem);

//         $aCuentaMovimiento["idUsuarioRegistra"]=$_SESSION["idUsuario"];
//         $aCuentaMovimiento["fecha"]=date("Y-m-d");
//         $aCuentaMovimiento["idEmpresaCuentaContable"]=$aBanco[0]["idEmpresaCuenta"];
//         $aCuentaMovimiento["saldoAnterior"]=$aEmpresaCuentaB["saldo"];
//         if ($aItem["dc"]=="debito") {
//             $aCuentaMovimiento["saldoDebito"]=str_replace("$", "", str_replace(".", "",$valorPago));
//             $aCuentaMovimiento["saldoCredito"]=0;
//         }
//         if ($aItem["dc"]=="credito") {
//             $aCuentaMovimiento["saldoCredito"]=str_replace("$", "", str_replace(".", "",$valorPago));
//             $aCuentaMovimiento["saldoDebito"]=0;
//         }
        
//         $aCuentaMovimiento["naturaleza"]=$naturaleza;
//         $aCuentaMovimiento["saldoNuevo"]=$aCuenta["saldo"];
//         $aCuentaMovimiento["idComprobante"]=$idComprobante;
//         $aCuentaMovimiento["tipoTercero"]="c";
 
//         $oItem=new Data("cuenta_contable_movimientos","idCuentaContableMovimientos"); 
//         foreach($aCuentaMovimiento  as $keycm => $valuecm){
//             $oItem->$keycm=$valuecm; 
//         }
//         $oItem->guardar(); 
//         unset($oItem);



//         $concepto='PagoVenta';

//      $oLista=new Lista("venta_cuenta_contable");
//     $oLista->setFiltro("concepto","=",$concepto);
//     $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
//     $aImpuestoCuenta=$oLista->getLista();

//     $oItem=new Data("empresa_cuenta_contable","idEmpresaCuentaContable",$aImpuestoCuenta[0]["idEmpresaCuenta"]);
//     $aEmpresaCuenta=$oItem->getDatos();
//     unset($oItem);

//     $oItem=new Data("cuenta_contable","idCuentaContable",$aEmpresaCuenta["idCuentaContable"]);
//     $aCuentaContable=$oItem->getDatos();
//     unset($oItem);

//     if ($aImpuestoCuenta[0]["naturaleza"]==1) {
//         $naturaleza='credito';
//     }
//     if ($aImpuestoCuenta[0]["naturaleza"]==2) {
//         $naturaleza='debito';
//     }

//     $aItem["idComprobante"]=$idComprobante; 

//     $aItem["cuenta"]=$aCuentaContable["codigoCuenta"].'-'.$aCuentaContable["nombre"]; 

    
//         $aItem["centroCosto"]=" ";
    
    

//     $aItem["tercero"]=$aCliente["nit"].'-'.$aCliente["razonSocial"]; 

//     $aItem["descripcion"]='pago de la factura'; 

//     $aItem["dc"]=$naturaleza; 

//     $aItem["valor"]=$valorPago; 
//     $aItem["tipoTercero"]="c";


   


//         $oItem=new Data("comprobante_items","idComprobanteItem"); 

//         foreach($aItem  as $keycc => $valuecc){

//             $oItem->$keycc=$valuecc; 

//         }

//         $oItem->guardar(); 

//         unset($oItem);


//      if ($aCuentaContable["naturaleza"]=='credito' and $aItem["dc"]=='debito') {
//          $aCuenta["saldo"]=$aEmpresaCuenta["saldo"]-str_replace("$", "", str_replace(".", "", $valorPago));
//         }
//         if ($aCuentaContable["naturaleza"]=='credito' and $aItem["dc"]=='credito') {
//          $aCuenta["saldo"]=$aEmpresaCuenta["saldo"]+str_replace("$", "", str_replace(".", "", $valorPago));
//         }
//         if ($aCuentaContable["naturaleza"]=='debito' and $aItem["dc"]=='debito') {
//              $aCuenta["saldo"]=$aEmpresaCuenta["saldo"]+str_replace("$", "", str_replace(".", "", $valorPago));
//         }
//         if ($aCuentaContable["naturaleza"]=='debito' and $aItem["dc"]=='credito') {
//          $aCuenta["saldo"]=$aEmpresaCuenta["saldo"]-str_replace("$", "", str_replace(".", "", $valorPago));
//         }


//         $oItem=new Data("empresa_cuenta_contable","idEmpresaCuentaContable",$aEmpresaCuenta["idEmpresaCuentaContable"]); 

//         foreach($aCuenta  as $keycc => $valuecc){

//             $oItem->$keycc=$valuecc; 

//         }

//         $oItem->guardar(); 

//         unset($oItem);


//         $aCuentaMovimiento["idUsuarioRegistra"]=$_SESSION["idUsuario"];
//         $aCuentaMovimiento["fecha"]=date("Y-m-d");
//         $aCuentaMovimiento["idEmpresaCuentaContable"]=$aImpuestoCuenta[0]["idEmpresaCuenta"];
//         $aCuentaMovimiento["saldoAnterior"]=$aEmpresaCuenta["saldo"];
//         if ($aItem["dc"]=="debito") {
//             $aCuentaMovimiento["saldoDebito"]=str_replace("$", "", str_replace(".", "",$valorPago));
//             $aCuentaMovimiento["saldoCredito"]=0;
//         }
//         if ($aItem["dc"]=="credito") {
//             $aCuentaMovimiento["saldoCredito"]=str_replace("$", "", str_replace(".", "",$valorPago));
//             $aCuentaMovimiento["saldoDebito"]=0;
//         }
        
//         $aCuentaMovimiento["naturaleza"]=$naturaleza;
//         $aCuentaMovimiento["saldoNuevo"]=$aCuenta["saldo"];
//         $aCuentaMovimiento["idComprobante"]=$idComprobante;
//         $aCuentaMovimiento["tipoTercero"]="c";
 
//         $oItem=new Data("cuenta_contable_movimientos","idCuentaContableMovimientos"); 
//         foreach($aCuentaMovimiento  as $keycm => $valuecm){
//             $oItem->$keycm=$valuecm; 
//         }
//         $oItem->guardar(); 
//         unset($oItem);


// }


$msg=true; 



echo json_encode(array("msg"=>$msg));

?>