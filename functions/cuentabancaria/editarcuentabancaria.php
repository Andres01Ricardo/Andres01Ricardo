<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();



date_default_timezone_set("America/Bogota"); 



$nombreCuenta  = (isset($_REQUEST['nombreCuenta'] ) ? $_REQUEST['nombreCuenta'] : "" );

$numeroCuenta  = (isset($_REQUEST['numeroCuenta'] ) ? $_REQUEST['numeroCuenta'] : "" );

$idCuenta  = (isset($_REQUEST['idCuenta'] ) ? $_REQUEST['idCuenta'] : "" );
$cuatroMil  = (isset($_REQUEST['cuatroMil'] ) ? $_REQUEST['cuatroMil'] : "" );

$cuentaPrincipal  = (isset($_REQUEST['cuentaPrincipal'] ) ? $_REQUEST['cuentaPrincipal'] : "" );


if(!isset($_SESSION)){ session_start(); }

$datos["nombreCuenta"]=$nombreCuenta; 

$datos["numeroCuenta"]=$numeroCuenta;
$datos["aplicaCuatroMil"]=$cuatroMil;
$datos["cuentaPrincipal"]=$cuentaPrincipal;




$oItem=new Data("cuenta_bancaria","idCuentaBancaria",$idCuenta); 

foreach($datos  as $key => $value){

    $oItem->$key=$value; 

}

$oItem->guardar(); 

unset($oItem);



$msg=true; 



echo json_encode(array("msg"=>$msg));

?>