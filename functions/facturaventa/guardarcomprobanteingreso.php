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

    $cControl->enviarCorreo($cEmail);
    unset($cControl);



$msg=true; 



echo json_encode(array("msg"=>$msg));

?>