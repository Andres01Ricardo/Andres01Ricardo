<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

require_once("../../class/comprobantes.php"); 


$idComprobanteRecurrente  = (isset($_REQUEST['idComprobanteRecurrente'] ) ? $_REQUEST['idComprobanteRecurrente'] : "" );



$oItem=new Lista("factura_compra");
$oItem->setFiltro("idEmpresa","=",$_SESSION["idEmpresa"]);
$oItem->setFiltro("estado","=",1);
$facturaCompraEnviada=$oItem->getLista();
unset($oItem); 

$oItem=new Lista("factura_compra");
$oItem->setFiltro("idEmpresa","=",$_SESSION["idEmpresa"]);
$oItem->setFiltro("estado","=",2);
$facturaCompraPendiente=$oItem->getLista();
unset($oItem); 

$oItem=new Lista("factura_compra");
$oItem->setFiltro("idEmpresa","=",$_SESSION["idEmpresa"]);
$oItem->setFiltro("estado","=",4);
$facturaCompraAbonada=$oItem->getLista();
unset($oItem); 



echo json_encode(array("enviada"=>$facturaCompraEnviada,"pendiente"=>$facturaCompraPendiente,"abonada"=>$facturaCompraAbonada));

?>
