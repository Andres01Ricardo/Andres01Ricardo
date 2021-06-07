<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );
$id  = (isset($_REQUEST['id'] ) ? $_REQUEST['id'] : "" );

if(!isset($_SESSION)){ session_start(); }


$oItem=new Data("producto_servicio","idProductoServicio",$id); 
$oItem->nombre=$datos["nombre"]; 
$oItem->guardar(); 
unset($oItem);


echo json_encode(array("msg"=>true));
?>