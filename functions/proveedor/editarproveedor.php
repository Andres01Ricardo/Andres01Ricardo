<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$id  = (isset($_REQUEST['id'] ) ? $_REQUEST['id'] : "" );


$oItem=new Data("cliente","nit",$datos["nitAnterior"]); 
$aCliente=$oItem->getDatos();
unset($oItem);

if (empty($aCliente)) {
	$oItem=new Data("cliente","razonSocial",$datos["razonSocialAnterior"]); 
	$aClienteR=$oItem->getDatos();
	unset($oItem);
	if (!empty($aClienteR)) {
		$aDatosC["tipoPersona"]=$datos["tipoPersona"]; 

		$aDatosC["nit"]=$datos["nit"]; 

		$aDatosC["digitoVerificador"]=$datos["digitoVerificador"]==""?0:$datos["digitoVerificador"]; 

		$aDatosC["razonSocial"]=$datos["razonSocial"]; 

		$aDatosC["email"]=$datos["email"]; 

		$aDatosC["telefono"]=$datos["telefono"]; 

		$aDatosC["idDepartamento"]=$datos["idDepartamento"]; 

		$aDatosC["idCiudad"]=$datos["idCiudad"]; 

		$aDatosC["direccion"]=$datos["direccion"]; 


		$oItem=new Data("cliente","idCliente",$aClienteR["idCliente"]); 

		foreach($aDatosC  as $keyC => $valueC){

		$oItem->$keyC=$valueC; 

		}

		$oItem->guardar(); 

		unset($oItem);
	}
}
if (!empty($aCliente)) {
		$aDatosC["tipoPersona"]=$datos["tipoPersona"]; 

		$aDatosC["nit"]=$datos["nit"]; 

		$aDatosC["digitoVerificador"]=$datos["digitoVerificador"]==""?0:$datos["digitoVerificador"]; 

		$aDatosC["razonSocial"]=$datos["razonSocial"]; 

		$aDatosC["email"]=$datos["email"]; 

		$aDatosC["telefono"]=$datos["telefono"]; 

		$aDatosC["idDepartamento"]=$datos["idDepartamento"]; 

		$aDatosC["idCiudad"]=$datos["idCiudad"]; 

		$aDatosC["direccion"]=$datos["direccion"]; 


		$oItem=new Data("cliente","idCliente",$aCliente["idCliente"]); 

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

$aDatos["digitoVerificador"]=$datos["digitoVerificador"]==""?0:$datos["digitoVerificador"]; 

$aDatos["razonSocial"]=$datos["razonSocial"]; 

$aDatos["email"]=$datos["email"]; 

$aDatos["telefono"]=$datos["telefono"]; 

$aDatos["idDepartamento"]=$datos["idDepartamento"]; 

$aDatos["idCiudad"]=$datos["idCiudad"]; 

$aDatos["direccion"]=$datos["direccion"]; 



$oItem=new Data("proveedor","idProveedor",$id); 

foreach($aDatos  as $key => $value){

$oItem->$key=$value; 

}

$oItem->guardar(); 

unset($oItem);


// if ($checkCliente==1) {
// 	$aDatos["tipoPersona"]=$datos["tipoPersona"]; 

//     $aDatos["nit"]=$datos["nit"]; 

//     $aDatos["digitoVerificador"]=$datos["digitoVerificador"]==""?"":$datos["digitoVerificador"]; 

//     $aDatos["razonSocial"]=$datos["razonSocial"]; 

//     $aDatos["email"]=$datos["email"]; 

//     $aDatos["telefono"]=$datos["telefono"]; 

//     $aDatos["idDepartamento"]=$datos["idDepartamento"]; 

//     $aDatos["idCiudad"]=$datos["idCiudad"]; 

//     $aDatos["direccion"]=$datos["direccion"]; 

//     $aDatos["fechaRegistro"]=date("Y-m-d H:i:s");

//     $aDatos["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 

//     $aDatos["estado"]=1; 



//     $oItem=new Data("cliente","idCliente"); 

//     foreach($aDatos  as $key => $value){

//         $oItem->$key=$value; 

//     }

//     $oItem->guardar(); 

//     $idCliente=$oItem->ultimoId(); 

//     unset($oItem);



//     foreach ($item as $key => $value) {

//         if($value["estado"]==1){

//         $oItem=new Data("cliente_empresa","idClienteEmpresa"); 

//         $oItem->idCliente=$idCliente; 

//         $oItem->idEmpresa=$value["idEmpresa"]; 

//         $oItem->guardar(); 

//         unset($oItem); 

//         }

//     }
// }

// if ($checkEmpresa==1) {
// 	# code...
// }


$msg=true; 





echo json_encode(array("msg"=>$msg));

?>