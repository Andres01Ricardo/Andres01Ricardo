<?php

require_once("../../php/restrict.php");

require_once("../../class/productoservicio.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 

$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );

$tipo  = (isset($_REQUEST['tipo'] ) ? $_REQUEST['tipo'] : "" );




$oItem=new Data("empresa","idEmpresa",$idEmpresa);
$empresa=$oItem->getDatos();
unset($oItem);


if ($empresa["manejaContabilidad"]==1 && $empresa["manejaInventario"]==1) {
	
	// $oLista=new Lista("producto_contable");
	// $oLista->setFiltro("idEmpresa","=",$idEmpresa);	
	// $aServicios=$oLista->getLista();
	// unset($oLista);
	$tipoP=1;

}else{

	$tipoP=2;
}

	$oProductoServicio=new ProductoServicio(); 
	$aFiltro["idEmpresa"]=$idEmpresa; 
	$aFiltro["tipo"]=$tipo; 
	$aServicios=$oProductoServicio->getProductosServicios($aFiltro); 
// echo json_encode(array("msg"=>$msg));
echo json_encode(array("productos"=>$aServicios,"tipo"=>$tipoP)); 

?>

