<?php

require_once("../../php/restrict.php");
include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");
 if(!isset($_SESSION)){ session_start(); }

$idActividad=$_POST["idActividadCerrar"];
$creador = $_SESSION["idUsuario"];
$codigocliente=$_POST["codigocliente"];

date_default_timezone_set("America/Bogota");


$aDatos["fechaCreacion"]=$_POST["fecha"]; 
$aDatos["horaCreacion"]=$_POST["hora"]; 
$aDatos["motivo"]=$_POST["motivo"];
$aDatos["creador"]=$creador;
$aDatos["estado"]=$_POST["cerrado"];

if ($_POST["valorfinal"] != "" and $_POST["descripcionfinal"]) {
	$aDatos["valor"]=$_POST["valorfinal"];
	$aDatos["descripcion"]=$_POST["descripcionfinal"];
}



// echo $idActividad;
// echo $aDatos["fechaCreacion"];
// echo $aDatos["horaCreacion"];
// echo $aDatos["motivo"];
// echo $aDatos["creador"];
// echo $aDatos["valor"];
// echo $aDatos["estado"];
// echo $aDatos["descripcion"];
	

		$oItem=new Data("actividades","idActividad",$idActividad); 
		foreach($aDatos  as $key => $value){
		$oItem->$key=$value; 
		}
		$oItem->guardar(); 
		unset($oItem);


		
	  header('location: ../../negocios/',$codigocliente);
 ?>
 