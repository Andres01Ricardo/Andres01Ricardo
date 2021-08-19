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


$oItem=new Data("factura_venta","idFacturaVenta",$datos["idFacturaVenta"]); 
$fDatos=$oItem->getDatos(); 
$totalFactura=$fDatos['total'];
unset($oItem);

$idFacturaVenta=$datos["idFacturaVenta"];

if ($datos["radioPago"]==1) {
    $aDatos["estado"]=3; 

    $aDatos["saldo"]=0;
}
if ($datos["radioPago"]==2) {
    $aDatos["estado"]=4; 

    $aDatos["saldo"]=str_replace("$", "", str_replace(".", "", $datos["totalSaldo"]))-str_replace("$", "", str_replace(".", "", $datos["total"]));
}

$aDatos["fechaPagoReal"]=$datos["fechaPago"]; 

$oItem=new Data("factura_venta","idFacturaVenta",$datos["idFacturaVenta"]); 

foreach ($aDatos as $key => $value) {

    $oItem->$key=$value; 

}

$oItem->guardar(); 


unset($oItem);



// $oItem=new Data("factura_compra_gestion","idFacturaCompra",$datos["idFacturaCompra"]); 

// $oItem->comprobanteEgreso=$datos["comprobante"]; 

// $oItem->guardar(); 

// unset($oItem);



$oItem=new Data("cuenta_bancaria","idCuentaBancaria",$datos["cuentaBancaria"]); 

$aDatos=$oItem->getDatos(); 

$saldoActual=$aDatos["saldoActual"];

$nuevoSaldo=$saldoActual + $totalFactura;
$cuatropormil=$aDatos['aplicaCuatroMil'];
unset($oItem);



$bDatos["idCuentaBancaria"]=$datos["cuentaBancaria"];
$bDatos["idTipoMovimiento"]=3;
$bDatos["fechaRegistro"]=date("Y-m-d H:i:s");
$bDatos["valorIngreso"]=$totalFactura;
$bDatos["valorEgreso"]=0;  
$bDatos["saldoAnterior"]=$saldoActual;
$bDatos["saldoActual"]=$nuevoSaldo;
$bDatos["descripcionMovimiento"]='ingreso dinero de factura de venta '.$datos["numeroFactura"]; 

$oItem=new Data("cuenta_bancaria_movimientos","idCuentaBancariaMovimientos"); 
    foreach($bDatos  as $key => $value){
        $oItem->$key=$value; 
    }
    $oItem->guardar();

    unset($oItem);



$oItem=new Data("cuenta_bancaria","idCuentaBancaria",$datos["cuentaBancaria"]); 

$oItem->saldoActual=$nuevoSaldo; 

$oItem->guardar(); 

unset($oItem);




	$cliente = new data("cliente","idCliente",$fDatos["idCliente"]);

  	$cDatos=$cliente->getDatos(); 

	$empresa = new data("empresa","idEmpresa",$fDatos["idEmpresa"]);
    $emDatos=$empresa->getDatos(); 
    $cmensaje="<p>Estimados señores: ".$cDatos["razonSocial"]."<br>

    Con el presente mensaje acusamos recibido el pago de su factura cambiaria de compra emitida por la empresa ".$emDatos['razonSocial'].", la cual tiene las siguientes referencias: <br><br> 

Factura N°:             ".$fDatos['nroFactura']."<br>
Fecha de emisión:       ".$fDatos['fechaFactura']."<br>
Fecha de vencimiento:   ".$fDatos['fechaVencimiento']."<br>
Valor a pagar:          $".$fDatos['total']." <br> 

Agradeceremos enormemente su cumplimiento. 

Atte:<br>


Auxiliar Administrativo
    </p>"; 


    $cEmail["correo"]=$cDatos["email"]; 
    

    $cEmail["asunto"]="Pago de factura recibido"; 

    $cEmail["mensaje"]=$cmensaje; 

    $cControl=new Control();

    // $cControl->enviarCorreo($cEmail);
    unset($cControl);









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
    $oLista->setFiltro("tipoFactura","like",'venta');
    $aCC=$oLista->getLista();

if (!empty($aCC)) {
    // if ($datos["radioEnlazar"]==1) {
        if (!empty($datos["cuentaContableTotal"])) {
            $oLista=new Lista("compra_cuenta_contable");
            $oLista->setFiltro("concepto","=",'1');
            $oLista->setFiltro("idEmpresa","=",$fDatos["idEmpresa"]);
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
    $aDatos["observaciones"]=$descripcionPago.' factura de venta No. '.$datos["numeroFactura"]; 
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
        $aItem["idTercero"]=$fDatos["idCliente"];
        $aItem["descripcion"]=$aCuentaContableB["nombre"]; 
        $aItem["naturaleza"]='debito';
        $aItem["tipoTercero"]='c';
        // if ($datos["radioPago"]==1) {
        //     $valorPago=$datos["totalPago"]; 
        // }
        // if ($datos["radioPago"]==2) {
        //     $valorPago=$datos["abono"]; 
        // }


        $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aItem["fecha"]=$datos["fechaPago"]; 
        // $aItem["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$valorPago)));
        $aItem["saldoDebito"]=$totalFactura;
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
        $aCompra["idTercero"]=$fDatos["idCliente"];
        $aCompra["descripcion"]=$descripcionPago.' de la factura '.$datos["numeroFactura"];
        $aCompra["naturaleza"]='credito';
        $aCompra["tipoTercero"]='c';
        $aCompra["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aCompra["fecha"]=$datos["fechaPago"]; 
        $aCompra["saldoDebito"]=0;
        // $aCompra["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$valorPago)));
        $aCompra["saldoCredito"]=$totalFactura;
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