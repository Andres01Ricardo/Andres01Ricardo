<?php

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota");

$idCotizacion  = (isset($_REQUEST['idCotizacion'] ) ? $_REQUEST['idCotizacion'] : "" );

 
 
    if(!isset($_SESSION)){ session_start(); }


date_default_timezone_set("America/Bogota");



		$oItem=new Data("cotizacion","idCotizacion",$idCotizacion); 
		$cotizacion=$oItem->getDatos();
		unset($oItem);

		$oItem=new Data("t_clientes","codigoCliente",$cotizacion["idCliente"]); 
		$cliente=$oItem->getDatos();
		unset($oItem);

		$oLista=new Lista("cotizacion_item");
		$oLista->setFiltro("idCotizacion","=",$idCotizacion);
		$cotizacionItem=$oLista->getLista();
		unset($oLista);




$msg=true;

echo json_encode(array("msg"=>$msg,"cotizacion"=>$cotizacion,"cotizacionItem"=>$cotizacionItem,"cliente"=>$cliente));
		
	  // header('location: ../../negocios/',$codigocliente);
 ?>
 