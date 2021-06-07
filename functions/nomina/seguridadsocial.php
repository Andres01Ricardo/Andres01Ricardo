<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota");

$tipo  = (isset($_REQUEST['tipo'] ) ? $_REQUEST['tipo'] : "" );

$oLista = new Lista('seguridad_social');
$oLista->setFiltro("tipo","=",$tipo);
$lista=$oLista->getLista();
unset($oLista); 

echo json_encode(array("lista"=>$lista));
?>