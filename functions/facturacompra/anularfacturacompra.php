<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 





$idFactura=(isset($_REQUEST['idFactura'] ) ? $_REQUEST['idFactura'] : "" ); 



$aDatos["estado"]=5; 
 
$oItem=new Data("factura_compra","idFacturaCompra",$idFactura); 

foreach($aDatos  as $key => $value){

$oItem->$key=$value; 

}

$oItem->guardar(); 

unset($oItem);




$aDatosG["estado"]=2; 


$oItem=new Data("factura_compra_gestion","idFacturaCompra",$idFactura); 

foreach($aDatosG  as $keyG => $valueG){

$oItem->$keyG=$valueG; 

}

$oItem->guardar(); 

unset($oItem);


$oItem=new Lista("factura_compra_deduccion");
$oItem->setFiltro("idFacturaCompra","=",$idFactura); 
$deducciones=$oItem->getLista();


foreach ($deducciones as $keyd => $valued) {

    $aItem["estado"]=2; 

    

    
    $oItem=new Data("factura_compra_deduccion","idFacturaCompraDeduccion",$valued["idFacturaCompraDeduccion"]); 

    foreach($aItem  as $keyF => $valueF){

        $oItem->$keyF=$valueF; 

    }

    $oItem->guardar(); 

    unset($oItem);

}

$msg=true; 


echo json_encode(array("msg"=>$msg));

?>