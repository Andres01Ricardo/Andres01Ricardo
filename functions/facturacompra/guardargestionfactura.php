<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");

include("../inventario/listarinventario.php") ; 


$oControl=new Control();

$oInventarios = new Inventario();

date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );

$impuesto  = (isset($_REQUEST['impuesto'] ) ? $_REQUEST['impuesto'] : "" );



if(!isset($_SESSION)){ session_start(); }

$idEmpresa=$datos["idEmpresaFactura"];
$idFacturaCompra=$datos["idFacturaCompra"];

$aDatos["estado"]=2; 

if($datos["comprobante"]!=""){
    if ($datos["abono"]!="") {
        $aDatos["estado"]=4;
    }else{

    $aDatos["estado"]=3; 
    }
    $aDatos["fechaPagoReal"]=$datos["fechaPagoReal"]; 

}
if ($datos["radioPago"]==1) {
    $aDatos["saldo"]=0;
    $totalFactura=str_replace("$", "", str_replace(".", "", $datos['totalPago']));
}
if ($datos["radioPago"]==2) {

$oItem=new Data("factura_compra","idFacturaCompra",$idFacturaCompra); 
$fDatos=$oItem->getDatos(); 
$totalFactura=str_replace("$", "", str_replace(".", "", $datos['totalPago']));
unset($oItem);
$totalAbono=str_replace("$", "", str_replace(".", "", $datos["abono"]));
    $aDatos["saldo"]=floatval($totalFactura) - floatval( $totalAbono);



    $abonos["valor"]=floatval($totalAbono);
    $abonos["fechaRegistro"]=date("Y-m-d H:i:s");
    $abonos["idUsuarioRegistra"]=$_SESSION["idUsuario"];
    $abonos["idFacturaCompra"]=$datos["idFacturaCompra"];
    $abonos["comprobanteEgreso"]=$datos["comprobante"];
    
    $oItem=new Data("factura_compra_abono","idFacturaCompraAbono"); 

    foreach ($abonos as $keyA => $valueA) {

        $oItem->$keyA=$valueA; 

    }

    $oItem->guardar(); 

    unset($oItem);

}

$oItem=new Data("factura_compra","idFacturaCompra",$idFacturaCompra); 

foreach ($aDatos as $key => $value) {

    $oItem->$key=$value; 

}

$oItem->guardar(); 

unset($oItem);



foreach ($item as $key => $value) {
    $oItem=new Data("unidad","idUnidad",$value["idUnidad"]); 

    $aUnidades=$oItem->getDatos(); 
    unset($oItem);

    $aItem["idProductoServicio"]=$value["idProducto"]; 

    $aItem["detalleProducto"]=$value["producto"]; 
    if ($value["agregarInventario"]==1) {
        
        $aInventario =$oInventarios->getInventario(array("idEmpresa"=>$idEmpresa,"idProductoInventario"=>$value["idProducto"]));
        if ($aInventario!='') {
            if ($aInventario[0]["idUnidad"]==$value["idUnidad"]) {        
            $cantidadActual=$aInventario[0]["cantidad"];
            $cantidadNueva = $cantidadActual + $value["cantidad"];
            $aItem["cantidad"]= $cantidadNueva; 
            $oItem=new Data("inventario","idProducto",$aInventario[0]["idProducto"]); 
            foreach($aItem  as $keyin => $valuein){
                $oItem->$keyin=$valuein; 
            }
            $oItem->guardar(); 
            unset($oItem);
            $aMovimiento['tipoMovimiento']=1;
            $aMovimiento['tipoInventario']=$aInventario[0]["tipoInventario"];
            $aMovimiento['fechaRegistro']=date("Y-m-d H:i:s");
            $aMovimiento['cantidadAnterior']=$cantidadActual;
            $aMovimiento['cantidadActual']=$cantidadNueva;
            $aMovimiento['idUsuarioRegistra']=$_SESSION["idUsuario"];
            $aMovimiento['idProducto']=$aInventario[0]["idProducto"];
            $aMovimiento['idEmpresa']=$idEmpresa;
            $oItem=new Data("inventario_movimientos","idInventario_movimientos"); 
            foreach($aMovimiento  as $keym => $valuem){
                $oItem->$keym=$valuem; 
            }
            $oItem->guardar();             
            unset($oItem);
            }else{
                if ($aInventario[0]["unidad"]=='Gramos' and $aUnidades["nombre"]=='Kilo') {
                    $cantidadSumar=$value["cantidad"]*1000;
                }elseif ($aInventario[0]["unidad"]=='Kilo' and $aUnidades["nombre"]=='Gramos') {
                    $cantidadSumar=$value["cantidad"]/1000;
                }elseif ($aInventario[0]["unidad"]=='MiliLitro' and $aUnidades["nombre"]=='Litros') {
                    $cantidadSumar=$value["cantidad"]*1000;
                }elseif ($aInventario[0]["unidad"]=='Litro' and $aUnidades["nombre"]=='MiliLitros') {
                    $cantidadSumar=$value["cantidad"]/1000;
                }
                




            $cantidadActual=$aInventario[0]["cantidad"];
            $cantidadNueva = $cantidadActual + $cantidadSumar;
            $aItem["cantidad"]= $cantidadNueva; 
            $oItem=new Data("inventario","idProducto",$aInventario[0]["idProducto"]); 
            foreach($aItem  as $keyin => $valuein){
                $oItem->$keyin=$valuein; 
            }
            $oItem->guardar(); 
            unset($oItem);
            $aMovimiento['tipoMovimiento']=1;
            $aMovimiento['tipoInventario']=$aInventario[0]["tipoInventario"];
            $aMovimiento['fechaRegistro']=date("Y-m-d H:i:s");
            $aMovimiento['cantidadAnterior']=$cantidadActual;
            $aMovimiento['cantidadActual']=$cantidadNueva;
            $aMovimiento['idUsuarioRegistra']=$_SESSION["idUsuario"];
            $aMovimiento['idProducto']=$aInventario[0]["idProducto"];
            $aMovimiento['idEmpresa']=$idEmpresa;
            $oItem=new Data("inventario_movimientos","idInventario_movimientos"); 
            foreach($aMovimiento  as $keym => $valuem){
                $oItem->$keym=$valuem; 
            }
            $oItem->guardar();             
            unset($oItem);
            }

        }else{
            // print_r('no existe');
        }

    }elseif ($value["agregarInventario"]=='') {
        // print_r('- no seleccionó -');
    }

    $oItem=new Data("factura_compra_item","idFacturaCompraItem",$value["idFacturaCompraItem"]); 

    foreach($aItem  as $key => $valor){

        $oItem->$key=$valor; 

    }

    $oItem->guardar(); 

    unset($oItem);

}

