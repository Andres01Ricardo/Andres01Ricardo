<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 



$id  = (isset($_REQUEST['id'] ) ? $_REQUEST['id'] : "" );

$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );





$oLista=new Lista("fecha_impuesto_empresa"); 

$oLista->setFiltro("idFechaImpuesto","=",$id); 

$aLista=$oLista->getLista(); 

unset($oItem);



foreach($aLista as $aItem){

    $oItem=new Data("fecha_impuesto_empresa","idFechaImpuestoEmpresa",$aItem["idFechaImpuestoEmpresa"]); 

    $oItem->eliminar(); 

    unset($oItem);

}

foreach ($item as $key => $value) {

    if($value["estado"]==1){

    $oItem=new Data("fecha_impuesto_empresa","idFechaImpuestoEmpresa"); 

    $oItem->idFechaImpuesto=$id; 

    $oItem->idEmpresa=$value["idEmpresa"]; 

    $oItem->guardar(); 

    unset($oItem); 

    }

}





    $msg=true; 



 



echo json_encode(array("msg"=>$msg));

?>