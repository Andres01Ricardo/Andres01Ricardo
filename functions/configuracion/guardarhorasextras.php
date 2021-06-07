<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$oLista = new Lista('horas_extras');
$oLista->setFiltro("anio","=",$datos["anio"]);
$aListas=$oLista->getLista();
unset($oLista);

if(count($aListas)>0){
$oItem=new Data("horas_extras","idHorasExtras",$aListas[0]["idHorasExtras"]); 
}else{
$oItem=new Data("horas_extras","idHorasExtras"); 
}
foreach($datos  as $key => $value){
    $oItem->$key=$value; 
}
$oItem->guardar(); 
unset($oItem);


$oLista = new Lista('horas_extras');
$aLista=$oLista->getLista();
unset($oLista);

$msg=true; 

echo json_encode(array("msg"=>$msg,"lista"=>$aLista));
?>