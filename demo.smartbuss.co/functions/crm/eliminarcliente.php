<?php

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

$codigoCliente=(isset($_REQUEST['id'] ) ? $_REQUEST['id'] : '' );
$url=$codigoCliente; 
if($codigoCliente==""){
echo '<script>window.history.back()</script>'; 
}

echo $codigoCliente;

$oItem=new Data("t_clientes","codigoCliente",$codigoCliente); 
$oItem->eliminar();
$codigoEtapa=$oItem->ultimoId(); 
unset($oItem);


$oItem=new Data("actividades","idCliente",$codigoCliente); 
$oItem->eliminar();
$codigoEtapa=$oItem->ultimoId(); 
unset($oItem);
    
    header('location: ../../pipeline');

?>