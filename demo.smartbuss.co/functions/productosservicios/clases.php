<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");


$idfamilia  = (isset($_REQUEST['idfamilia'] ) ? $_REQUEST['idfamilia'] : "" );

$oLista = new Lista('clase');
$oLista->setFiltro("idFamilia","=",$idfamilia);
$lista=$oLista->getLista();
$error=true;

foreach($lista as $index => $item){
    $aNum[$index]["nombre"]=utf8_encode($item["nombre"]);
    $aNum[$index]["idClase"]=$item["idClase"];
    $aNum[$index]["codigo"]=$item["codigo"];
}

echo json_encode(array("clases"=>$aNum));
?>