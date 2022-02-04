<?php

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");


date_default_timezone_set("America/Bogota"); 

$nit  = (isset($_REQUEST['nit'] ) ? $_REQUEST['nit'] : "" );

$idEmpresa = (isset($_REQUEST["idEmpresa"]) ? $_REQUEST['idEmpresa'] : "" );




$oItem = new Data("tercero","nit",$nit);
$tercero=$oItem->getDatos();
unset($oItem);

// if (!empty($tercero)) {
	// code...
	$oLista=new Lista("tercero_empresa");
	$oLista ->setFiltro("idTercero","=",$tercero["idTercero"]);
	$oLista->setFiltro("idEmpresa","=",$idEmpresa);
	$terceroEmpresa=$oLista->getLista();
	unset($oLista);





echo json_encode(array("tercero"=>$tercero,"terceroEmpresa"=>$terceroEmpresa)); 

?>
