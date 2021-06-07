<?php

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

require_once("../../class/empresa.php"); 



$oEmpresa=new Empresa(); 

date_default_timezone_set("America/Bogota"); 



$anio  = (isset($_REQUEST['anio'] ) ? $_REQUEST['anio'] : "" );

$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );



for ($i=1; $i <= 12 ; $i++) { 

$oLista = new Lista('estado_financiero');

$oLista->setFiltro("idEmpresa","=",$idEmpresa);

$oLista->setFiltro("periodoMes","=",$i);

$oLista->setFiltro("periodoAnio","=",$anio);

$aFinanciera=$oLista->getLista();

unset($oLista);		



$oLista = new Lista('estado_financiero_item');

$oLista->setFiltro("idEstadoFinanciero","=",$aFinanciera[0]["idEstadoFinanciero"]);

$aItems=$oLista->getLista();

unset($oLista);

	$pos=0; 
// print_r($aItems);


	foreach ($aItems as $key => $value) {
		// print_r($value);
		
		if ($value["idEstadoFinancieroItem"]!="") {
			
				$iArray[$pos]["nombreCuenta"]=$value["cuenta"];
			if ($value["valor"]=="") {
				$iArray[$pos][$i]["valor"]="-";
			}
			if ($value["valor"]!="") {
				$iArray[$pos][$i]["valor"]="$".number_format($value["valor"],0,".",",");
			}
		}
			$pos++; 


	}

}

// print_r($iArray);
echo json_encode($iArray);

?>