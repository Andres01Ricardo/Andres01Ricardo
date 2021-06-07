<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();



date_default_timezone_set("America/Bogota"); 

require_once("../../class/parametrosdocumentos.php");


$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );
// $tipo  = (isset($_REQUEST['tipoDocumento'] ) ? $_REQUEST['tipoDocumento'] : "" );


if(!isset($_SESSION)){ session_start(); }


$oParametrosDocumentos=new ParametrosDocumentos(); 
$aParametrosDocumentos=$oParametrosDocumentos->getParametrosDocumentos($idEmpresa);



  //       $oItem=new Lista("parametros_documentos");
		// $oItem->setFiltro("idEmpresa","=",$idEmpresa);
		// $aParametros=$oItem->getLista();
		// unset($oItem);

        // $parametro=$aLista[0];
// print_r($aParametrosDocumentos);
echo json_encode($aParametrosDocumentos);

?>


