<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

require_once("../../class/impuestos.php"); 



$oImpuestos=new Impuestos(); 

date_default_timezone_set("America/Bogota"); 



if(!isset($_SESSION)){ session_start(); }

$aDatos=array(); 





$meses[1]="Enero"; 

$meses[2]="Febrero"; 

$meses[3]="Marzo"; 

$meses[4]="Abril"; 

$meses[5]="Mayo"; 

$meses[6]="Junio"; 

$meses[7]="Julio"; 

$meses[8]="Agosto"; 

$meses[9]="Septiembre"; 

$meses[10]="Octubre"; 

$meses[11]="Noviembre"; 

$meses[12]="Diciembre";



if($_SESSION["idRol"]==2){

$aDatos["idUsuario"]=$_SESSION["idUsuario"]; 

}else if($_SESSION["idRol"]==3){

$aDatos["idEmpresa"]=$_SESSION["idEmpresa"]; 



$oItem=new Data("empresa","idEmpresa",$_SESSION["idEmpresa"]); 

$aEmpresa=$oItem->getDatos(); 

unset($oItem);



$aFiltro["digito"]=substr($aEmpresa["nit"], -1);

$aFiltro["idEmpresa"]=$_SESSION["idEmpresa"]; 

}



$aFiltro["anio"]=date("Y"); 

// $aFechas=$oImpuestos->getCalendario($aFiltro); 



// $aImpuestos=$oImpuestos->getFechaImpuestos($aDatos); 





$oLista=new Lista("fecha_impuesto"); 

$oLista->setGrupo("idCiudad"); 

$oLista->setOrden("fechaRegistro","DESC"); 

$aLista=$oLista->getLista(); 

unset($oItem);



$aIcas=array(); 

$aFechaIcas=array(); 

$aFechaIcasDigito=array(); 

foreach ($aLista as $key => $value) {

	$oItem=new Data("departamento","idDepartamento", $value["idDepartamento"]); 

    $aDepartamento=$oItem->getDatos(); 

    unset($oItem); 



    $oItem=new Data("ciudad","idCiudad", $value["idCiudad"]); 

    $aCiudad=$oItem->getDatos(); 

    unset($oItem);



	$oItem=new Data("periodo_pago","idPeriodoPago",$value["periodicidad"]); 

	$aPeriodo=$oItem->getDatos(); 

	unset($oItem);

	$configuracion=12/$aPeriodo["periodoMes"]; 



	

	for ($i=1; $i <= $configuracion; $i++) { 

		$aumentar=($i*$aPeriodo["periodoMes"]);

		if($value["tipoConfiguracion"]==1){

			$nuevafecha = strtotime ( '+'.$aumentar.' Months' , strtotime ( date('Y-01-'.str_pad($value["fechaPago"], 2, "0", STR_PAD_LEFT) ) ) ) ;

			$nuevafecha = date ( 'Y-m-d' , $nuevafecha );



			$aIcas["fecha"]=$nuevafecha; 

			$aIcas["ciudad"]=$aCiudad["nombre"]." - ".substr($aDepartamento["nombre"],0,3); 



			$aFechaIcas[]=$aIcas; 

		}else{

			$oLista=new Lista("fecha_impuesto_digito"); 

			$oLista->setFiltro("idFechaImpuesto","=",$value["idFechaImpuesto"]);

			if($_SESSION["idRol"]==3){

				$oLista->setFiltro("digito","=",substr($aEmpresa["nit"], -1));

			} 

			$aDigitos=$oLista->getLista(); 

			unset($oItem);

			foreach ($aDigitos as $digitos) {

				// $nuevafecha = strtotime ( '+'.$aumentar.' Months' , strtotime ( date('Y-01-'.str_pad($digitos["diaPago"], 2, "0", STR_PAD_LEFT) ) ) ) ;

				// $nuevafecha = date ( 'Y-m-d' , $nuevafecha );

				$nuevafecha=$digitos["diaPago"];

				$aIcas["fecha"]=$nuevafecha; 

				$aIcas["ciudad"]=$aCiudad["nombre"]." - ".substr($aDepartamento["nombre"],0,3); 

				$aIcas["digito"]=$digitos["digito"]; 



				$aFechaIcasDigito[]=$aIcas;

			}

		}

	}

		

	

	

}

echo json_encode(array("icas"=>$aFechaIcas,"icasDigito"=>$aFechaIcasDigito));

?>