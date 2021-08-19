<?php

require_once("../../php/restrict.php");


include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");




include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");


date_default_timezone_set("America/Bogota"); 

$id  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );

$tipoDetalle  = (isset($_REQUEST['tipoDetalle'] ) ? $_REQUEST['tipoDetalle'] : "" );



include_once("../../class/terceros.php"); 



$oClientes=new Terceros(); 
$aLista=$oClientes->getTercerosEmpresa(array("idEmpresa"=>$id));



echo json_encode($aLista); 

?>
