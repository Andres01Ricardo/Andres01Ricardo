<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );

if(!isset($_SESSION)){ session_start(); }

$datos["nombre"]=$datos['nombre']; 


$oItem=new Data("rol","idRol"); 

foreach($datos  as $key => $value){

    $oItem->$key=$value; 

}

$oItem->guardar(); 

$idRol=$oItem->ultimoId();

unset($oItem);

foreach ($item as $key => $value) {

    $aItem["idMenu"]=$value['idMenu']; 

    $aItem["idRol"]=$idRol;



    $oItem=new Data("menu_rol","idMenuRol"); 

    foreach($aItem  as $key => $value){

        $oItem->$key=$value; 

    }

    $oItem->guardar(); 

    unset($oItem);
}


$msg=true; 



echo json_encode(array("msg"=>$msg));

?>