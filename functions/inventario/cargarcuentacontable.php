<?php

require_once("../../php/restrict.php");


include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");


date_default_timezone_set("America/Bogota"); 

$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );

$codigo  = (isset($_REQUEST['codigo'] ) ? $_REQUEST['codigo'] : "" );



$oLista = new Lista('cuenta_contable');
$oLista->setFiltro("idEmpresa","=",$idEmpresa);
$oLista->setFiltro("codigoCuenta","like",$codigo);
$grupoInventario=$oLista->getLista();
unset($oLista);


echo json_encode($grupoInventario); 

?>











