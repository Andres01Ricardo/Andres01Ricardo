
<?php
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota");
if(!isset($_SESSION)){ session_start(); 

	
}
 

$retencion = $_POST['valorRetencion'];
$retencionAdicional = $_POST['retencion'];

if (!empty($retencionAdicional)) {
	$totalRetencion= $retencionAdicional + $retencion;
}if (empty($retencionAdicional)){
	$totalRetencion = $retencion;
}

    $dDatos["idBalanceGeneral"] =$_POST["idBalanceGeneralRetencion"];
    $dDatos["numeroCuenta"] =  $_POST["numeroCuentaRetencion"];
    $dDatos["nombreCuenta"] =  $_POST["nombreCuentaRetencion"];
    $dDatos["valor"] =  $totalRetencion;
    $dDatos["idUsuarioRegistra"] = $_SESSION["idUsuario"];
    $dDatos["fechaRegistro"]=date("Y-m-d H:m:s");
    $dDatos["sanciones"]=$_POST['sancionesRetencion'];
    $dDatos["intereses"]=$_POST['interesesRetencion'];
    

    $oItem=new Data("impuesto_pagado","idImpuestoPagado"); 
    foreach($dDatos  as $key => $value){
    $oItem->$key=$value; 
    }
    $oItem->guardar(); 
    unset($oItem);


if (!empty($_POST['sancionesRetencion'])) {
    $totalRetencion = $totalRetencion +  $_POST['sancionesRetencion'];
}
if (!empty($_POST['interesesRetencion'])) {
    $totalRetencion = $totalRetencion +  $_POST['interesesRetencion'];
}

$oItem=new Data("cuenta_bancaria","idCuentaBancaria",$_POST["cuentaBancaria"]); 

$aDatos=$oItem->getDatos(); 

$saldoActual=$aDatos["saldoActual"];

$nuevoSaldo=$saldoActual - $totalRetencion;
$cuatropormil=$aDatos['aplicaCuatroMil'];
unset($oItem);



$bDatos["idCuentaBancaria"]=$_POST["cuentaBancaria"];
$bDatos["idTipoMovimiento"]=1;
$bDatos["fechaRegistro"]=date("Y-m-d H:i:s");
$bDatos["valorIngreso"]=0;
$bDatos["valorEgreso"]=$totalRetencion;  
$bDatos["saldoAnterior"]=$saldoActual;
$bDatos["saldoActual"]=$nuevoSaldo;
$bDatos["descripcionMovimiento"]='pago de la retencion'; 

$oItem=new Data("cuenta_bancaria_movimientos","idCuentaBancariaMovimientos"); 
    foreach($bDatos  as $key => $value){
        $oItem->$key=$value; 
    }
    $oItem->guardar();

    unset($oItem);



$oItem=new Data("cuenta_bancaria","idCuentaBancaria",$_POST["cuentaBancaria"]); 

$oItem->saldoActual=$nuevoSaldo; 

$oItem->guardar(); 

unset($oItem);





$oItem=new Data("cuenta_bancaria_movimientos","idCuentaBancariaMovimientos"); 
    foreach($cDatos  as $key => $value){
        $oItem->$key=$value; 
    }
    $oItem->guardar();

    unset($oItem);


$oItem=new Data("empresa","idEmpresa",$_SESSION["idEmpresa"]); 

$aEmpresa=$oItem->getDatos();

unset($oItem);

$cLista = new Lista('usuario');

$cLista->setFiltro("idRol","=",'2');

$colista=$cLista->getLista();

foreach ($colista as $key => $contador) {

    $dDatos["fechaNotificacion"]=date("Y-m-d H:m:s");
    $dDatos["idUsuarioRegistra"] = $_SESSION["idUsuario"];
    $dDatos["idUsuarioNotificado"] =$contador["idUsuario"];
    $dDatos["notificacion"] =  "El usuario ".$_SESSION["nombreUsuario"]." ".$_SESSION["apellidoUsuario"]." ha marcado como pago la retencion de la empresa ".$aEmpresa["razonSocial"];   

    $oItem=new Data("notificacion","idNotificacion"); 
    foreach($dDatos  as $key => $value){
    $oItem->$key=$value; 
    }
    $oItem->guardar(); 
    unset($oItem);
}
$sLista = new Lista('usuario');

$sLista->setFiltro("idRol","=",'1');

$solista=$sLista->getLista();

foreach ($solista as $key => $super) {

    $sDatos["fechaNotificacion"]=date("Y-m-d H:m:s");
    $sDatos["idUsuarioRegistra"] = $_SESSION["idUsuario"];
    $sDatos["idUsuarioNotificado"] =$super["idUsuario"];
    $sDatos["notificacion"] =  "El usuario ".$_SESSION["nombreUsuario"]." ".$_SESSION["apellidoUsuario"]." ha marcado como pago la retencion de la empresa ".$aEmpresa["razonSocial"];
    

    $oItem=new Data("notificacion","idNotificacion"); 
    foreach($sDatos  as $key => $svalue){
    $oItem->$key=$svalue; 
    }
    $oItem->guardar(); 
    unset($oItem);
}

  header('location: ../../pagoimpuestos');

 ?>

