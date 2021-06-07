<?php

require_once("../../php/restrict.php");
include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

$codigocliente=$_POST["codigocliente"];

date_default_timezone_set("America/Bogota");
 

$aDatos["tipo"]="negocio";
$aDatos["fechaCreacion"]=$_POST["fecha"]; 
$aDatos["horaCreacion"]=$_POST["hora"]; 
$aDatos["vencimiento"]=$_POST["vencimiento"];
$aDatos["encargado"]=$_POST["empleadoEncargado"];
$aDatos["estado"]="negociacion";
$aDatos["motivo"]=trim($_POST["negocio"]);

$aDatos["creador"]=$_POST["creador"];
$aDatos["icono"]="5";
$aDatos["idCliente"]=$codigocliente;
$aDatos["valor"]=$_POST["valor"];

// echo $aDatos["tipo"];
// echo "-";
// echo $aDatos["fechaCreacion"];
// echo "-";
// echo $aDatos["horaCreacion"];
// echo "-";
// echo $aDatos["vencimiento"];
// echo "Encargado:";
// echo $aDatos["encargado"];
// echo "Creador:";
// echo $aDatos["creador"];
// echo "-";
// echo $aDatos["icono"];
// echo "-";
// echo $aDatos["idCliente"];
// echo "-";
// echo $aDatos["valor"];
// echo "-";
// echo $aDatos["estado"];
// echo "-";
// echo $aDatos["descripcion"];

$oItem=new Data("actividades","idActividad"); 
    foreach($aDatos  as $key => $value){
        $oItem->$key=$value; 
    }
    $oItem->guardar(); 
    $codigoa=$oItem->ultimoId(); 
    unset($oItem);


if ($_POST["empleadoEncargado"] != "" and $_POST["vencimiento"] != "") {
	
	$tDatos["motivo"]="negociar con el cliente ".$_POST["negocio"];

		$tDatos["encargado"]=$_POST["empleadoEncargado"];
	
	$tDatos["vencimiento"]=$_POST["vencimiento"];

	$tDatos["fechaCreacion"]=$_POST["fecha"]; 
	$tDatos["horaCreacion"]=$_POST["hora"]; 
	$tDatos["creador"]=$_POST["creador"];
	$tDatos["tipo"]="tarea";
	$tDatos["icono"]="4";	
	$tDatos["estado"]="pendiente";
    $tDatos["idCliente"]=$_POST["codigocliente"];
	
	$oItem=new Data("actividades","idActividad"); 
    foreach($tDatos  as $key => $value){
        $oItem->$key=$value; 
    }
    $oItem->guardar(); 
    $codigo=$oItem->ultimoId(); 
    unset($oItem);

}	
	$cDatos["fechaUltimoContacto"]=$aDatos["fechaCreacion"];

	$oItem=new Data("t_clientes","codigoCliente",$codigocliente); 
	foreach($cDatos  as $key => $value){
	$oItem->$key=$value; 
	}
	$oItem->guardar(); 
	unset($oItem);


	
  header('location: ../../negocios/',$codigocliente);
 ?>
 