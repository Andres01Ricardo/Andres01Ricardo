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

$idFacturaCompra=$datos["idFacturaCompra"];


$totalFactura=$fDatos['total'];
unset($oItem);

if ($datos["radioPago"]==1) {
    $aDatos["estado"]=3; 

    $aDatos["saldo"]=0;
}
if ($datos["radioPago"]==2) {
    $aDatos["estado"]=4; 

    $aDatos["saldo"]=str_replace("$", "", str_replace(".", "", $datos["totalSaldo"]))-str_replace("$", "", str_replace(".", "", $datos["total"]));
}



// $aDatos["fechaPago"]=$datos["fechaPago"];

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


if ($_SESSION["idRol"]==2) {
    $oItem=new Data("usuario","idUsuario",$_SESSION["idUsuario"]); 

    $uDatos=$oItem->getDatos();

    $correo=$uDatos['correo'];
}




if ($datos["radioPago"]==1) {
    $totalFactura=str_replace(",", ".",str_replace("$", "", str_replace(".","", $datos["totalSaldo"])));
    $descripcionPago='Pago';
    $estado=3;
}
if ($datos["radioPago"]==2) {
    // $totalFactura=str_replace("$", "", str_replace(".", "", $datos["total"]));
    $totalFactura=str_replace(",", ".",str_replace("$", "", str_replace(".","", $datos["total"])));
    $descripcionPago='Abono';
    $estado=4;
}

    $oLista=new Lista("compra_cuenta_contable");
    $oLista->setFiltro("concepto","=",'1');
    $oLista->setFiltro("idEmpresa","=",$fDatos["idEmpresa"]);
    $oLista->setFiltro("tipoFactura","like",'compra');
    $aCC=$oLista->getLista();

if (!empty($aCC)) {
    // if ($datos["radioEnlazar"]==1) {
        if (!empty($datos["cuentaContableTotal"])) {
            $oLista=new Lista("compra_cuenta_contable");
            $oLista->setFiltro("concepto","=",'1');
            $oLista->setFiltro("idEmpresa","=",$fDatos["idEmpresa"]);
            $oLista->setFiltro("tipoFactura","=",'compra');
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
    $oLista->setFiltro("idEmpresa","=",$fDatos["idEmpresa"]);
    $oLista->setFiltro("idParametrosDocumentos","=",$tipoDocumentoTotal);
    $aNumero=$oLista->getLista();
    unset($oLista);
    // print_r($aNumero);

    $numeroComprobante=intval($aNumero[0]["numeracionActual"]);

    $aDatos["idTipo"]=$aNumero[0]["tipo"]; 
    $aDatos["comprobante"]=$aNumero[0]["comprobante"]; 
    $aDatos["fecha"]=$datos["fechaPago"]; 
    $aDatos["fechaRegistro"]=date('Y-m-d'); 
    $aDatos["usuarioRegistra"]=$_SESSION["idUsuario"]; 
    $aDatos["archivo"]=$sFoto; 
    $aDatos["observaciones"]=$descripcionPago.' factura de compra No. '.$datos["numeroFactura"]; 
    $aDatos["idEmpresa"]=$fDatos["idEmpresa"]; 
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
        
    // }

        $idCuentaB=$datos["cuentaBancaria"];

        $oLista=new Lista("banco_cuenta_contable");
        $oLista->setFiltro("idCuentaBancaria","=",$idCuentaB);
        $oLista->setFiltro("idEmpresa","=",$fDatos["idEmpresa"]);
        $aBanco=$oLista->getLista();
        unset($oLista);

     
        $oItem=new Data("cuenta_contable","idCuentaContable",$aBanco[0]["idEmpresaCuenta"]);
        $aCuentaContableB=$oItem->getDatos();
        unset($oItem);
        
        $aItem["idComprobante"]=$idComprobante; 
        $aItem["idCuentaContable"]=$aBanco[0]["idEmpresaCuenta"];
        $aItem["idCentroCosto"]=" ";
        $aItem["idTercero"]=$fDatos["idProveedor"];
        $aItem["descripcion"]=$aCuentaContableB["nombre"]; 
        $aItem["naturaleza"]='credito';
        $aItem["tipoTercero"]='p';
        $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aItem["fecha"]=$datos["fechaPago"]; 
        // $aItem["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$valorPago)));
        $aItem["saldoDebito"]=0;
        $aItem["saldoCredito"]=$totalFactura;
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
        $aCompra["idTercero"]=$fDatos["idProveedor"];
        $aCompra["descripcion"]=$descripcionPago.' de la factura '.$datos["numeroFactura"];
        $aCompra["naturaleza"]='debito';
        $aCompra["tipoTercero"]='p';
        $aCompra["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aCompra["fecha"]=$datos["fechaPago"]; 
        $aCompra["saldoDebito"]=$totalFactura;
        // $aCompra["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$valorPago)));
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