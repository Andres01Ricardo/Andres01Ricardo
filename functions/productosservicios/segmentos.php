<?php

header('Content-type: application/json;');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");


$idgrupo  = (isset($_REQUEST['idgrupo'] ) ? $_REQUEST['idgrupo'] : "" );

$oLista = new Lista('segmento');
$oLista->setFiltro("idGrupo","=",$idgrupo);
$lista=$oLista->getLista();
$error=true;
foreach($lista as $index => $item){
    $aNum[$index]["nombre"]=utf8_encode($item["nombre"]);
    $aNum[$index]["idSegmento"]=$item["idSegmento"];
    $aNum[$index]["codigo"]=$item["codigo"];
}
echo json_encode(array("segmentos"=>$aNum));
?>