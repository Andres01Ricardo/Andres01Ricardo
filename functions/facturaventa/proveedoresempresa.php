<?php

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

require_once("../../class/clientes.php"); 



$oClientes=new Clientes(); 

date_default_timezone_set("America/Bogota"); 



$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );



$aClientes=$oClientes->getClientesEmpresa(array("estado"=>1,"idEmpresa"=>$idEmpresa));





echo json_encode(array("lista"=>$aClientes));



?>