$oItem=new Data("factura_compra_gestion","idFacturaCompra",$idFacturaCompra);
$gestionExiste=$oItem->getDatos();
unset($oItem);


$aGestion["fechaRegistro"]=date("Y-m-d H:i:s"); 

$aGestion["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 

$aGestion["totalDeduccion"]=str_replace("$", "", str_replace(".", "", $datos["totalDeduccion"])); 

$aGestion["valorAmortizacion"]=str_replace("$", "", str_replace(".", "", $datos["amortizacion"])); 

$aGestion["totalPagar"]=str_replace("$", "", str_replace(".", "", $datos["totalPago"])); 

$aGestion["comprobanteEgreso"]=$datos["comprobante"]; 

if (!empty($gestionExiste)) {
    $oItem=new Data("factura_compra_gestion","idFacturaCompra",$idFacturaCompra);

    foreach($aGestion  as $keyfcg => $valuefcg){

        $oItem->$keyfcg=$valuefcg; 

    }

    $oItem->guardar(); 

    unset($oItem);
}
if (empty($gestionExiste)) {
    $aGestion["idFacturaCompra"]=$idFacturaCompra;

    $oItem=new Data("factura_compra_gestion","idFacturaCompraGestion"); 

    foreach($aGestion  as $keyfcg => $valuefcg){

        $oItem->$keyfcg=$valuefcg; 

    }

    $oItem->guardar(); 

    unset($oItem);
}




foreach ($impuesto as $keyimp => $valueimp) {

    if ($valueimp["idFacturaCompraDeduccion"]==0) {

    $aImpuesto["idFacturaCompra"]=$idFacturaCompra; 

    $aImpuesto["tipoDeduccion"]=$valueimp["tipoDeduccion"]; 

    if($value["idConcepto"]!=""){

        $aImpuesto["idConcepto"]=$valueimp["idConcepto"]; 

    }

    if($value["baseImpuestos"]!=""){

        $aImpuesto["baseImpuestos"]=$valueimp["baseImpuestos"]; 

    }

    $aImpuesto["concepto"]=$valueimp["concepto"]; 

    $aImpuesto["valor"]=$valueimp["valor"]; 


    $oItem=new Data("factura_compra_deduccion","idFacturaCompraDeduccion"); 

    foreach($aImpuesto  as $key => $valor){

        $oItem->$key=$valor; 

    }

    $oItem->guardar(); 

    unset($oItem);
    }

}


if ($datos["cuentaBancaria"]!="" or $datos["caja"]!="") {
    
    $oItem=new Data("factura_compra","idFacturaCompra",$idFacturaCompra); 
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

$aDatos=$oItem->getDatos(); 

$saldoActual=$aDatos["saldoActual"];

$nuevoSaldo=$saldoActual - $totalFactura;
$cuatropormil=$aDatos['aplicaCuatroMil'];
unset($oItem);



$bDatos["idCuentaBancaria"]=$idCuenta;
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
    $bDatos["idCuentaBancaria"]=$idCuenta;
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


if ($datos["formaPago"]==1) {
    $oItem=new Data("cuenta_bancaria","idCuentaBancaria",$datos["cuentaBancaria"]); 
}
if ($datos["formaPago"]==2) {
    $oItem=new Data("cuenta_bancaria","idCuentaBancaria",$datos["caja"]);
}


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
    $oLista->setFiltro("tipoFactura","like",'compra');
    $aCC=$oLista->getLista();

if (!empty($aCC)) {

    if ($datos["radioEnlazar"]==1) {


        if (!empty($datos["cuentaContableTotal"])) {
            $oLista=new Lista("compra_cuenta_contable");
            $oLista->setFiltro("concepto","=",'1');
            $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
            $oLista->setFiltro("tipoFactura","like",'compra');
            $oLista->setFiltro("idEmpresaCuenta","=",$datos["cuentaContableTotal"]);
            $aCCT=$oLista->getLista();
            unset($oLista);
            $tipoDocumentoTotal=$aCCT[0]['tipoDocumento'];
        }
        if (empty($datos["cuentaContableTotal"])) {
            $tipoDocumentoTotal=$aCC[0]['tipoDocumento'];
        }

        $oLista=new Lista("parametros_documentos");
        $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
        $oLista->setFiltro("idParametrosDocumentos","=",$tipoDocumentoTotal);
        $aNumero=$oLista->getLista();
        unset($oLista);


        // $oLista=new Lista("parametros_documentos");
        // $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
        // $oLista->setFiltro("tipo","=",'7');
        // $oLista->setFiltro("comprobante","=",'1');
        // $aNumero=$oLista->getLista();
        // unset($oLista);



    $numeroComprobante=intval($aNumero[0]["numeracionActual"]);

    $aDatos["idTipo"]=$aNumero[0]["tipo"]; 
    $aDatos["comprobante"]=$aNumero[0]["comprobante"]; 
    $aDatos["fecha"]=$datos["fechaPagoReal"]; 
    $aDatos["fechaRegistro"]=date('Y-m-d'); 
    $aDatos["usuarioRegistra"]=$_SESSION["idUsuario"]; 
    $aDatos["archivo"]=$sFoto; 
    $aDatos["observaciones"]='Factura de compra No. '.$datos["nroFactura"]; 
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
        $aItem["idTercero"]=$datos["idProveedor"];
        $aItem["descripcion"]=$aCuentaContableB["nombre"]; 
        $aItem["naturaleza"]='credito';
        $aItem["tipoTercero"]='p';
        if ($datos["radioPago"]==1) {
            $valorPago=$datos["totalPago"]; 
        }
        if ($datos["radioPago"]==2) {
            $valorPago=$datos["abono"]; 
        }
        $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aItem["fecha"]=$datos["fechaPagoReal"]; 
        $aItem["saldoDebito"]=0;
        $aItem["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$valorPago)));
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

        // $oItem=new Data("cuenta_contable","idCuentaContable",$aEmpresaCuenta["idCuentaContable"]);
        // $aCuentaContable=$oItem->getDatos();
        // unset($oItem);


        $aCompra["idComprobante"]=$idComprobante; 
        $aCompra["idCuentaContable"]=$idCuentaContableTotal;
        $aCompra["idCentroCosto"]=" ";
        $aCompra["idTercero"]=$datos["idProveedor"];
        $aCompra["descripcion"]=$descripcionPago.' de la factura '.$datos["nroFactura"];
        $aCompra["naturaleza"]='debito';
        $aCompra["tipoTercero"]='p';
        $aCompra["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aCompra["fecha"]=$datos["fechaPagoReal"]; 
        $aCompra["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$valorPago)));
        $aCompra["saldoCredito"]=0;
        $aCompra["base"]=0;

        $oItem=new Data("comprobante_items","idComprobanteItem"); 
        foreach($aCompra  as $keyImpuesto => $valueImpuesto){
            $oItem->$keyImpuesto=$valueImpuesto; 
        }
        $oItem->guardar(); 
        unset($oItem);







        $aFacturaComprobante["idFacturaCompra"]=$idFacturaCompra;
        $aFacturaComprobante["idComprobante"]=$idComprobante;
        $aFacturaComprobante["estado"]=$estado;

        $oItem=new Data("factura_compra_comprobante","idFacturaCompraComprobante"); 
        foreach($aFacturaComprobante  as $keyFC => $valueFC){
            $oItem->$keyFC=$valueFC; 
        }
        $oItem->guardar(); 
        unset($oItem);

    }
    
$msg=true; 



echo json_encode(array("msg"=>$msg));

?>