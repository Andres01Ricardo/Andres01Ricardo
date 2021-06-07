<?php
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");
require_once("../../class/empresa.php"); 

$oEmpresa=new Empresa(); 
date_default_timezone_set("America/Bogota"); 

$idEstadoFinanciero  = (isset($_REQUEST['idEstadoFinanciero'] ) ? $_REQUEST['idEstadoFinanciero'] : "" );

$utilidadOperacional=$oEmpresa->getRentabilidadCuenta(array("idEstadoFinanciero"=>$idEstadoFinanciero,"cuenta"=>'UTILIDAD OPERACIONAL'))[0];
$utilidadBruta=$oEmpresa->getRentabilidadCuenta(array("idEstadoFinanciero"=>$idEstadoFinanciero,"cuenta"=>'UTILIDAD BRUTA'))[0];
$utilidadImpuestos=$oEmpresa->getRentabilidadCuenta(array("idEstadoFinanciero"=>$idEstadoFinanciero,"cuenta"=>'UTILIDAD ANTES DE IMPUESTOS'))[0];
$utilidadNeta=$oEmpresa->getRentabilidadCuenta(array("idEstadoFinanciero"=>$idEstadoFinanciero,"cuenta"=>'UTILIDAD NETA'))[0];

$utilidadOperacional["valor"]="$".number_format($utilidadOperacional["valor"],0,",","."); 
$utilidadBruta["valor"]="$".number_format($utilidadBruta["valor"],0,",","."); 
$utilidadImpuestos["valor"]="$".number_format($utilidadImpuestos["valor"],0,",","."); 
$utilidadNeta["valor"]="$".number_format($utilidadNeta["valor"],0,",","."); 


$utilidadOperacional["porcentaje"]=number_format($utilidadOperacional["porcentaje"],2,".",",")."%"; 
$utilidadBruta["porcentaje"]=number_format($utilidadBruta["porcentaje"],2,".",",")."%"; 
$utilidadImpuestos["porcentaje"]=number_format($utilidadImpuestos["porcentaje"],2,".",",")."%"; 
$utilidadNeta["porcentaje"]=number_format($utilidadNeta["porcentaje"],2,".",",")."%"; 


$aItem[]=$utilidadBruta; 
$aItem[]=$utilidadOperacional; 
$aItem[]=$utilidadImpuestos; 
$aItem[]=$utilidadNeta; 
echo json_encode(array($aItem));

?>