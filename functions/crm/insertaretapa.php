<?php
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota");
if(!isset($_SESSION)){ session_start(); }
 
$aDatos["nombreEtapa"]=$_POST["etapa"]; 
$aDatos["color"]=$_POST["color"]; 
$aDatos["idEmpresa"]=$_SESSION["idEmpresa"]; 


$oItem=new Data("t_etapas","codigo"); 
    foreach($aDatos  as $key => $value){
        $oItem->$key=$value; 
    }
    $oItem->guardar(); 
    $codigo=$oItem->ultimoId(); 
    unset($oItem);


  header('location: ../../pipeline');

 ?>