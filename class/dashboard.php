<?php

require_once($CLASS."sql.php"); 



class Dashboard extends Sql{

	

	public function getSaldoProveedores($idEmpresa){



		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }

				

		$sql="SELECT  sum(saldo) as total
			FROM factura_compra 
			WHERE idEmpresa=$idEmpresa and (estado=1 or estado=2 or estado=4)";

		

	    $dProveedores=$this->ejecutarSql($sql); 

	    return $dProveedores; 

	}
	public function getSaldoProveedoresAbono($idEmpresa){



		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }

				

		$sql="SELECT  idProveedor,sum(saldo) as total
			FROM factura_compra 
			WHERE idEmpresa=$idEmpresa and (estado=4)";

		

	    $dProveedoresAbono=$this->ejecutarSql($sql); 

	    return $dProveedoresAbono; 

	}

	public function getSaldoClientes($idEmpresa){


		if(!isset($_SESSION)){ session_start(); }

				

		$sql="SELECT  sum(saldo) as totalVentas 
		FROM factura_venta 
		WHERE idEmpresa=$idEmpresa AND (estado=1 or estado=2 or estado=4)	";

		

	    $dClientes=$this->ejecutarSql($sql); 

	    return $dClientes; 

	}


	public function getRetencion($idEmpresa){


		if(!isset($_SESSION)){ session_start(); }

				

		$sql="SELECT  sum(fvd.valor) as retencion 
		FROM factura_compra_deduccion fvd
		INNER JOIN factura_compra fv on fvd.idFacturaCompra=fv.idFacturaCompra
		WHERE fvd.tipoDeduccion=1 AND fv.idEmpresa=$idEmpresa AND fv.estado!='5'";

		

	    $dRetencion=$this->ejecutarSql($sql); 

	    return $dRetencion; 

	}


	public function getAutoRetencion($idEmpresa){


		if(!isset($_SESSION)){ session_start(); }

				

		$sql="SELECT  sum(fvd.valor) as retencion 
		FROM factura_venta_deduccion fvd
		INNER JOIN factura_venta fv on fvd.idFacturaVenta=fv.idFacturaVenta
		WHERE fvd.idConcepto=33 AND fv.idEmpresa=$idEmpresa AND fv.estado!='5'";

	    $dRetencion=$this->ejecutarSql($sql); 

	    return $dRetencion; 

	}


	public function getIVA($idEmpresa){
		$dia=date('Y-m').'-01';

		if(!isset($_SESSION)){ session_start(); }

				

		$sql="SELECT  sum(iva) as iva 
		FROM factura_venta
		WHERE idEmpresa=$idEmpresa AND estado!='5' ";
		// WHERE idEmpresa=$idEmpresa AND estado!='5' AND fechaFactura<'$dia'";


	    $dIVA=$this->ejecutarSql($sql); 

	    return $dIVA; 

	}
	public function getIVAC($idEmpresa){

		$dia=date('Y-m').'-01';
		if(!isset($_SESSION)){ session_start(); }

				

		$sql="SELECT  sum(iva) as iva 
		FROM factura_compra
		WHERE idEmpresa=$idEmpresa AND estado!='5'";


	    $dIVAC=$this->ejecutarSql($sql); 

	    return $dIVAC; 

	}
	public function getReteIVA($idEmpresa){
		$dia=date('Y-m').'-01';

		if(!isset($_SESSION)){ session_start(); }



		$sql="SELECT  sum(fvd.valor) as reteiva 
		FROM factura_venta fv
		INNER JOIN factura_venta_deduccion as fvd on fv.idFacturaVenta=fvd.idFacturaVenta
		WHERE fv.idEmpresa=$idEmpresa AND fvd.concepto like '%reteiva%' AND fv.estado!='5' AND fechaFactura<'$dia'";


	    $dReteIVA=$this->ejecutarSql($sql); 

	    return $dReteIVA; 

	}
	public function getICA($idEmpresa){


		if(!isset($_SESSION)){ session_start(); }

				

		$sql="SELECT  sum(valor) as ica 
		FROM factura_compra_deduccion fvd
		INNER JOIN factura_compra fv on fvd.idFacturaCompra=fv.idFacturaCompra
		WHERE fvd.tipoDeduccion=2 AND fv.idEmpresa=$idEmpresa";



	    $dICA=$this->ejecutarSql($sql); 

	    return $dICA; 

	}
	

