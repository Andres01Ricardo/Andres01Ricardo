<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

// $item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );



    if(!isset($_SESSION)){ session_start(); }

    $aDatos["contrato"]=$datos["contrato"]; 

    $aDatos["ciudadDesde"]=$datos["idCiudad"]; 

    $aDatos["ciudadHasta"]=$datos["idCiudadHacia"]; 

    $aDatos["departamentoDesde"]=$datos["idDepartamento"]; 

    $aDatos["departamentoHasta"]=$datos["idDepartamentoHacia"]; 
    
    $aDatos["motivo"]=$datos["motivoViaje"]; 

    $aDatos["persona"]=$datos["idEmpleado"]; 

    $aDatos["fechaLegalizacion"]=date("Y-m-d"); 


    $aDatos["inicioViaje"]=$datos["inicioViaje"];

    $aDatos["finViaje"]=$datos["finViaje"];

    $aDatos["primerViaje"]=$datos["primerViaje"]; 
    $aDatos["idEmpresa"]=$_SESSION["idEmpresa"];
    



    $oItem=new Data("proyecto_legalizacion","idProyectoLegalizacion"); 

    foreach($aDatos  as $key => $value){

        $oItem->$key=$value; 

    }

    $oItem->guardar(); 

    unset($oItem);



    $msg=true; 



echo json_encode(array("msg"=>$msg));

?>