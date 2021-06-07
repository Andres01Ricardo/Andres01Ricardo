<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );



if(!isset($_SESSION)){ session_start(); }



$oLista=new Lista("fecha_retencion_iva"); 

$oLista->setFiltro("anio","=",$datos["anio"]); 

$oLista->setFiltro("tipoImpuesto","=",$datos["tipo"]);

$oLista->setFiltro("idPeriocidad","=",$datos["periocidad"]);

$aLista=$oLista->getLista(); 

unset($oItem);



if(!empty($aLista)){

	$oLista=new Lista("fecha_retencion_iva_item"); 

	$oLista->setFiltro("idFechaRetencionIva","=",$aLista[0]["idFechaRetencionIva"]); 

	$aDigitos=$oLista->getLista(); 

	unset($oItem);



	foreach ($aDigitos as $key => $value) {

		$oLista=new Lista("fecha_retencion_iva_periodo"); 

		$oLista->setFiltro("idFechaRetencionIvaItem","=",$value["idFechaRetencionIvaItem"]); 

		$aPeriodos=$oLista->getLista(); 

		unset($oItem);	



		foreach ($aPeriodos as $valor) {

		 $oItem=new Data("fecha_retencion_iva_periodo","idFechaRetencionIvaPeriodo",$valor["idFechaRetencionIvaPeriodo"]); 

		 $oItem->eliminar();

		 unset($oItem);

		}

		

		$oItem=new Data("fecha_retencion_iva_item","idFechaRetencionIvaItem",$value["idFechaRetencionIvaItem"]); 

		$oItem->eliminar();

		unset($oItem);

	}

	$id=$aLista[0]["idFechaRetencionIva"]; 

}else{

	$aData["idUsuarioRegistra"]=$_SESSION["idUsuario"];

	$aData["fechaRegistro"]=date("Y-m-d H:i:s");

	$aData["anio"]=$datos["anio"];

	$aData["tipoImpuesto"]=$datos["tipo"];

	$aData["idPeriocidad"]=$datos["periocidad"];

	$oItem=new Data("fecha_retencion_iva","idFechaRetencionIva"); 

	foreach($aData  as $key => $value){

	    $oItem->$key=$value; 

	}

	$oItem->guardar(); 

	$id=$oItem->ultimoId();

	unset($oItem);

}





foreach ($item as $key => $value) {

	

	foreach ($item[$value["digito"]]["dia"] as $key2 => $value2) {

		$dia=str_pad($value2, 2, "0", STR_PAD_LEFT);

		$mes=str_pad($item[$value["digito"]]["mes"][$key2], 2, "0", STR_PAD_LEFT);

		$aItem["idFechaRetencionIva"]=$id; 

		$aItem["fechaLimite"]=$item[$value["digito"]]["anio"][$key2]."-".$mes."-".$dia; 

		$aItem["digito"]=$value["digito"]; 

		$aItem["tipo"]=$datos["tipo"]; 


		$oItem=new Data("fecha_retencion_iva_item","idFechaRetencionIvaItem"); 

		foreach($aItem  as $pos => $valor){

		    $oItem->$pos=$valor; 

		}

		$oItem->guardar(); 

		$idItem=$oItem->ultimoId();

		unset($oItem);



		$periodos=explode(",", $item[$value["digito"]]["periodos"][$key2]); 

		foreach ($periodos as $periodo) {

			# code...

			$iPer["mes"]=$periodo;

			$iPer["idFechaRetencionIvaItem"]=$idItem; 



			$oItem=new Data("fecha_retencion_iva_periodo","idFechaRetencionIvaPeriodo"); 

			foreach($iPer  as $pos => $valor){

			    $oItem->$pos=$valor; 

			}

			$oItem->guardar(); 

			unset($oItem);

		}

	}

	

}



$msg=true; 



echo json_encode(array("msg"=>$msg));

?>