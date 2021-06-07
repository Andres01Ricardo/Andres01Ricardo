<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );
$id  = (isset($_REQUEST['id'] ) ? $_REQUEST['id'] : "" ); 

$datos["estado"]=1; 
if($id!=""){
    $oItem=new Data("retencion","idRetencion",$id); 
}else{
    $oItem=new Data("retencion","idRetencion"); 
}
if($datos["tipo"]==1){
$datos["idDepartamento"]=0; 
$datos["idCiudad"]=0;    
}

foreach($datos  as $key => $value){
    $oItem->$key=$value; 
}
$oItem->guardar(); 
unset($oItem);


$oLista = new Lista('retencion');
$aListas=$oLista->getLista();
unset($oLista);

foreach($aListas as $index=>$iItem){
    $oItem=new Data("ciudad","idCiudad",$iItem["idCiudad"]); 
    $aCiudad=$oItem->getDatos(); 
    unset($oItem); 

    $oItem=new Data("departamento","idDepartamento",$iItem["idDepartamento"]); 
    $aDepartamento=$oItem->getDatos(); 
    unset($oItem);

    $aListas[$index]["ciudad"]=$aCiudad["nombre"]." - ".$aDepartamento["nombre"]; 
}
$msg=true; 

echo json_encode(array("msg"=>$msg,"lista"=>$aListas));
?>