<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");


$idclase  = (isset($_REQUEST['idclase'] ) ? $_REQUEST['idclase'] : "" );
$tipo  = (isset($_REQUEST['tipo'] ) ? $_REQUEST['tipo'] : "" );


// if($tipo==1){
	$oLista = new Lista('bienes');
	$oLista->setFiltro("idClase","=",$idclase);
	$lista=$oLista->getLista();
// }else{
// 	$oLista = new Lista('prestacion');
// 	$oLista->setFiltro("idClase","=",$idclase);
// 	$lista=$oLista->getLista();
// }

foreach($lista as $index => $item){
    $aNum[$index]["nombre"]=utf8_encode($item["nombre"]);
    $aNum[$index]["idBienes"]=$item["idBienes"];
    $aNum[$index]["codigo"]=$item["codigo"];
}

$error=true;

echo json_encode(array("bienes"=>$aNum));
?>