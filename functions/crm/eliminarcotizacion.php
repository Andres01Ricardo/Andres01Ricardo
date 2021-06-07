<?php

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

$idCotizacion=(isset($_REQUEST['id'] ) ? $_REQUEST['id'] : '' );
$url=$idCotizacion; 
if($idCotizacion==""){
echo '<script>window.history.back()</script>'; 
}



$oItem=new Data("cotizacion","idCotizacion",$idCotizacion); 
$oItem->eliminar(); 
unset($oItem);


$oItem=new Data("cotizacion_item","idCotizacion",$idCotizacion); 
$oItem->eliminar();
unset($oItem);
    
    header('location: ../../cotizacion');

?>