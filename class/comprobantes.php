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



	public function getComprobanteItems($idComprobante){


		if(!isset($_SESSION)){ session_start(); }

		$sql="SELECT ci.idCuentaContable,c.nombre as cuentaContable,c.codigoCuenta,cc.idCentroCosto,cc.codigoCentroCosto,cc.centroCosto,scc.idSubcentroCosto,scc.codigoSubcentroCosto,scc.subcentroCosto,t.idTercero,t.nit,t.razonSocial,ci.descripcion,ci.naturaleza,ci.saldoDebito,ci.saldoCredito,ci.base
			FROM comprobante_items ci
			INNER JOIN tercero t on t.idTercero = ci.idTercero
			LEFT JOIN centro_costo cc on cc.idCentroCosto = ci.idCentroCosto
			LEFT JOIN subcentro_costo scc on scc.idSubcentroCosto = ci.idSubcentroCosto
			INNER JOIN cuenta_contable c on c.idCuentaContable = ci.idCuentaContable
			WHERE ci.idComprobante=$idComprobante";

	    $aComprobante=$this->ejecutarSql($sql); 

	    return $aComprobante; 

	}



	public function getComprobante($idComprobante){


		if(!isset($_SESSION)){ session_start(); }

		$sql="SELECT ci.idCuentaContable,c.nombre as cuentaContable,c.codigoCuenta,cc.idCentroCosto,cc.codigoCentroCosto,cc.centroCosto,scc.idSubcentroCosto,scc.codigoSubcentroCosto,scc.subcentroCosto,t.idTercero,t.nit,t.razonSocial,ci.descripcion,ci.naturaleza,ci.saldoDebito,ci.saldoCredito,ci.base
			FROM comprobante_items ci
			INNER JOIN tercero t on t.idTercero = ci.idTercero
			LEFT JOIN centro_costo cc on cc.idCentroCosto = ci.idCentroCosto
			LEFT JOIN subcentro_costo scc on scc.idSubcentroCosto = ci.idSubcentroCosto
			INNER JOIN cuenta_contable c on c.idCuentaContable = ci.idCuentaContable
			WHERE ci.idComprobante=$idComprobante";

	    $aComprobante=$this->ejecutarSql($sql); 

	    return $aComprobante; 

	}



	public function getFacturaCompra($empresa){

		

		if(!isset($_SESSION)){ session_start(); }

		$sql="SELECT  fc.idFacturaCompra,fc.idUsuarioRegistra,fc.fechaRegistro,fc.idEmpresa, fc.fechaRecibido,fc.fechaPago,fc.idProveedor,fc.nroFactura,fc.archivo,fc.saldo,t.razonSocial
			FROM factura_compra fc
			INNER JOIN tercero t on fc.idProveedor = t.idTercero
			WHERE (fc.estado=1 or fc.estado=2 or fc.estado=4) AND fc.idEmpresa=$empresa";

	    $aFacturaCompra=$this->ejecutarSql($sql); 
	    return $aFacturaCompra; 

	}


	public function getFacturaVenta($empresa){

		

		if(!isset($_SESSION)){ session_start(); }

		$sql="SELECT  fc.idFacturaVenta,fc.idUsuarioRegistra,fc.fechaRegistro,fc.idEmpresa, fc.fechaFactura,fc.idCliente,fc.nroFactura,fc.archivo,fc.saldo,t.razonSocial
			FROM factura_venta fc
			INNER JOIN tercero t on fc.idCliente = t.idTercero
			WHERE (fc.estado=1 or fc.estado=2 or fc.estado=4) AND fc.idEmpresa=$empresa";

	    $aFacturaVenta=$this->ejecutarSql($sql); 
	    return $aFacturaVenta; 

	}







	public function getFacturaCompraTercero($empresa,$idTercero){

		

		if(!isset($_SESSION)){ session_start(); }

		$sql="SELECT  fc.idFacturaCompra,fc.idUsuarioRegistra,fc.fechaRegistro,fc.idEmpresa, fc.fechaRecibido,fc.fechaPago,fc.idProveedor,fc.nroFactura,fc.archivo,fc.saldo,t.razonSocial
			FROM factura_compra fc
			INNER JOIN tercero t on fc.idProveedor = t.idTercero
			WHERE (fc.estado=1 or fc.estado=2 or fc.estado=4) AND fc.idEmpresa=$empresa AND fc.idProveedor=$idTercero";

	    $aFacturaCompra=$this->ejecutarSql($sql); 
	    return $aFacturaCompra; 

	}


	public function getFacturaVentaTercero($empresa,$idTercero){

		

		if(!isset($_SESSION)){ session_start(); }

		$sql="SELECT  fc.idFacturaVenta,fc.idUsuarioRegistra,fc.fechaRegistro,fc.idEmpresa, fc.fechaFactura,fc.idCliente,fc.nroFactura,fc.archivo,fc.saldo,t.razonSocial
			FROM factura_venta fc
			INNER JOIN tercero t on fc.idCliente = t.idTercero
			WHERE (fc.estado=1 or fc.estado=2 or fc.estado=4) AND fc.idEmpresa=$empresa AND fc.idCliente=$idTercero";

	    $aFacturaVenta=$this->ejecutarSql($sql); 
	    return $aFacturaVenta; 

	}

}

?>