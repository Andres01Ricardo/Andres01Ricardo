<?php
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");
require_once("../../class/facturacompra.php"); 

$oFactura=new FacturaCompra(); 
date_default_timezone_set("America/Bogota"); 

$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );

$aProveedores=$oFactura->getProveedoresEmpresa(array("estado"=>1,"idEmpresa"=>$idEmpresa));


echo json_encode(array("lista"=>$aProveedores));

?>