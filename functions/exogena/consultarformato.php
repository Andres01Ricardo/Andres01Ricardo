<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");
include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");
include_once($CLASS . "control.php");

require_once("../../class/facturaventa.php"); 

date_default_timezone_set("America/Bogota"); 

$idConceptoExogena  = (isset($_REQUEST['idConceptoExogena'] ) ? $_REQUEST['idConceptoExogena'] : "" );

// $nroFactura  = (isset($_REQUEST['nroFactura'] ) ? $_REQUEST['nroFactura'] : "" );

date_default_timezone_set("America/Bogota"); 

if(!isset($_SESSION)){ session_start(); }


$oLista=new Data("concepto_exogena","idConceptoExogena",$idConceptoExogena);
$concepto=$oLista->getDatos();
unset($oLista);

	$oLista=new Data("formato_exogena","idFormatoExogena",$concepto["idFormatoExogena"]);
	$formato=$oLista->getDatos();
	unset($oLista);
	
if ($concepto["idFormatoExogena"]==1 || $concepto["idFormatoExogena"]==4 || $concepto["idFormatoExogena"]==5 || $concepto["idFormatoExogena"]==6 || $concepto["idFormatoExogena"]==14) {
	



	$oLista=new Lista("categoria_exogena");
	$oLista->setFiltro("idFormato","=",$formato["idFormatoExogena"]);
	$categoria=$oLista->getLista();
	unset($oLista);

}else{

	
	$categoria=0;

}



$msg=true;


echo json_encode(array("msg"=>$msg,"formato"=>$formato,"categoria"=>$categoria));

?>