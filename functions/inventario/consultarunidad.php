<?php

require_once("../../php/restrict.php");



include_once($CLASS . "lista.php");


date_default_timezone_set("America/Bogota"); 



$oLista = new Lista('unidad');

$oLista->setOrden("nombre","ASC");

$aUnidades=$oLista->getLista();

unset($oLista);

echo json_encode(array("unidad"=>$aUnidades)); 

?>

