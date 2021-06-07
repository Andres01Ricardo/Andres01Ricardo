<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

require_once("../../class/terceros.php"); 




$tipoTercero  = (isset($_REQUEST['tipoTercero'] ) ? $_REQUEST['tipoTercero'] : "" );




if ($tipoTercero==1) {

	$oCliente=new Terceros(); 

	$lista=$oCliente->getClientesEmpresa();
}
if ($tipoTercero==2) {
	$oProveedor=new Terceros(); 

	$lista=$oProveedor->getProveedoresEmpresa();

}
if ($tipoTercero==3) {
	$oOtro=new Terceros(); 

	$lista=$oOtro->getOtrosEmpresa();
}


echo json_encode(array("terceros"=>$lista));

?>