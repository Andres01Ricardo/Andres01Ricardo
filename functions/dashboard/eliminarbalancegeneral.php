<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 



$id  = (isset($_REQUEST['id'] ) ? $_REQUEST['id'] : "" );





$oItem=new Data("balance_general","idBalanceGeneral",$id); 

$aData=$oItem->getDatos(); 
$oItem->eliminar(); 


unset($oItem);





$oLista=new Lista("balance_general_item"); 

$oLista->setFiltro("idBalanceGeneral","=",$id); 

$aLista=$oLista->getLista(); 


unset($oItem);





foreach($aLista as $aItem){
	$oItem=new Data("balance_general_item","idBalanceGeneralItem",$aItem["idBalanceGeneralItem"]); 
	$oItem->eliminar(); 
	unset($oItem);

	$oLista=new Lista("balance_general_cuenta"); 

	$oLista->setFiltro("idBalanceGeneralItem","=",$aLista["idBalanceGeneralItem"]); 

	$aLista2=$oLista->getLista(); 

	unset($oItem);



	foreach($aLista2 as $aItem2){

		$oItem=new Data("balance_general_cuenta","idBalanceGeneralCuenta",$aItem2["idBalanceGeneralCuenta"]); 
		$oItem->eliminar(); 
		unset($oItem);

	}

	

    // $oItem=new Data("estado_financiero_item","idEstadoFinancieroItem",$aItem["idEstadoFinancieroItem"]); 

    // $oItem->eliminar(); 

    // unset($oItem);

}



// $oItem=new Data("estado_financiero","idEstadoFinanciero",$id); 

// $oItem->eliminar(); 

// unset($oItem);



// unlink("../../".$aData["anexo"]); 



$msg=true; 



echo json_encode(array("msg"=>$msg));

?>