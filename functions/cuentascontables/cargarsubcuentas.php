<?php

require_once("../../php/restrict.php");


include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");


date_default_timezone_set("America/Bogota"); 

$id  = (isset($_REQUEST['id'] ) ? $_REQUEST['id'] : "" );


$oLista = new Lista('subcuenta');
$oLista->setFiltro("idCuenta","=",$id);
$aSubcuenta=$oLista->getLista();
unset($oLista);


echo json_encode($aSubcuenta); 

?>
