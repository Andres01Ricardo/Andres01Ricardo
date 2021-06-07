<?php

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

$idRemision=(isset($_REQUEST['id'] ) ? $_REQUEST['id'] : '' );
$url=$idRemision; 
if($idRemision==""){
echo '<script>window.history.back()</script>'; 
}



$oItem=new Data("remision","idRemision",$idRemision); 
$oItem->eliminar(); 
unset($oItem);


$oItem=new Data("remision_item","idRemision",$idRemision); 
$oItem->eliminar();
unset($oItem);
    
    header('location: ../../remisiones');

?>