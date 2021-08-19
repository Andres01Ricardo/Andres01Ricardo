<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 


// $idEliminar=(isset($_REQUEST['idEliminar'] ) ? $_REQUEST['idEliminar'] : "" );

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$provisiones  = (isset($_REQUEST['provisiones'] ) ? $_REQUEST['provisiones'] : "" );

if(!isset($_SESSION)){ session_start(); }

$nom=0;

$periodo=explode("-",$datos["periodo"]);

$datos["tiempoPago"]=$datos["tiempoPago"]==""?0:$datos["tiempoPago"]; 

$idNomina=$datos["idNominaEditar"]; 

	
$oLista = new Lista('nomina_empleado');
$oLista->setFiltro("idNomina","=",$idNomina);
$oLista->setFiltro("idEmpleado","=",$datos["idEmpleado"]);
$aEmpleado=$oLista->getLista();
unset($oLista);
$idNominaEmpleado=$aEmpleado[0]["idNominaEmpleado"];
if(!empty($aEmpleado)){
	$oItem=new Data("nomina_empleado","idNominaEmpleado",$aEmpleado[0]["idNominaEmpleado"]); 
		$oItem->eliminar(); 
		// $idNominaEmpleado=$aEmpleado[0]["idNominaEmpleado"];
		unset($oItem);
		$creada=1;
}

if ($creada==1) {
	$oLista = new Lista('nomina_empleado_adiciones');
	$oLista->setFiltro("idNominaEmpleado","=",$idNominaEmpleado);
	$aEmpleadoAdiciones=$oLista->getLista();
	unset($oLista);
	foreach ($aEmpleadoAdiciones as $keyA => $valueA) {
		$oItem=new Data("nomina_empleado_adiciones","idNominaEmpleadoAdiciones",$valueA["idNominaEmpleadoAdiciones"]);
		$oItem->eliminar();
		unset($oItem);
	}
	$oLista = new Lista('nomina_empleado_parafiscales');
	$oLista->setFiltro("idNominaEmpleado","=",$idNominaEmpleado);
	$aEmpleadoParafiscales=$oLista->getLista();
	unset($oLista);
	foreach ($aEmpleadoParafiscales as $keyA => $valueA) {
		$oItem=new Data("nomina_empleado_parafiscales","idNominaEmpleadoParafiscales",$valueA["idNominaEmpleadoParafiscales"]);
		$oItem->eliminar();
		unset($oItem);
	}
}


$oItem=new Data("empleado_provisiones","idEmpleado",$datos["idEmpleado"]);
$aProvisiones=$oItem->getDatos();
unset($oItem);

	$cesantias=str_replace("$", "", str_replace(".", "", $provisiones["cesantias"]));
	$interesesCesantias=str_replace("$", "", str_replace(".", "", $provisiones["interesesCesantias"]));
	$vacaciones=str_replace("$", "", str_replace(".", "", $provisiones["vacaciones"]));
	$prima=str_replace("$", "", str_replace(".", "", $provisiones["prima"]));

if (!empty($aProvisiones)) {


		$cesantiasActual=$aProvisiones["cesantias"];
		$interesesCesantiasActual=$aProvisiones["interesesCesantias"];
		$vacacionesActual=$aProvisiones["vacaciones"];
		$primaActual=$aProvisiones["prima"];


		$cesantiasFinal=floatval($cesantiasActual)-floatval($cesantias);
		$interesesCesantiasFinal=floatval($interesesCesantiasActual)-floatval($interesesCesantias);
		$vacacionesFinal=floatval($vacacionesActual)-floatval($vacaciones);
		$primaFinal=floatval($primaActual)-floatval($prima);


		$provisionesEF["cesantias"]=$cesantiasFinal;
		$provisionesEF["interesesCesantias"]=$interesesCesantiasFinal;
		$provisionesEF["vacaciones"]=$vacacionesFinal;
		$provisionesEF["prima"]=$primaFinal;


		$oItem=new Data("empleado_provisiones","idEmpleado",$datos["idEmpleado"]);
		foreach ($provisionesEF as $keyEF => $valueEF) {

		  $oItem->$keyEF=$valueEF; 

		}
		$oItem->guardar(); 

		unset($oItem);
	}



// $oItem=new Data("empleado","idEmpleado",$idEliminar); 
// $oItem->eliminar(); 
// unset($oItem);

// $oItem=new Data("empleado_informacion_laboral","idEmpleado",$idEliminar); 
// $oItem->eliminar(); 
// unset($oItem);

// $oItem=new Data("empleado_empresa","idEmpleado",$idEliminar); 
// $oItem->eliminar(); 
// unset($oItem);

// $oItem=new Data("empleado_usuario","idEmpleado",$idEliminar); 
// $oItem->eliminar(); 
// unset($oItem);



$msg=true; 


echo json_encode(array("msg"=>$msg));

?>