<?php 

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "control.php");



$oControl=new Control();



if(!isset($_SESSION)){ session_start(); }

$id  = (isset($_REQUEST['id'] ) ? $_REQUEST['id'] : "" );





$decrip["cadena"]=$id; 

$id=$oControl->desencriptar($decrip);





$oItem = new Data('usuario',"idUsuario", $_SESSION["idUsuario"]);

$aUser=$oItem->getDatos();

unset($oItem);



// $_SESSION["idRol"]=3; 

$_SESSION["idRolPrincipal"]=$aUser["idRol"]; 

$_SESSION["idEmpresa"]=$id; 



echo json_encode(array("msg"=>true));

?>