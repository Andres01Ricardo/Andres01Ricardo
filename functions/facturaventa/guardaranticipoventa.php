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







    $aDatos["idTercero"]=$datos["idCliente"];
    $aDatos["valor"]=str_replace(",",".",str_replace("$", "", str_replace(".", "", $datos["valor"])));
    $aDatos["idUsuarioRegistra"]=$_SESSION["idUsuario"];
    $aDatos["fechaRegistro"]=date('Y-m-d H:i:s');
    $aDatos["fechaAnticipo"]=$datos["fecha"];
    $aDatos["tipoAnticipo"]=$datos["tipoAnticipo"];
    $aDatos["observaciones"]=$datos["observaciones"];
    $aDatos["idEmpresa"]=$datos["idEmpresa"];

   

$oItem=new Data("anticipo","idAnticipo");

foreach ($aDatos as $key => $value) {
    $oItem->$key=$value; 
}
$oItem->guardar(); 
unset($oItem);






$msg=true; 



echo json_encode(array("msg"=>$msg));

?>