<?php
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");
require_once("../../class/empresa.php"); 

$oEmpresa=new Empresa(); 
date_default_timezone_set("America/Bogota"); 

$anio  = (isset($_REQUEST['anio'] ) ? $_REQUEST['anio'] : "" );
$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );

//$aCuentas=$oEmpresa->getCuentaSituacionFinanciera(array("idBalanceGeneral"=>$idBalanceGeneral,"tipo"=>3));


for ($i=1; $i <= 12 ; $i++) { 
$oLista = new Lista('balance_general');
$oLista->setFiltro("idEmpresa","=",$idEmpresa);
$oLista->setFiltro("periodoMes","=",$i);
$oLista->setFiltro("periodoAnio","=",$anio);
$aBalance=$oLista->getLista();
unset($oLista);	

$oLista = new Lista('balance_general_item');
$oLista->setFiltro("idBalanceGeneral","=",$aBalance[0]["idBalanceGeneral"]);
$aItems=$oLista->getLista();
unset($oLista);
	$pos=0; 

	foreach ($aItems as $key => $value) {
		
		$oLista = new Lista('balance_general_cuenta');
		$oLista->setFiltro("idBalanceGeneralItem","=",$value["idBalanceGeneralItem"]);
		$aCuentas=$oLista->getLista();
		unset($oLista);

		foreach($aCuentas as  $iCuenta){
			$iArray[$pos]["numeroCuenta"]=$iCuenta["numeroCuenta"];
			$iArray[$pos]["nombreCuenta"]=$iCuenta["nombreCuenta"];
			$iArray[$pos][$i]["valor"]="$".number_format($iCuenta["valor"],0,".",","); 
			$pos++; 
		}
		if(count($aCuentas)==0&&$value["tipo"]==3){
			$iArray[$pos]["titulo"]=$value["titulo"]; 
			$iArray[$pos][$i]["valor"]="$".number_format($value["total"],0,".",",");
			// $valorAcumulado+=$valor; 
			// $valor=0; 
			// if($aItems[$key+1]["tipo"]==3){
			// 	$valor=$valorAcumulado; 
			// 	$valorAcumulado=0; 
			// }
			
			$pos++; 
		}
	}
}

echo json_encode($iArray);

?>