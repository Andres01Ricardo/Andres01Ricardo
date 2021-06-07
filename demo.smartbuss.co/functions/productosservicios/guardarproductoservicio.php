<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$oLista = new Lista('producto_servicio');
$oLista->setFiltro("idBienes","=",$datos["bien"]);
$oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
$lista=$oLista->getLista();
unset($oLista); 

$oItem=new Data("bienes","idBienes",$datos["bien"]); 
$aBienes=$oItem->getDatos(); 
unset($oItem);

$codigo=$aBienes["codigo"].str_pad(count($lista)+1, 2, "0", STR_PAD_LEFT);



if(!isset($_SESSION)){ session_start(); }
$aDatos["idUsuario"]=$_SESSION["idUsuario"]; 
$aDatos["fechaRegistro"]=date("Y-m-d H:i:s"); 
$aDatos["nombre"]=$datos["nombre"]; 
$aDatos["idEmpresa"]=$datos["idEmpresa"]; 
$aDatos["idBienes"]=$datos["bien"]; 
$aDatos["codigo"]=$codigo; 
$aDatos["tipo"]=$datos["tipo"]; 

$oItem=new Data("producto_servicio","idProductoServicio"); 
foreach($aDatos  as $key => $value){
    $oItem->$key=$value; 
}
$oItem->guardar(); 
$idProducto=$oItem->ultimoId(); 
unset($oItem);

$oItem=new Data("producto_servicio","idProductoServicio",$idProducto); 
$aData=$oItem->getDatos(); 
unset($oItem); 

$nombre=$aData["codigo"]." - ".$aData["nombre"]; 
echo json_encode(array("msg"=>true,"id"=>$idProducto,"nombre"=>$nombre));
?>