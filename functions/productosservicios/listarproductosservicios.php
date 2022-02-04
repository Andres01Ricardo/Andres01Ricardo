<?php

require_once("../../php/restrict.php");



require_once("../../class/productoservicio.php");



date_default_timezone_set("America/Bogota"); 

$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );

$tipo  = (isset($_REQUEST['tipo'] ) ? $_REQUEST['tipo'] : "" );




$oItem=new Data("empresa","idEmpresa",$idEmpresa);
$empresa=$oItem->getDatos();
unset($oItem);


if ($empresa["manejaContabilidad"]==1 && $empresa["manejaInventario"]==1) {
	
	// $oLista("producto_contable");
	// $oLista->setFiltro("idEmpresa","=",$idEmpresa);	
	// $aServicios=$oLista->getLista();
	// unset($oLista);
	$tipo=1;
}else{

	$tipo=2;
}

	$oProductoServicio=new ProductoServicio(); 
	$aFiltro["idEmpresa"]=$idEmpresa; 
	$aFiltro["tipo"]=$tipo; 
	$aServicios=$oProductoServicio->getProductosServicios($aFiltro); 



echo json_encode(array("productos"=>$aServicios,"tipo"=>$tipo); 

?>

