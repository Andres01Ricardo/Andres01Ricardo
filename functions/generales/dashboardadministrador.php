<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$id  = (isset($_REQUEST['tipo'] ) ? $_REQUEST['tipo'] : "" ); 

$oLista = new Lista('retencion');
$oLista->setFiltro("tipo","=",$id);
$oLista->setFiltro("estado","=",1);
$aRetencion=$oLista->getLista();
unset($oLista);

foreach ($aRetencion as $key => $value) {
	if($value["idCiudad"]!=""){
		$oItem=new Data("ciudad","idCiudad",$value["idCiudad"]);
		$aCiudad=$oItem->getDatos(); 
		unset($oItem); 

		$oItem=new Data("departamento","idDepartamento",$value["idDepartamento"]);
		$aDepartamento=$oItem->getDatos(); 
		unset($oItem);

		$aRetencion[$key]["ciudad"]=$aCiudad["nombre"]." - ".substr($aDepartamento["nombre"], 0,3); 
	}else{
		$aRetencion[$key]["ciudad"]=""; 
	}
	
}

echo json_encode(array("retenciones"=>$aRetencion));
?>