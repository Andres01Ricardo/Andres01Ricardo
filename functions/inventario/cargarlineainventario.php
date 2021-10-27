<?php

require_once("../../php/restrict.php");


include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");


date_default_timezone_set("America/Bogota"); 

$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );



$oLista = new Lista('linea_inventario');
$oLista->setFiltro("idEmpresa","=",$idEmpresa);
$aLinea=$oLista->getLista();
unset($oLista);


echo json_encode($aLinea); 

?>