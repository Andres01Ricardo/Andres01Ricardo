<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );
$id  = (isset($_REQUEST['id'] ) ? $_REQUEST['id'] : "" );


$aDatos["tipoPersona"]=$datos["tipoPersona"]; 
$aDatos["nit"]=$datos["nit"]; 
$aDatos["digitoVerificador"]=$datos["digitoVerificador"]==""?0:$datos["digitoVerificador"]; 
$aDatos["razonSocial"]=$datos["razonSocial"]; 
$aDatos["email"]=$datos["email"]; 
$aDatos["telefono"]=$datos["telefono"]; 
$aDatos["idDepartamento"]=$datos["idDepartamento"]; 
$aDatos["idCiudad"]=$datos["idCiudad"]; 
$aDatos["direccion"]=$datos["direccion"]; 

$oItem=new Data("proveedor","idProveedor",$id); 
foreach($aDatos  as $key => $value){
$oItem->$key=$value; 
}
$oItem->guardar(); 
unset($oItem);


$msg=true; 


echo json_encode(array("msg"=>$msg));
?>