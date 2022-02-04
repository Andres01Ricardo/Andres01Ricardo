<?php

require_once($CLASS."sql.php"); 



class FacturaCompra extends Sql{

	

	public function getProveedoresEmpresa($aDatos=array()){



		$condicion=""; 

		if($aDatos["idEmpresa"]!=""){

			$condicion=" AND pe.idEmpresa=".$aDatos["idEmpresa"]; 

		}



		$sql="SELECT p.idTercero, p.razonSocial,p.nit FROM tercero_empresa as pe 

			  INNER JOIN tercero as p ON(p.idTercero=pe.idTercero)

			  WHERE 0=0 ".$condicion."  GROUP BY p.idTercero ORDER BY p.razonSocial ASC";



	    $aProductos=$this->ejecutarSql($sql); 

	    return $aProductos; 

	}



	public function getFacturasRecibidas($aDatos=array()){



		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }

		if(!empty($_SESSION["idEmpresa"])){

			$condicion.=" AND fc.idEmpresa=".$_SESSION["idEmpresa"]; 

		}
		if(empty($_SESSION["idEmpresa"])){
			if ($aDatos["ingresoPerfilEmpresa"]==0) {
				$condicion.=" AND ue.idUsuario=".$_SESSION["idUsuario"]; 
			}else{
				$condicion="";
			}
		}


		if($aDatos["idFacturaCompra"]!=""){

			$condicion.=" AND fc.idFacturaCompra=".$aDatos["idFacturaCompra"]; 

		}



		if($aDatos["fecha"]!=""){

			$condicion.=" AND fc.fechaRegistro LIKE '%".$aDatos["fecha"]."%'"; 

		}



		$sql="SELECT fc.idFacturaCompra, fc.idUsuarioRegistra, fc.idEmpresa, fc.tipoFactura, 

			  p.razonSocial, e.razonSocial as empresa, u.nombreUsuario, u.apellidoUsuario, 

			  fc.fechaRegistro, fc.fechaRecibido, fc.fechaPago, fc.nroFactura, fc.archivo, 

			  fc.total, fc.estado, fc.subtotal ,fc.saldo,fc.archivo2

			  FROM factura_compra as fc 

				INNER JOIN tercero as p ON(p.idTercero=fc.idProveedor)

				INNER JOIN empresa as e ON(e.idEmpresa=fc.idEmpresa)

				INNER JOIN usuario as u ON(u.idUsuario=fc.idUsuarioRegistra)

				-- LEFT JOIN usuario_empresa as ue ON(ue.idEmpresa=e.idEmpresa) 

				WHERE 0=0 ".$condicion." ORDER BY fc.fechaRecibido DESC";

		

	    $aFacturas=$this->ejecutarSql($sql); 

	    return $aFacturas; 

	}


	public function getCuentasPagar($empresa){



		$sql="SELECT * 
			from factura_compra
			WHERE (estado = '2' OR estado = '1' OR estado = '4') and idEmpresa = $empresa
			ORDER BY idProveedor ASC";
	    $aCuentasPagar=$this->ejecutarSql($sql); 
	    return $aCuentasPagar; 


	}

	public function getCuentasPagarProveedor($empresa,$proveedor,$desde,$hasta){



		$sql="SELECT * 
			from factura_compra
			WHERE (estado = '2' OR estado = '1' OR estado = '4') and fechaRecibido >= '$desde' and fechaRecibido <= '$hasta' and idEmpresa = $empresa and idProveedor = $proveedor";

	    $aCuentasPagarProveedor=$this->ejecutarSql($sql); 
	    return $aCuentasPagarProveedor; 


	}


	public function getSaldoProveedor($empresa,$proveedor,$desde,$hasta){

		$sql="SELECT total,sum(saldo) as totalGeneral
			from factura_compra
			WHERE (estado = '2' OR estado = '1' OR estado = '4') and fechaRecibido>='$desde' and fechaRecibido <= '$hasta' and idProveedor = $proveedor and idEmpresa = $empresa";

	    $aSaldoProveedor=$this->ejecutarSql($sql); 
	    return $aSaldoProveedor; 


	}

	public function getSaldosProveedores($empresa,$desde,$hasta){



		$sql="SELECT total,saldo,sum(saldo) as totalGeneral
			from factura_compra
			WHERE (estado = '2' OR estado = '1' OR estado = '4') and fechaRecibido >= '$desde' and fechaRecibido <= '$hasta' and idEmpresa = $empresa";

	    $aSaldosProveedor=$this->ejecutarSql($sql); 
	    return $aSaldosProveedor; 


	}


	public function getSaldosProveedoresSaldo($empresa,$desde,$hasta){



		$sql="SELECT total,saldo,sum(saldo) as totalGeneral
			from factura_compra
			WHERE (estado = '4') and fechaRecibido >= '$desde' and fechaRecibido <= '$hasta' and idEmpresa = $empresa";

	    $aSaldosProveedorSaldo=$this->ejecutarSql($sql); 
	    return $aSaldosProveedorSaldo; 


	}




	public function getCuentaTotal($idEmpresa,$tipoFactura){



		// $condicion=""; 

		// if($aDatos["idEmpresa"]!=""){

		// 	$condicion=" AND ccc.idEmpresa=".$aDatos["idEmpresa"]; 

		// }
		// if($aDatos["tipoFactura"]!=""){

		// 	$condicion=" AND ccc.tipoFactura='".$aDatos["tipoFactura"]."'"; 

		// }
	

		$sql="SELECT ccc.concepto,ccc.tipoFactura,cc.codigoCuenta,cc.nombre,ccc.idEmpresaCuenta,ccc.idEmpresa
		FROM compra_cuenta_contable as ccc
			  INNER JOIN cuenta_contable as cc ON(ccc.idEmpresaCuenta=cc.idCuentaContable)
			  WHERE 0=0 AND  ccc.idEmpresa=$idEmpresa AND ccc.tipoFactura='$tipoFactura'";

	    $aCuentaTotal=$this->ejecutarSql($sql); 

	    return $aCuentaTotal; 

	}



	public function getFacturaComprobante($idEmpresa){	

		$sql="SELECT *
		FROM factura_compra_comprobante fcc
		INNER JOIN factura_compra fc on fcc.idFacturaCompra=fc.idFacturaCompra
		WHERE fc.idEmpresa=$idEmpresa  AND (fcc.estado=3 or fcc.estado=4) ";

	    $aFacturaComprobante=$this->ejecutarSql($sql); 

	    return $aFacturaComprobante; 

	}

}

?>