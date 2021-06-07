<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$oItem=new Data("usuario","idUsuario",$datos['idUsuario']); 
$oItem->clave=md5($datos['clave']); 
$oItem->guardar(); 
unset($oItem); 

echo json_encode(array("msg"=>true));
?>