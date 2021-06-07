<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$adiciones  = (isset($_REQUEST['adiciones'] ) ? $_REQUEST['adiciones'] : "" );

$ley  = (isset($_REQUEST['ley'] ) ? $_REQUEST['ley'] : "" );

$deducciones  = (isset($_REQUEST['deducciones'] ) ? $_REQUEST['deducciones'] : "" );

$provisiones  = (isset($_REQUEST['provisiones'] ) ? $_REQUEST['provisiones'] : "" );



if(!isset($_SESSION)){ session_start(); }

$nom=0;

$periodo=explode("-",$datos["periodo"]);

$datos["tiempoPago"]=$datos["tiempoPago"]==""?0:$datos["tiempoPago"]; 



// $oLista = new Lista('nomina');

// $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);

// $oLista->setFiltro("periodoMes","=",$periodo[0]);

// $oLista->setFiltro("periodoAnio","=",$periodo[1]);

// $oLista->setFiltro("tiempoPago","=",$datos["tiempoPago"]);

// $aNomina=$oLista->getLista();

// unset($oLista); 


$idNomina=$datos["idNominaEditar"]; 

	


$oLista = new Lista('nomina_empleado');

$oLista->setFiltro("idNomina","=",$idNomina);

$oLista->setFiltro("idEmpleado","=",$datos["idEmpleado"]);

$aEmpleado=$oLista->getLista();

