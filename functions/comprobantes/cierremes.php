<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );
$mes  = (isset($_REQUEST['mes'] ) ? $_REQUEST['mes'] : "" );




if(!isset($_SESSION)){ session_start(); }


$aDatos["mes"]=$mes;

$aDatos["idEmpresa"]=$idEmpresa;

$aDatos["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 

$aDatos["fechaRegistro"]=date("Y-m-d H:i:s"); 

$oItem=new Data("cierre_mes_contable","idCierreMesContable"); 

foreach($aDatos  as $key => $value){
    $oItem->$key=$value; 
}
$oItem->guardar();  
unset($oItem);

    $msg=true; 

    echo json_encode(array("msg"=>$msg));

?>