<?php 
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "control.php");

$oControl=new Control();

if(!isset($_SESSION)){ session_start(); }

$oItem = new Data('usuario',"idUsuario", $_SESSION["idUsuario"]);
$aUser=$oItem->getDatos();
unset($oItem);

unset($_SESSION["idRolPrincipal"]); 
unset($_SESSION["idEmpresa"]); 

$_SESSION["idRol"]=$aUser["idRol"]; 

header("Location: ../../inicio");
?>