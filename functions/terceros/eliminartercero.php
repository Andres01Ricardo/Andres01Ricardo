<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");


include_once("../../class/terceros.php"); 

date_default_timezone_set("America/Bogota"); 


$idTercero=(isset($_REQUEST['idEliminar'] ) ? $_REQUEST['idEliminar'] : "" );
$idEmpresa=(isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );

	

	$oMovimientoEmpresa=new Terceros(); 
	$movimientoTerceroEmpresa=$oMovimientoEmpresa->getMovimientoTerceroEmpresa(array("idEmpresa"=>$idEmpresa,"idTercero"=>$idTercero));

	if (empty($movimientoTerceroEmpresa)) {

		$oLista=new Lista("tercero_empresa");
		$oLista->setFiltro("idTercero","=",$idTercero);
		$oLista->setFiltro("idEmpresa","=",$idEmpresa);
		$terceroE=$oLista->getLista();
		unset($oLista);

		foreach ($terceroE as $key => $value) {
			
			$oItem=new Data("tercero_empresa","idTerceroEmpresa",$value["idTerceroEmpresa"]); 
			$oItem->eliminar(); 
			unset($oItem);

		}

		$msg=true;	

	}
	if (!empty($movimientoTerceroEmpresa)) {
		$msg=false;
	}



echo json_encode(array("msg"=>$msg));

?>