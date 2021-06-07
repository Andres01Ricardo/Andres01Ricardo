<?php
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota");


 
 
    if(!isset($_SESSION)){ session_start(); }

$aDatos["tipo_documento"]=$_POST["tipoDocumento"]; 
$aDatos["idCliente"]=$_POST["documento"]; 
$aDatos["nombre"]=$_POST["nombre"];
$aDatos["apellidos"]=$_POST["apellidos"]; 
$aDatos["email"]=$_POST["email"]; 
$aDatos["telefono"]=$_POST["telefono"]; 

if ($_POST["procedencia"] == 0) {
    $aDatos["procedencia"]=0;
}if ($_POST["procedencia"] != 0) {

    $aDatos["procedencia"]=$_POST["procedencia"]; 
}
$aDatos["direccion"]=$_POST["direccion"]; 

if ($_POST["empleadoEncargado"] == 0) {

    $aDatos["encargado"]=$_SESSION["idUsuario"]; 
}if ($_POST["empleadoEncargado"] != 0) {

    $aDatos["encargado"]=$_POST["empleadoEncargado"];
}      
    
$aDatos["etapa"]=$_POST["etapa"];
$aDatos["fechaUltimoContacto"]=date("Y-m-d");
$aDatos["fechaCreacion"]=date("Y-m-d");
$aDatos["idUsuarioRegistra"]=$_SESSION["idUsuario"];  
$aDatos["idEmpresa"]=$_SESSION["idEmpresa"]; 




$oItem=new Data("t_clientes","codigoCliente"); 
    foreach($aDatos  as $key => $value){
        $oItem->$key=$value; 
    }
    $oItem->guardar(); 
    $codigoCliente=$oItem->ultimoId(); 
    unset($oItem);




    $cDatos["tipo"]='creado';
    $cDatos["fechaCreacion"] = $aDatos["fechaCreacion"];
    $cDatos["horaCreacion"] =date("H:m:s");
    $cDatos["creador"] = $aDatos["idUsuarioRegistra"];
    $cDatos["icono"] = '6';
    $cDatos["idCliente"] = $codigoCliente;

    $oItem=new Data("actividades","idActividad"); 
    foreach($cDatos  as $key => $value){
    $oItem->$key=$value; 
    }
    $oItem->guardar(); 
    unset($oItem);


    $dDatos["fechaNotificacion"]=date("Y-m-d H:m:s");
    $dDatos["idUsuarioRegistra"] = $aDatos["idUsuarioRegistra"];
    $dDatos["idUsuarioNotificado"] =$_POST["empleadoEncargado"];
    $dDatos["notificacion"] = 'Le fue asignado el cliente '.$_POST["nombre"].' '.$_POST["apellidos"];
    

    $oItem=new Data("notificacion","idNotificacion"); 
    foreach($dDatos  as $key => $value){
    $oItem->$key=$value; 
    }
    $oItem->guardar(); 
    unset($oItem);



    
    header('location: ../../pipeline');



 ?>
