
<?php
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota");
if(!isset($_SESSION)){ session_start(); 

	
}
 

$IVA = $_POST['valorIVA'];
$IVAAdicional = $_POST['iva'];

if (!empty($IVAAdicional)) {
    $totalIVA= $IVAAdicional + $IVA;
}if (empty($IVAAdicional)){
    $totalIVA = $IVA;
}

    $dDatos["idBalanceGeneral"] =$_POST["idBalanceGeneral"];
    $dDatos["numeroCuenta"] =  $_POST["numeroCuenta"];
    $dDatos["nombreCuenta"] =  $_POST["nombreCuenta"];
    $dDatos["valor"] =  $totalIVA;
    $dDatos["idUsuarioRegistra"] = $_SESSION["idUsuario"];
    $dDatos["fechaRegistro"]=date("Y-m-d H:m:s");

    $dDatos["sanciones"] =  $_POST["sancionesIVA"];
    $dDatos["intereses"] =  $_POST["interesesIVA"];
    

    $oItem=new Data("impuesto_pagado","idImpuestoPagado"); 
    foreach($dDatos  as $key => $value){
    $oItem->$key=$value; 
    }
    $oItem->guardar(); 
    unset($oItem);

if (!empty($_POST['sancionesIVA'])) {
    $totalIVA = $totalIVA +  $_POST['sancionesIVA'];
}
if (!empty($_POST['interesesIVA'])) {
    $totalIVA = $totalIVA +  $_POST['interesesIVA'];
}

    




$oItem=new Data("cuenta_bancaria","idCuentaBancaria",$_POST["cuentaBancaria"]); 

$aDatos=$oItem->getDatos(); 

$saldoActual=$aDatos["saldoActual"];

$nuevoSaldo=$saldoActual - $totalIVA;
$cuatropormil=$aDatos['aplicaCuatroMil'];
unset($oItem);



$bDatos["idCuentaBancaria"]=$_POST["cuentaBancaria"];
$bDatos["idTipoMovimiento"]=1;
$bDatos["fechaRegistro"]=date("Y-m-d H:i:s");
$bDatos["valorIngreso"]=0;
$bDatos["valorEgreso"]=$totalIVA;  
$bDatos["saldoAnterior"]=$saldoActual;
$bDatos["saldoActual"]=$nuevoSaldo;
$bDatos["descripcionMovimiento"]='pago del IVA'; 

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
    $dDatos["notificacion"] =  "El usuario ".$_SESSION["nombreUsuario"]." ".$_SESSION["apellidoUsuario"]." ha marcado como pago el IVA de la empresa ".$aEmpresa["razonSocial"];   

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
    $sDatos["notificacion"] =  "El usuario ".$_SESSION["nombreUsuario"]." ".$_SESSION["apellidoUsuario"]." ha marcado como pago el IVA de la empresa ".$aEmpresa["razonSocial"];
    

    $oItem=new Data("notificacion","idNotificacion"); 
    foreach($sDatos  as $key => $svalue){
    $oItem->$key=$svalue; 
    }
    $oItem->guardar(); 
    unset($oItem);
}





  header('location: ../../pagoimpuestos');

 ?>

