
<?php

header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");
include_once($CLASS . "control.php");

date_default_timezone_set("America/Bogota");
if(!isset($_SESSION)){ session_start(); 

    
}
 
$oControl=new Control();


$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );


$valorGuardar=str_replace("$", "", str_replace(".", "", $datos["valorfinal"]))-$datos["valorAnterior"];


    $oItem=new Lista("ajuste_impuestos");
    $oItem->setFiltro("idEmpresa","=",$datos["idEmpresa"]); 
    $oItem->setFiltro("tipoImpuesto","=",1); 

    $aDatos=$oItem->getLista(); 


    if (!empty($aDatos)) {

        // $dDatos["idEmpresa"]=$datos["idEmpresa"];
        $dDatos["valor"]=$aDatos[0]["valor"]+$valorGuardar;
        // $dDatos["tipoImpuesto"]=$datos["valorfinal"];



        $oItem=new Data("ajuste_impuestos","idAjusteImpuestos",$aDatos[0]["idAjusteImpuestos"]); 
        foreach($dDatos  as $key => $value){
        $oItem->$key=$value; 
        }
        $oItem->guardar(); 
        unset($oItem);
    }

    if (empty($aDatos)) {
        $dDatos["idEmpresa"]=$datos["idEmpresa"];
        $dDatos["valor"]=$valorGuardar;
        $dDatos["tipoImpuesto"]=$datos["tipoImpuesto"];



        $oItem=new Data("ajuste_impuestos","idAjusteImpuestos"); 
        foreach($dDatos  as $key => $value){
        $oItem->$key=$value; 
        }
        $oItem->guardar(); 
        unset($oItem);
    }
    
    
    
  


    
    







$msg=true; 



echo json_encode(array("msg"=>$msg));

 ?>

