<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$id  = (isset($_REQUEST['id'] ) ? $_REQUEST['id'] : "" );



$oItem=new Data("cuenta_bancaria","idCuentaBancaria",$id); 

$aDatos=$oItem->getDatos(); 

unset($oItem); 





if(!isset($_SESSION)){ session_start(); }

$aInsert["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 

$aInsert["fechaRegistro"]=date("Y-m-d H:i:s"); 

$aInsert["saldoAnterior"]=$aDatos["saldoActual"]; 

$aInsert["nuevoSaldo"]=str_replace("$", "", str_replace(".", "", $datos["nuevoSaldo"])); 

$aInsert["descripcion"]=$datos["descripcion"]; 

$aInsert["idCuentaBancaria"]=$id; 



 

$oItem=new Data("cuenta_bancaria_ajuste","idCuentaBancariaAjuste"); 

foreach($aInsert  as $key => $value){

    $oItem->$key=$value; 

}

$oItem->guardar(); 

unset($oItem);





$oItem=new Data("cuenta_bancaria","idCuentaBancaria",$id); 

$oItem->saldoActual=str_replace("$", "", str_replace(".", "", $datos["nuevoSaldo"]));

$oItem->guardar(); 

unset($oItem);



$msg=true; 



echo json_encode(array("msg"=>$msg));

?>