public function getGastosOperacionalesVentas(){


		if(!isset($_SESSION)){ session_start(); }

		$idEmpresa=$_SESSION["idEmpresa"];

		$sql="SELECT efi.valor,ef.periodoAnio,ef.periodoMes
		from estado_financiero ef 
		inner join estado_financiero_item efi on efi.idEstadoFinanciero=ef.idEstadoFinanciero 
		
		WHERE ef.idEmpresa=$idEmpresa and efi.cuenta='Gastos operacionales de Ventas'
		ORDER BY ef.periodoAnio ASC,ef.periodoMes ASC";
																



	    $dGastosOperacionales=$this->ejecutarSql($sql); 

	    return $dGastosOperacionales; 

	}
	public function getGastosOperacionales(){


		if(!isset($_SESSION)){ session_start(); }

		$idEmpresa=$_SESSION["idEmpresa"];

		$sql="SELECT efi.valor,ef.periodoAnio,ef.periodoMes
		from estado_financiero ef 
		inner join estado_financiero_item efi on efi.idEstadoFinanciero=ef.idEstadoFinanciero 
		
		WHERE ef.idEmpresa=$idEmpresa and efi.cuenta='Gastos operacionales de Administracion'
		ORDER BY ef.periodoAnio ASC,ef.periodoMes ASC";
																



	    $dGastosOperacionales=$this->ejecutarSql($sql); 

	    return $dGastosOperacionales; 

	}
	public function getFacturaCompraSumada(){


		if(!isset($_SESSION)){ session_start(); }

		$idEmpresa=$_SESSION["idEmpresa"];

		$sql="SELECT efi.valor,ef.periodoAnio,ef.periodoMes
		from estado_financiero ef 
		inner join estado_financiero_item efi on efi.idEstadoFinanciero=ef.idEstadoFinanciero 
		
		WHERE ef.idEmpresa=$idEmpresa and efi.cuenta='Costos de Ventas'
		ORDER BY ef.periodoAnio ASC,ef.periodoMes ASC
";



	    $dFacturaCompraSumada=$this->ejecutarSql($sql); 

	    return $dFacturaCompraSumada; 

	}

	public function getFacturaVentaSumada(){


		if(!isset($_SESSION)){ session_start(); }

		$idEmpresa=$_SESSION["idEmpresa"];

		$sql="SELECT efi.valor,ef.periodoAnio,ef.periodoMes
		from estado_financiero ef 
		inner join estado_financiero_item efi on efi.idEstadoFinanciero=ef.idEstadoFinanciero 
		
		WHERE ef.idEmpresa=$idEmpresa and efi.cuenta='Ingresos Operacionales'
		ORDER BY ef.periodoAnio ASC,ef.periodoMes ASC
		";
		

	    $dFacturaVentaSumada=$this->ejecutarSql($sql); 

	    return $dFacturaVentaSumada; 

	}

	public function getSeguridadSocial(){


		if(!isset($_SESSION)){ session_start(); }

		$idEmpresa=$_SESSION["idEmpresa"];

		$sql="SELECT sum(nep.valor) as totalSeguridadSocial from nomina_empleado_parafiscales nep 
			INNER JOIN nomina_empleado ne on ne.idNominaEmpleado=nep.idNominaEmpleado
			INNER JOIN nomina n on ne.idNomina=n.idNomina
			WHERE n.idEmpresa=$idEmpresa
			
			ORDER BY n.periodoAnio DESC,n.periodoMes DESC ";
		


	    $dSeguridadSocial=$this->ejecutarSql($sql); 

	    return $dSeguridadSocial; 

	}
	public function getSeguridadSocialPagar($idEmpresa){


		

		$sql="SELECT sum(nep.valor) as totalSeguridadSocial from nomina_empleado_parafiscales nep 
			INNER JOIN nomina_empleado ne on ne.idNominaEmpleado=nep.idNominaEmpleado
			INNER JOIN nomina n on ne.idNomina=n.idNomina
			WHERE n.idEmpresa=$idEmpresa
			
			ORDER BY n.periodoAnio DESC,n.periodoMes DESC ";
		


	    $dSeguridadSocial=$this->ejecutarSql($sql); 

	    return $dSeguridadSocial; 

	}

}

?>