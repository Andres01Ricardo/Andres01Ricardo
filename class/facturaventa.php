<?php

require_once($CLASS."sql.php"); 



class FacturaVenta extends Sql{

	

	public function getFacturasVenta($aDatos=array()){



		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }

		if(empty($_SESSION["idEmpresa"])){
			if ($aDatos["ingresoPerfilEmpresa"]==0) {
				$condicion.=" AND ue.idUsuario=".$_SESSION["idUsuario"]; 
			}else{
				$condicion="";
			}
		}

		if(!empty($_SESSION["idEmpresa"])){

			$condicion.=" AND e.idEmpresa=".$_SESSION["idEmpresa"]; 

		}

		if($aDatos["idFacturaVenta"]!=""){

			$condicion.=" AND fv.idFacturaVenta=".$aDatos["idFacturaVenta"]; 

		}

		if($aDatos["fecha"]!=""){

			$condicion.=" AND fv.fechaRegistro LIKE '%".$aDatos["fecha"]."%'"; 

		}

		$sql="SELECT fv.idFacturaVenta, fv.fechaRegistro, fv.fechaFactura,fv.fechaVencimiento, c.razonSocial, u.nombreUsuario, u.apellidoUsuario, fv.subtotal,

			fv.total, fv.estado, e.razonSocial as empresa, fv.nroFactura, fv.archivo, fv.archivo2,fv.saldo,e.idEmpresa

			FROM factura_venta as fv 

			INNER JOIN tercero as c ON(c.idTercero=fv.idCliente)

			INNER JOIN usuario as u ON(u.idUsuario=fv.idUsuarioRegistra)

			INNER JOIN empresa as e ON(e.idEmpresa=fv.idEmpresa)

			WHERE 0=0 ".$condicion." ORDER BY fv.fechaRegistro DESC";

		

	    $aFacturas=$this->ejecutarSql($sql); 

	    return $aFacturas; 

	}


	public function getSaldoCliente($empresa,$cliente,$desde,$hasta){

		$sql="SELECT total,sum(saldo) as totalGeneral
			from factura_venta
			WHERE (estado = '2' OR estado = '1' OR estado = '4') and fechaFactura>='$desde' and fechaFactura <= '$hasta' and idCliente = $cliente and idEmpresa = $empresa";

	    $aSaldoCliente=$this->ejecutarSql($sql); 
	    return $aSaldoCliente; 


	}

	public function getSaldosClientes($empresa,$desde,$hasta){



		$sql="SELECT total,sum(saldo) as totalGeneral
			from factura_venta
			WHERE (estado = '2' OR estado = '1' OR estado = '4') and fechaFactura >= '$desde' and fechaFactura <= '$hasta' and idEmpresa = $empresa";

	    $aSaldosCliente=$this->ejecutarSql($sql); 
	    return $aSaldosCliente; 


	}

	public function getCuentasCobrar($empresa){



		$sql="SELECT * 
			from factura_venta
			WHERE (estado = '2' OR estado = '1' OR estado = '4') and idEmpresa = $empresa
			ORDER BY idCliente ASC";

	    $aCuentasCobrar=$this->ejecutarSql($sql); 
	    return $aCuentasCobrar; 


	}

	public function getCuentasCobrarCliente($empresa,$cliente,$desde,$hasta){



		$sql="SELECT * 
			from factura_venta
			WHERE estado != '3' and estado!=5 and fechaFactura >= '$desde' and fechaFactura <= '$hasta' and idEmpresa = $empresa and idCliente = $cliente";

	    $aCuentasCobrarCliente=$this->ejecutarSql($sql); 
	    return $aCuentasCobrarCliente; 


	}


	public function getSaldoClientesEmpresa($empresa){



		$sql="SELECT * 
			from factura_venta
			WHERE idEmpresa = $empresa AND (estado=1 or estado=2 or estado=4)  ";

	    $aCuentasCobrarCliente=$this->ejecutarSql($sql); 
	    return $aCuentasCobrarCliente; 


	}

	public function getCuentaTotal($idEmpresa,$tipoFactura){



	

		$sql="SELECT ccc.concepto,ccc.tipoFactura,cc.codigoCuenta,cc.nombre,ccc.idEmpresaCuenta,ccc.idEmpresa
		FROM compra_cuenta_contable as ccc
			  INNER JOIN cuenta_contable as cc ON(ccc.idEmpresaCuenta=cc.idCuentaContable)
			  WHERE 0=0 AND  ccc.idEmpresa=$idEmpresa AND ccc.tipoFactura='$tipoFactura'";

	    $aCuentaTotal=$this->ejecutarSql($sql); 

	    return $aCuentaTotal; 

	}

	public function getFacturaComprobante($idEmpresa){	

		$sql="SELECT *
		FROM factura_venta_comprobante fcc
		INNER JOIN factura_venta fc on fcc.idFacturaVenta=fc.idFacturaVenta
		WHERE fc.idEmpresa=$idEmpresa  AND (fcc.estado=3 or fcc.estado=4) ";

	    $aFacturaComprobante=$this->ejecutarSql($sql); 

	    return $aFacturaComprobante; 

	}

	public function getFacturaPendiente($fecha){	

		$sql="SELECT *
		FROM factura_venta fv
		WHERE fv.fechaVencimiento='$fecha' AND (fv.estado=1 or fv.estado=2 or fv.estado=4) AND fv.idEmpresa=1";
	    $aFactura=$this->ejecutarSql($sql); 

	    return $aFactura; 

	}


	public function getFacturaPendienteDiasMenosTreinta(){	

		$sql="SELECT *
		FROM factura_venta fv
		WHERE datediff(curdate(),fv.fechaVencimiento)<'30'   AND (fv.estado=1 or fv.estado=2 or fv.estado=4) AND fv.idEmpresa=1 ";
		
	    $aFactura=$this->ejecutarSql($sql); 

	    return $aFactura; 

	}

	public function getFacturaPendienteDias($dias){	

		$sql="SELECT *
		FROM factura_venta fv
		WHERE datediff(curdate(),fv.fechaVencimiento)='$dias' AND (fv.estado=1 or fv.estado=2 or fv.estado=4) AND fv.idEmpresa=1 ";
		
	    $aFactura=$this->ejecutarSql($sql); 

	    return $aFactura; 

	}


	public function getFacturaPendienteDiasTreinta(){	

		$sql="SELECT *
		FROM factura_venta fv
		WHERE datediff(curdate(),fv.fechaVencimiento)>'30' AND datediff(curdate(),fv.fechaVencimiento)<'60' AND (fv.estado=1 or fv.estado=2 or fv.estado=4) AND fv.idEmpresa=1 ";
		
	    $aFactura=$this->ejecutarSql($sql); 

	    return $aFactura; 

	}



}

?>