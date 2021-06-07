<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$id  = (isset($_REQUEST['id'] ) ? $_REQUEST['id'] : "" );
$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );


$oLista=new Lista("usuario_empresa"); 
$oLista->setFiltro("idUsuario","=",$id); 
$aLista=$oLista->getLista(); 
unset($oItem);

foreach($aLista as $aItem){
    $oItem=new Data("usuario_empresa","idUsuarioEmpresa",$aItem["idUsuarioEmpresa"]); 
    $oItem->eliminar(); 
    unset($oItem);
}
foreach ($item as $key => $value) {
    if($value["estado"]==1){
    $oItem=new Data("usuario_empresa","idUsuarioEmpresa"); 
    $oItem->idUsuario=$id; 
    $oItem->idEmpresa=$value["idEmpresa"]; 
    $oItem->guardar(); 
    unset($oItem); 
    }
}


$msg=true; 

 

echo json_encode(array("msg"=>$msg));
?>