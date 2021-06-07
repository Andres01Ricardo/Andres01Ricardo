<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$id  = (isset($_REQUEST['id'] ) ? $_REQUEST['id'] : "" );







$oItem=new Data("proveedor","nit",$datos["nitAnterior"]); 
$aproveedor=$oItem->getDatos();
unset($oItem);

if (empty($aproveedor)) {
	$oItem=new Data("proveedor","razonSocial",$datos["razonSocialAnterior"]); 
	$aproveedorR=$oItem->getDatos();
	unset($oItem);
	if (!empty($aproveedorR)) {
		$aDatosC["tipoPersona"]=$datos["tipoPersona"]; 

		$aDatosC["nit"]=$datos["nit"]; 

		$aDatosC["digitoVerificador"]=$datos["digitoVerificador"]==""?0:$datos["digitoVerificador"]; 

		$aDatosC["razonSocial"]=$datos["razonSocial"]; 

		$aDatosC["email"]=$datos["email"]; 

		$aDatosC["telefono"]=$datos["telefono"]; 

		$aDatosC["idDepartamento"]=$datos["idDepartamento"]; 

		$aDatosC["idCiudad"]=$datos["idCiudad"]; 

		$aDatosC["direccion"]=$datos["direccion"]; 


		$oItem=new Data("proveedor","idProveedor",$aproveedorR["idProveedor"]); 

		foreach($aDatosC  as $keyC => $valueC){

		$oItem->$keyC=$valueC; 

		}

		$oItem->guardar(); 

		unset($oItem);
	}
}
if (!empty($aproveedor)) {
		$aDatosC["tipoPersona"]=$datos["tipoPersona"]; 

		$aDatosC["nit"]=$datos["nit"]; 

		$aDatosC["digitoVerificador"]=$datos["digitoVerificador"]==""?0:$datos["digitoVerificador"]; 

		$aDatosC["razonSocial"]=$datos["razonSocial"]; 

		$aDatosC["email"]=$datos["email"]; 

		$aDatosC["telefono"]=$datos["telefono"]; 

		$aDatosC["idDepartamento"]=$datos["idDepartamento"]; 

		$aDatosC["idCiudad"]=$datos["idCiudad"]; 

		$aDatosC["direccion"]=$datos["direccion"]; 


		$oItem=new Data("proveedor","idProveedor",$aproveedor["idProveedor"]); 

		foreach($aDatosC  as $keyC => $valueC){

		$oItem->$keyC=$valueC; 

		}

		$oItem->guardar(); 

		unset($oItem);
}

$oItem=new Data("empresa","nit",$datos["nitAnterior"]); 
$aEmpresa=$oItem->getDatos();
unset($oItem);



if (empty($aEmpresa)) {
	$oItem=new Data("empresa","razonSocial",$datos["razonSocialAnterior"]); 
	$aEmpresaR=$oItem->getDatos();
	unset($oItem);
	if (!empty($aEmpresaR)) {
		$aDatosE["tipoPersona"]=$datos["tipoPersona"]; 

		$aDatosE["nit"]=$datos["nit"]; 

		$aDatosE["digitoVerificador"]=$datos["digitoVerificador"]==""?0:$datos["digitoVerificador"]; 

		$aDatosE["razonSocial"]=$datos["razonSocial"]; 

		$aDatosE["email"]=$datos["email"]; 

		$aDatosE["telefono"]=$datos["telefono"]; 

		$aDatosE["idDepartamento"]=$datos["idDepartamento"]; 

		$aDatosE["idCiudad"]=$datos["idCiudad"]; 

		$aDatosE["direccion"]=$datos["direccion"]; 


		$oItem=new Data("empresa","idEmpresa",$aEmpresaR["idEmpresa"]); 

		foreach($aDatosE  as $keyE => $valueE){

		$oItem->$keyE=$valueE; 

		}

		$oItem->guardar(); 

		unset($oItem);
	}
}
if (!empty($aEmpresa)) {
		$aDatosE["tipoPersona"]=$datos["tipoPersona"]; 

		$aDatosE["nit"]=$datos["nit"]; 

		$aDatosE["digitoVerificador"]=$datos["digitoVerificador"]==""?0:$datos["digitoVerificador"]; 

		$aDatosE["razonSocial"]=$datos["razonSocial"]; 

		$aDatosE["email"]=$datos["email"]; 

		$aDatosE["telefono"]=$datos["telefono"]; 

		$aDatosE["idDepartamento"]=$datos["idDepartamento"]; 

		$aDatosE["idCiudad"]=$datos["idCiudad"]; 

		$aDatosE["direccion"]=$datos["direccion"]; 


		$oItem=new Data("empresa","idEmpresa",$aEmpresa["idEmpresa"]);

		foreach($aDatosE  as $keyE => $valueE){

		$oItem->$keyE=$valueE; 

		}

		$oItem->guardar(); 

		unset($oItem);
}















$aDatos["tipoPersona"]=$datos["tipoPersona"]; 

$aDatos["nit"]=$datos["nit"]; 

$aDatos["digitoVerificador"]=$datos["digitoVerificador"]; 

$aDatos["razonSocial"]=$datos["razonSocial"]; 

$aDatos["email"]=$datos["email"]; 

$aDatos["telefono"]=$datos["telefono"]; 

$aDatos["idDepartamento"]=$datos["idDepartamento"]; 

$aDatos["idCiudad"]=$datos["idCiudad"]; 

$aDatos["direccion"]=$datos["direccion"]; 



$oItem=new Data("cliente","idCliente",$id); 

foreach($aDatos  as $key => $value){

$oItem->$key=$value; 

}

$oItem->guardar(); 

unset($oItem);





$msg=true; 





echo json_encode(array("msg"=>$msg));

?>