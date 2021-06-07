<?php

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota");

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

 
 
    if(!isset($_SESSION)){ session_start(); }


$codigocliente=$datos["codigocliente"];

 

$aDatos["tipo"]="negocio";
$aDatos["fechaCreacion"]=$datos["fecha"]; 
$aDatos["horaCreacion"]=$datos["hora"]; 
$aDatos["vencimiento"]=$datos["vencimiento"];
$aDatos["encargado"]=$datos["empleadoEncargado"];
$aDatos["estado"]="negociacion";
$aDatos["motivo"]=trim($datos["negocio"]);

$aDatos["creador"]=$datos["creador"];
$aDatos["icono"]="5";
$aDatos["idCliente"]=$codigocliente;
$aDatos["valor"]=str_replace("$", "", str_replace(".", "", $datos["valor"]));

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


if ($datos["empleadoEncargado"] != "" and $datos["vencimiento"] != "") {
	
	$tDatos["motivo"]="negociar con el cliente ".$datos["negocio"];

		$tDatos["encargado"]=$datos["empleadoEncargado"];
	
	$tDatos["vencimiento"]=$datos["vencimiento"];

	$tDatos["fechaCreacion"]=$datos["fecha"]; 
	$tDatos["horaCreacion"]=$datos["hora"]; 
	$tDatos["creador"]=$datos["creador"];
	$tDatos["tipo"]="tarea";
	$tDatos["icono"]="4";	
	$tDatos["estado"]="pendiente";
    $tDatos["idCliente"]=$datos["codigocliente"];
	
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



$msg=true;

echo json_encode(array("msg"=>$msg));
	
  // header('location: ../../negocios/',$codigocliente);
 ?>
 