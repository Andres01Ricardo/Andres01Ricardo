<?php

require_once("../../php/restrict.php");


include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");


date_default_timezone_set("America/Bogota"); 

$idProducto  = (isset($_REQUEST['idProducto'] ) ? $_REQUEST['idProducto'] : "" );

include("listarinventario.php") ; 

$oInventarios = new Inventario();
$aInventario =$oInventarios->getInventarioProductos(array("idProducto"=>$idProducto));



echo json_encode(array('insumo'=>$aInventario)); 

?>