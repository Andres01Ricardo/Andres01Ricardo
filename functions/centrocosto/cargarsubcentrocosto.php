<?php

require_once("../../php/restrict.php");


include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");




include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");


date_default_timezone_set("America/Bogota"); 

$id  = (isset($_REQUEST['idCentroCosto'] ) ? $_REQUEST['idCentroCosto'] : "" );



$oLista=new Lista("subcentro_costo");  
$oLista->setFiltro("idCentroCosto","=",$id);
$aLista=$oLista->getLista(); 

unset($oItem);


echo json_encode($aLista); 

?>
