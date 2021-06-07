<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$id  = (isset($_REQUEST['idUser'] ) ? $_REQUEST['idUser'] : "" );
$accion  = (isset($_REQUEST['accion'] ) ? $_REQUEST['accion'] : "" );

$estado=$accion==1?0:1;
$oItem=new Data("usuario","idUsuario",$id); 
$oItem->estado=$estado; 
$oItem->guardar(); 
unset($oItem); 

echo json_encode(array("msg"=>true));
?>