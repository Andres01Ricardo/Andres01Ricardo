<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");


require_once("../../class/parametrosdocumentos.php"); 

date_default_timezone_set("America/Bogota"); 



$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );




date_default_timezone_set("America/Bogota"); 

if(!isset($_SESSION)){ session_start(); }



$oParametro=new ParametrosDocumentos(); 
$dParametro=$oParametro->getParametrosDocumentos($idEmpresa);




        //   $oItem=new Lista("parametros_documentos");
        //   $oItem->setFiltro("idEmpresa","=",$idEmpresa);
        //   $aParametros=$oItem->getLista();
        //   unset($oItem);

        

        // $oItem=new Data("tipos_documento_contable","idTiposDocumento",$valueT["tipo"]);
        // $aTipo=$oItem->getDatos()
        // unset($oItem);


echo json_encode($dParametro);

?>


 
