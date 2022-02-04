<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 



$nit  = (isset($_REQUEST['nit'] ) ? $_REQUEST['nit'] : "" );
$nitP  = (isset($_REQUEST['nitP'] ) ? $_REQUEST['nitP'] : "" );






$oItem=new Data("empresa","nit",$nit); 

$aEmpresa=$oItem->getDatos(); 

unset($oItem); 


$oItem=new Data("tercero","nit",$nitP); 

$aCliente=$oItem->getDatos(); 

unset($oItem); 



// print_r($_SESSION["idUsuario"]);


echo json_encode(array("idEmpresa"=>$aEmpresa['idEmpresa'],"idCliente"=>$aCliente['idTercero']));

?>