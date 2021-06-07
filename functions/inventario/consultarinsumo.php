<?php

require_once("../../php/restrict.php");


include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");


date_default_timezone_set("America/Bogota"); 

$idProducto  = (isset($_REQUEST['idProducto'] ) ? $_REQUEST['idProducto'] : "" );

include("listarinventario.php") ; 

$oInventarios = new Inventario();
$aInventario =$oInventarios->getInventarioInsumos(array("idProducto"=>$idProducto));

// $oLista = new Lista('inventario');
// $oLista->setFiltro("idEmpresa","=",$idEmpresa);
// $oLista->setFiltro("tipoInventario","=",1);
// $aInsumo=$oLista->getLista();
// unset($oLista);


echo json_encode(array('insumo'=>$aInventario)); 

?>
