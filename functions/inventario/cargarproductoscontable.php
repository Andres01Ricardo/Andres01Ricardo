<?php

require_once("../../php/restrict.php");


include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");


date_default_timezone_set("America/Bogota"); 

$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );

$contable  = (isset($_REQUEST['contable'] ) ? $_REQUEST['contable'] : "" );


if ($contable==1) {
	// code...
	$oLista = new Lista("producto_servicio");
	$oLista->setFiltro("idEmpresa","=",$idEmpresa);
	$oLista->setFiltro("idGrupo","!=",0);
	$productos=$oLista->getLista();
	unset($oLista);
}else{
	$oLista = new Lista("producto_servicio");
	$oLista->setFiltro("idEmpresa","=",$idEmpresa);
	// $oLista->setFiltro("inventario","=",1);
	$productos=$oLista->getLista();
	unset($oLista);
}


echo json_encode($productos); 

?>
