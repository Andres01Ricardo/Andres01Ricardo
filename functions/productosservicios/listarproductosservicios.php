<?php

require_once("../../php/restrict.php");



require_once("../../class/productoservicio.php");



date_default_timezone_set("America/Bogota"); 

$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );

$tipo  = (isset($_REQUEST['tipo'] ) ? $_REQUEST['tipo'] : "" );

// $oItem=new Data("empresa","idEmpresa",$idEmpresa);
// $empresa=$oItem->getDatos();
// unset($oItem);


	$oProductoServicio=new ProductoServicio(); 
	$aFiltro["idEmpresa"]=$idEmpresa; 

	$aServicios=$oProductoServicio->getProductosServicios($aFiltro); 


echo json_encode($aServicios); 

?>

