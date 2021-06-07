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

$datos["idUsuarioRegistro"]=$_SESSION["idUsuario"]; 

$datos["fechaRegistro"]=date("Y-m-d H:i:s"); 

$datos["saldoActual"]=str_replace("$", "", str_replace(",", "", $datos["saldoActual"])); 

$datos["estado"]=1; 

if ($datos["numeroCuenta"]=="") {
	$datos["numeroCuenta"]='-';
}
if ($datos["idBanco"]=="") {
	$datos["idBanco"]='0';
}

$oItem=new Data("cuenta_bancaria","idCuentaBancaria"); 

foreach($datos  as $key => $value){

    $oItem->$key=$value; 

}

$oItem->guardar(); 

unset($oItem);



$msg=true; 



echo json_encode(array("msg"=>$msg));

?>