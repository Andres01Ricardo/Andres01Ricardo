<?php 

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 


$idEliminar = (isset($_REQUEST['idEliminar']) ? $_REQUEST["idEliminar"] : "" );








$oItem=new Lista("producto_servicio");
$oItem->setFiltro("idGrupo","=",$idEliminar);
$productosgrupo=$oItem->getLista();
unset($oItem);


if (empty($productosgrupo)) {
	

	$oItem=new Data("grupo_inventario","idGrupoInventario",$idEliminar);
	$oItem->eliminar();
	unset($oItem);

	$msg=true; 
}

if (!empty($productosgrupo)) {
	$msg=false;
}




echo json_encode(array("msg"=>$msg));

 


?>