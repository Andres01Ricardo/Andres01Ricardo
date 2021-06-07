<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 


$idEliminar=(isset($_REQUEST['idEliminar'] ) ? $_REQUEST['idEliminar'] : "" );




$oItem=new Data("cuenta_contable","idCuentaContable",$idEliminar); 
$oItem->eliminar(); 
unset($oItem);


$oItem=new Data("empresa_cuenta_contable","idCuentaContable",$idEliminar);
$oItem->eliminar();
unset($oItem);
    


$msg=true; 


echo json_encode(array("msg"=>$msg));

?>