<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );



if(!isset($_SESSION)){ session_start(); }

$aDatos["fecha"]=date("Y-m-d");

$aDatos["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 

$aDatos["idEmpresa"]=$datos["idEmpresa"]; 

// $aDatos["idU"]=$datos["sucursalCliente"]; 

$aDatos["bodega"]=$datos["bodega"];

$aDatos["idCliente"]=$datos["idCliente"]; 

$aDatos["numero"]=$datos["numero"]; 

$aDatos["observaciones"]=$datos["observaciones"]; 

$aDatos["estado"]=1; 




$oItem=new Data("remision","idRemision"); 

foreach($aDatos  as $key => $value){

    $oItem->$key=$value; 

}


$oItem->guardar(); 

$idRemision=$oItem->ultimoId(); 

unset($oItem);



foreach ($item as $key => $value) {

    $aItem["idRemision"]=$idRemision; 

    $aItem["detalleProducto"]=$value["producto"]; 

    $aItem["idProductoServicio"]=$value["idProducto"]==""?0:$value["idProducto"]; 

    $aItem["descripcion"]=$value["descripcion"]; 


    $aItem["cantidad"]=$value["cantidad"]; 




    $oItem=new Data("remision_item","idRemisionItem"); 

    foreach($aItem  as $key => $value){

        $oItem->$key=$value; 

    }

    $oItem->guardar(); 

    unset($oItem);

}



$msg=true; 



echo json_encode(array("msg"=>$msg));

?>