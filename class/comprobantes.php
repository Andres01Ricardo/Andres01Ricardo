<?php

require_once($CLASS."sql.php"); 



class Comprobantes extends Sql{

	

	public function getComprobantesCuentas($cuenta,$desde,$hasta){


		if(!isset($_SESSION)){ session_start(); }

		$sql="SELECT ci.cuenta,ci.centroCosto,ci.tercero,ci.descripcion,ci.dc,ci.valor,concat(tdc.letra,'-00',pd.comprobante,'-00',ci.idComprobanteItem,'-00',ci.idComprobante) as comprobante,c.fecha,c.fechaRegistro,c.observaciones,ci.saldo
			FROM comprobante_items ci
			INNER JOIN comprobante c on c.idComprobante=ci.idComprobante
			INNER JOIN tipos_documento_contable tdc on tdc.idTiposDocumento=c.idTipo
			INNER JOIN parametros_documentos pd on pd.idParametrosDocumentos=c.comprobante
			WHERE ci.cuenta= '$cuenta' and c.fecha >= '$desde' and c.fecha <= '$hasta' ";

	    $aComprobante=$this->ejecutarSql($sql); 

	    return $aComprobante; 

	}

}

?>