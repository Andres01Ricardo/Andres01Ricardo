<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 


$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

// $item  = (isset($_REQUEST['subcentros'] ) ? $_REQUEST['subcentros'] : "" );


if(!isset($_SESSION)){ session_start(); }




    $aItemSubcentroCosto["codigoSubcentroCosto"]=$datos["codigo"];
    $aItemSubcentroCosto["subcentroCosto"]=$datos["nombre"];
    $aItemSubcentroCosto["idCentroCosto"]=$datos["idCentroCosto"];


    $oItem=new Data("subcentro_costo","idSubcentroCosto"); 
        foreach($aItemSubcentroCosto  as $keys => $values){
            $oItem->$keys=$values; 
        }
        $oItem->guardar(); 
        unset($oItem);

    $msg=true; 



    echo json_encode(array("msg"=>$msg));

?>