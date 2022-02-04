<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();


$producto  = (isset($_REQUEST['producto'] ) ? $_REQUEST['producto'] : "" );
$empresa  = (isset($_REQUEST['empresa'] ) ? $_REQUEST['empresa'] : "" );
$tipoFactura  = (isset($_REQUEST['tipoFactura'] ) ? $_REQUEST['tipoFactura'] : "" );

$tipoProdcutos  = (isset($_REQUEST['tipoProdcutos'] ) ? $_REQUEST['tipoProdcutos'] : "" );

date_default_timezone_set("America/Bogota"); 


// $oLista=new Lista("producto_cuenta_contable");
// $oLista->setFiltro("idProducto","=",$producto);
// $oLista->setFiltro("idEmpresa","=",$empresa);
// $oLista->setFiltro("tipoFactura","=",$tipoFactura);
// $aProductoCuenta=$oLista->getLista();

// $oItem=new Data("cuenta_contable","idCuentaContable",$aProductoCuenta[0]["idEmpresaCuenta"]);
// $aCuentaContable=$oItem->getDatos();
// unset($oItem);




if ($tipoProdcutos==1) {
	$oLista=new Lista("producto_servicio");
	$oLista->setFiltro("idProductoServicio","=",$producto);
	$oLista->setFiltro("idEmpresa","=",$empresa);
	$aProductoCuenta=$oLista->getLista();	



	$oItem=new Data("grupo_inventario","idGrupoInventario",$aProductoCuenta[0]["idGrupo"]);
	$aGrupo=$oItem->getDatos();
	unset($oItem);
	if ($tipoFactura=='compra') {
		if ($aGrupo["costo"]==0) {
			$aGrupo='';
		}else{
			$aGrupo=1;
		}
	}
	if ($tipoFactura=='venta') {
		// code...
		if ($aGrupo["venta"]==0) {
			$aGrupo='';
		}else{
			$aGrupo=1;
		}
	}


}


if ($tipoProdcutos==2) {
	

	$oLista=new Lista("producto_servicio");
	$oLista->setFiltro("idProductoServicio","=",$producto);
	$oLista->setFiltro("idEmpresa","=",$empresa);
	$aProductoCuenta=$oLista->getLista();

	if ($tipoFactura=='compra') {
		if ($aProductoCuenta[0]["costo"]==0) {
			$aGrupo='';
			$msg=false;

		}else{
			$msg=true;
			$aGrupo=1;
		}
		// code...
	}
	if ($tipoFactura=='venta') {
		if ($aProductoCuenta[0]["venta"]==0) {
			$aGrupo='';
			$msg=false;

		}else{
			$msg=true;
			$aGrupo=1;
		}
	}


}



$msg=true; 

echo json_encode($aGrupo);

?>