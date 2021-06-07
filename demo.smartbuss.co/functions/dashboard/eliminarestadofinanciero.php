<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$id  = (isset($_REQUEST['id'] ) ? $_REQUEST['id'] : "" );


$oItem=new Data("estado_financiero","idEstadoFinanciero",$id); 
$aData=$oItem->getDatos(); 
unset($oItem);


$oLista=new Lista("estado_financiero_item"); 
$oLista->setFiltro("idEstadoFinanciero","=",$id); 
$aLista=$oLista->getLista(); 
unset($oItem);


foreach($aLista as $aItem){
    $oItem=new Data("estado_financiero_item","idEstadoFinancieroItem",$aItem["idEstadoFinancieroItem"]); 
    $oItem->eliminar(); 
    unset($oItem);
}

$oItem=new Data("estado_financiero","idEstadoFinanciero",$id); 
$oItem->eliminar(); 
unset($oItem);

unlink("../../".$aData["anexo"]); 

$msg=true; 

echo json_encode(array("msg"=>$msg));
?>