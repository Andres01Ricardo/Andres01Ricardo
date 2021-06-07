<?php
header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");


date_default_timezone_set("America/Bogota"); 


$idProyecto  = (isset($_REQUEST['idProyecto'] ) ? $_REQUEST['idProyecto'] : "" );

if(!isset($_SESSION)){ session_start(); }


 // print_r($idProyecto);
$oLista=new Lista("legalizaciones"); 
$oLista->setFiltro("idProyectoLegalizacion","=",$idProyecto);
$aProyecto=$oLista->getLista();
unset($oLista);
// print_r($aProyecto);
foreach ($aProyecto as $key => $value) {
	
	$Datos["estado"] = 2;

	$oItem=new Data("legalizaciones","idLegalizacion",$value['idLegalizacion']); 
	foreach($Datos  as $keyl => $valuel){
	$oItem->$keyl=$valuel; 
	}

	$oItem->guardar(); 
	unset($oItem);
}


$msg=true;
	echo json_encode(array("msg"=>$msg));
	

 ?>