<?php

require_once("../../php/restrict.php");


include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");


date_default_timezone_set("America/Bogota"); 

$id  = (isset($_REQUEST['id'] ) ? $_REQUEST['id'] : "" );

// include("listarinventario.php") ; 

// $oInventarios = new Inventario();
// $aInventario =$oInventarios->getInventarioInsumos(array("idEmpresa"=>$_SESSION["idEmpresa"]));

$oLista = new Lista('cuenta');
$oLista->setFiltro("idGrupo","=",$id);
$aCuenta=$oLista->getLista();
unset($oLista);


echo json_encode($aCuenta); 

?>
