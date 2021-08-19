<?php 

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 


$idSubcentroCosto = (isset($_REQUEST['idEliminar']) ? $_REQUEST["idEliminar"] : "" );





// $oItem=new Data("centro_costo","idCentroCosto",$idCentroCosto);
// $oItem->eliminar();
// unset($oItem);
// $oLista = new Lista("subcentro_costo");
// $oLista->setFiltro("idCentroCosto","=",$idCentroCosto);
// $subcentro=$oLista->getLista();



	$oItem=new Data("subcentro_costo","idSubcentroCosto",$idSubcentroCosto);
	$oItem->eliminar();
	unset($oItem);




$msg=true; 

echo json_encode(array("msg"=>$msg));

 


?>