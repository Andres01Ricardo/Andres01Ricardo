<?php

require_once("../../php/restrict.php");


include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");


date_default_timezone_set("America/Bogota"); 

$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );

include("listarinventario.php") ; 

$oInventarios = new Inventario();
$aInventario =$oInventarios->getInventarioInsumos(array("idEmpresa"=>$_SESSION["idEmpresa"]));

// $oLista = new Lista('inventario');
// $oLista->setFiltro("idEmpresa","=",$idEmpresa);
// $oLista->setFiltro("tipoInventario","=",1);
// $aInsumo=$oLista->getLista();
// unset($oLista);


echo json_encode($aInventario); 

?>