unset($oLista);

		 

		$aDatosEmpleado["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 

		$aDatosEmpleado["salarioEmpleado"]=str_replace("$", "", str_replace(".", "", $datos["salario"]));

		$aDatosEmpleado["valorPagar"]=str_replace("$", "", str_replace(".", "", $datos["valorPagar"]));

		$aDatosEmpleado["dias"]=$datos["diasTrabajados"];
		
		$aDatosEmpleado["auxilioTransporte"]=str_replace("$", "", str_replace(".", "", $datos["auxilioTransporteInicial"]));


if(empty($aEmpleado)){

		
		$aDatosEmpleado["fechaRegistro"]=date("Y-m-d H:i:s");

		$aDatosEmpleado["idNomina"]=$idNomina; 

		$aDatosEmpleado["idEmpleado"]=$datos["idEmpleado"]; 


		$oItem=new Data("nomina_empleado","idNominaEmpleado"); 

		foreach ($aDatosEmpleado as $key => $value) {

		  $oItem->$key=$value; 

		}

		$oItem->guardar(); 

		$idNominaEmpleado=$oItem->ultimoId();

		unset($oItem);
		// $msg=true;

}	
if(!empty($aEmpleado)){
	$oItem=new Data("nomina_empleado","idNominaEmpleado",$aEmpleado[0]["idNominaEmpleado"]); 

		foreach ($aDatosEmpleado as $key => $value) {

		  $oItem->$key=$value; 

		}

		$oItem->guardar(); 

		$idNominaEmpleado=$aEmpleado[0]["idNominaEmpleado"];

		unset($oItem);
		$creada=1;

}
// if ($msg== true ) {
		# code...
	
if ($creada==1) {
	$oLista = new Lista('nomina_empleado_adiciones');

	$oLista->setFiltro("idNominaEmpleado","=",$idNominaEmpleado);

	// $oLista->setFiltro("idEmpleado","=",$datos["idEmpleado"]);

	$aEmpleadoAdiciones=$oLista->getLista();

	unset($oLista);
	foreach ($aEmpleadoAdiciones as $keyA => $valueA) {
		$oItem=new Data("nomina_empleado_adiciones","idNominaEmpleadoAdiciones",$valueA["idNominaEmpleadoAdiciones"]);
		$oItem->eliminar();
		unset($oItem);
	}


	$oLista = new Lista('nomina_empleado_parafiscales');

	$oLista->setFiltro("idNominaEmpleado","=",$idNominaEmpleado);

	// $oLista->setFiltro("idEmpleado","=",$datos["idEmpleado"]);

	$aEmpleadoAdiciones=$oLista->getLista();

	unset($oLista);
	foreach ($aEmpleadoAdiciones as $keyA => $valueA) {
		$oItem=new Data("nomina_empleado_parafiscales","idNominaEmpleadoParafiscales",$valueA["idNominaEmpleadoParafiscales"]);
		$oItem->eliminar();
		unset($oItem);
	}


	$oItem=new Data("empleado_provisiones","idEmpleado",$datos["idEmpleado"]);
	$empleadoProvisiones=$oItem->getDatos();
	unset($oItem);

}

		foreach($adiciones as $itemAdicion){

			$aAdicion["concepto"]=$itemAdicion["producto"]; 

			$aAdicion["idNominaEmpleado"]=$idNominaEmpleado; 

			$aAdicion["valor"]=str_replace("$", "", str_replace(".", "", $itemAdicion["valor"]));

			$oItem=new Data("nomina_empleado_adiciones","idNominaEmpleadoAdiciones"); 

			foreach ($aAdicion as $key => $value) {

			  $oItem->$key=$value; 

			}

			$oItem->guardar(); 

			unset($oItem);
			if ($itemAdicion["idProducto"]==4) {
				$valorVacaciones=str_replace("$", "", str_replace(".", "", $itemAdicion["valor"]));
			}

			if ($itemAdicion["idProducto"]!=7) {
				
			$iD["estado"]=2; 

			$oItem=new Data("empresa_novedad","idEmpresaNovedad",$itemAdicion["idNovedad"]); 

			foreach ($iD as $key => $value) {

			  $oItem->$key=$value; 

			}

			$oItem->guardar(); 

			unset($oItem);
			}

		}

// }


// if ($msg== true ) {

foreach($ley as $itemLey){

	$aDeduccion["concepto"]=$itemLey["producto"]; 

	$aDeduccion["idNominaEmpleado"]=$idNominaEmpleado; 

	$aDeduccion["valor"]=str_replace("$", "", str_replace(".", "", $itemLey["valor"])); 

	$aDeduccion["tipoDeduccion"]=$itemLey["tipoDeduccion"]==1?2:1; 

	$aDeduccion["tipoConcepto"]=$itemLey["tipoConcepto"]; 

	$oItem=new Data("nomina_empleado_parafiscales","idNominaEmpleadoParafiscales"); 

	foreach ($aDeduccion as $key => $value) {

	  $oItem->$key=$value; 

	}

	$oItem->guardar(); 

	unset($oItem);

	}
// }
// if ($msg==true ) {



	foreach($deducciones as $itemDeduccion){

		$iDeducir["concepto"]=$itemDeduccion["producto"]; 

		$iDeducir["idNominaEmpleado"]=$idNominaEmpleado; 

		$iDeducir["valor"]=str_replace("$", "", str_replace(".", "", $itemDeduccion["valor"]));

		$oItem=new Data("nomina_empleado_deducciones","idNominaEmpleadoDeducciones"); 

		foreach ($iDeducir as $key => $value) {

		  $oItem->$key=$value; 

		}

		$oItem->guardar(); 

		unset($oItem);


		// $iD["estado"]=2; 

		// $oItem=new Data("empresa_novedad","idEmpresaNovedad",$itemDeduccion["idNovedad"]); 

		// foreach ($iD as $key => $value) {

		//   $oItem->$key=$value; 

		// }

		// $oItem->guardar(); 

		// unset($oItem);



	}
// }


// if ($msg==true ) {
	$oItem=new Data("empleado_provisiones","idEmpleado",$datos["idEmpleado"]);
	$aProvisiones=$oItem->getDatos();
	unset($oItem);

	$cesantias=str_replace("$", "", str_replace(".", "", $provisiones["cesantias"]));
	$interesesCesantias=str_replace("$", "", str_replace(".", "", $provisiones["interesesCesantias"]));
	$vacaciones=str_replace("$", "", str_replace(".", "", $provisiones["vacaciones"]));
	$prima=str_replace("$", "", str_replace(".", "", $provisiones["prima"]));

	
	
	

	if (empty($aProvisiones)) {
		$provisionesE["idEmpleado"]=$datos["idEmpleado"];
		$provisionesE["cesantias"]=$cesantias;
		$provisionesE["interesesCesantias"]=$interesesCesantias;
		$provisionesE["vacaciones"]=$vacaciones;
		$provisionesE["prima"]=$prima;
		$oItem=new Data("empleado_provisiones","idEmpleadoProvisiones");

		foreach ($provisionesE as $keyE => $valueE) {

		  $oItem->$keyE=$valueE; 

		}
		$oItem->guardar(); 

		unset($oItem);
	}
	if (!empty($aProvisiones)) {


		$cesantiasActual=$aProvisiones["cesantias"];
		$interesesCesantiasActual=$aProvisiones["interesesCesantias"];
		$vacacionesActual=$aProvisiones["vacaciones"];
		$primaActual=$aProvisiones["prima"];


		$cesantiasFinal=floatval($cesantias)+floatval($cesantiasActual);
		$interesesCesantiasFinal=floatval($interesesCesantias)+floatval($interesesCesantiasActual);
		$vacacionesFinal=floatval($vacaciones)+floatval($vacacionesActual);
		$primaFinal=floatval($prima)+floatval($primaActual);


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




		$provisionesNomC["idNominaEmpleado"]=$idNominaEmpleado;
		$provisionesNomC["concepto"]='cesantias';
		$provisionesNomC["valor"]=$cesantias;
		$provisionesNomC["tipoProvision"]=1;


		$oItem=new Data("nomina_empleado_provisiones","idNominaEmpleadoProvisiones");
		foreach ($provisionesNomC as $keyNomC => $valueNomC) {

		  $oItem->$keyNomC=$valueNomC; 

		}
		$oItem->guardar(); 

		unset($oItem);


		$provisionesNomIC["idNominaEmpleado"]=$idNominaEmpleado;
		$provisionesNomIC["concepto"]='intereses cesantias';
		$provisionesNomIC["valor"]=$interesesCesantias;
		$provisionesNomIC["tipoProvision"]=2;

		$oItem=new Data("nomina_empleado_provisiones","idNominaEmpleadoProvisiones");
		foreach ($provisionesNomIC as $keyNomIC => $valueNomIC) {

		  $oItem->$keyNomIC=$valueNomIC; 

		}
		$oItem->guardar(); 

		unset($oItem);


		$provisionesNomV["idNominaEmpleado"]=$idNominaEmpleado;
		$provisionesNomV["concepto"]='vacaciones';
		$provisionesNomV["valor"]=$vacaciones;
		$provisionesNomV["tipoProvision"]=3;

		$oItem=new Data("nomina_empleado_provisiones","idNominaEmpleadoProvisiones");
		foreach ($provisionesNomV as $keyNomV => $valueNomV) {

		  $oItem->$keyNomV=$valueNomV; 

		}
		$oItem->guardar(); 

		unset($oItem);



		$provisionesNom["idNominaEmpleado"]=$idNominaEmpleado;
		$provisionesNom["concepto"]='prima';
		$provisionesNom["valor"]=$prima;
		$provisionesNom["tipoProvision"]=4;

		$oItem=new Data("nomina_empleado_provisiones","idNominaEmpleadoProvisiones");
		foreach ($provisionesNom as $keyNom => $valueNom) {

		  $oItem->$keyNom=$valueNom; 

		}
		$oItem->guardar(); 

		unset($oItem);
	

// }

$msg=true;
 
echo json_encode(array("msg"=>$msg));

?>