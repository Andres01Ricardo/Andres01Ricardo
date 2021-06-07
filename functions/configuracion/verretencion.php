<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$id  = (isset($_REQUEST['id'] ) ? $_REQUEST['id'] : "" ); 

$oItem=new Data("retencion","idRetencion",$id); 
$aDatos=$oItem->getDatos(); 
unset($oItem);


$oLista = new Lista('ciudad');
$oLista->setFiltro("idDepartamento","=",$aDatos["idDepartamento"]);
$aCiudad=$oLista->getLista();
unset($oLista);

$msg=true; 

echo json_encode(array("datos"=>$aDatos,"ciudades"=>$aCiudad));
?>