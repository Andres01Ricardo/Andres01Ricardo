<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");


$departamento  = (isset($_REQUEST['idDepartamento'] ) ? $_REQUEST['idDepartamento'] : "" );

$oLista = new Lista('ciudad');
$oLista->setFiltro("idDepartamento","=",$departamento);
$lista=$oLista->getLista();
$error=true;

echo json_encode(array("ciudades"=>$lista));
?>