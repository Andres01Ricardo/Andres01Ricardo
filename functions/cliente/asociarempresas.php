<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 



$id  = (isset($_REQUEST['id'] ) ? $_REQUEST['id'] : "" );

$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );





$oLista=new Lista("tercero_empresa"); 

$oLista->setFiltro("idTercero","=",$id); 

$aLista=$oLista->getLista(); 

unset($oItem);



foreach($aLista as $aItem){

    $oItem=new Data("tercero_empresa","idTerceroEmpresa",$aItem["idTerceroEmpresa"]); 

    $oItem->eliminar(); 

    unset($oItem);

}

foreach ($item as $key => $value) {

    if($value["estado"]==1){

    $oItem=new Data("tercero_empresa","idTerceroEmpresa"); 

    $oItem->idTercero=$id; 

    $oItem->idEmpresa=$value["idEmpresa"]; 

    $oItem->guardar(); 

    unset($oItem); 

    }

}





    $msg=true; 



 



echo json_encode(array("msg"=>$msg));

?>