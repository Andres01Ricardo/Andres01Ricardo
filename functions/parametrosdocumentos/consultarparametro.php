<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();



date_default_timezone_set("America/Bogota"); 



$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );
$tipo  = (isset($_REQUEST['tipoDocumento'] ) ? $_REQUEST['tipoDocumento'] : "" );


if(!isset($_SESSION)){ session_start(); }



        $oItem=new Lista("parametros_documentos");
        $oItem->setFiltro("idEmpresa","=",$idEmpresa); 
        $oItem->setFiltro("tipo","=",$tipo); 
        $oItem->setOrden("comprobante","DESC"); 
        $aLista=$oItem->getLista(); 
        unset($oItem);

        $parametro=$aLista[0];

echo json_encode(array("parametro"=>$parametro));

?>