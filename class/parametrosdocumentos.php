<?php

require_once($CLASS."sql.php"); 



class ParametrosDocumentos extends Sql{

	

	public function getParametrosDocumentos($idEmpresa){



		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }

				

		$sql="SELECT p.idParametrosDocumentos,p.comprobante,tdc.letra,tdc.descripcion,p.descripcion as descripcionParametro,p.numeracionInicial,e.razonSocial,p.numeracionActual

			FROM parametros_documentos as p

			INNER JOIN tipos_documento_contable as tdc ON(tdc.idTiposDocumento=p.tipo)

			INNER JOIN empresa as e ON(e.idEmpresa=p.idEmpresa)

			WHERE 0=0 AND p.idEmpresa=$idEmpresa";

		

	    $aParametro=$this->ejecutarSql($sql); 

	    return $aParametro; 

	}



	

}

?>