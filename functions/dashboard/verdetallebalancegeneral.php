<?php
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");
require_once("../../class/empresa.php"); 

$oEmpresa=new Empresa(); 
date_default_timezone_set("America/Bogota"); 

$idBalanceGeneral  = (isset($_REQUEST['idBalanceGeneral'] ) ? $_REQUEST['idBalanceGeneral'] : "" );

$aCuentas=$oEmpresa->getCuentaSituacionFinanciera(array("idBalanceGeneral"=>$idBalanceGeneral,"tipo"=>3));


foreach ($aCuentas as $key => $iCuenta) {
	$aCuentas[$key]["valor"]="$".number_format($iCuenta["total"],0,",","."); 
	$aCuentas[$key]["porcentaje"]=number_format($iCuenta["porcentaje"],2,".",",")."%";

}

echo json_encode(array($aCuentas));

?>