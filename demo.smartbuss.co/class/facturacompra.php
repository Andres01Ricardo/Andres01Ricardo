<?php
require_once($CLASS."sql.php"); 

class FacturaCompra extends Sql{
	
	public function getProveedoresEmpresa($aDatos=array()){

		$condicion=""; 
		if($aDatos["idEmpresa"]!=""){
			$condicion=" AND pe.idEmpresa=".$aDatos["idEmpresa"]; 
		}

		$sql="SELECT p.idProveedor, p.razonSocial FROM proveedor_empresa as pe 
			  INNER JOIN proveedor as p ON(p.idProveedor=pe.idProveedor)
			  WHERE 0=0 ".$condicion." GROUP BY p.idProveedor ORDER BY p.razonSocial ASC";

	    $aProductos=$this->ejecutarSql($sql); 
	    return $aProductos; 
	}

	public function getFacturasRecibidas($aDatos=array()){

		$condicion=""; 
		if(!isset($_SESSION)){ session_start(); }
		if($_SESSION["idRol"]!=1){
			$condicion.=" AND ue.idUsuario=".$_SESSION["idUsuario"]; 
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
			  fc.total, fc.estado, fc.subtotal 
			  FROM factura_compra as fc 
				INNER JOIN proveedor as p ON(p.idProveedor=fc.idProveedor)
				INNER JOIN empresa as e ON(e.idEmpresa=fc.idEmpresa)
				INNER JOIN usuario as u ON(u.idUsuario=fc.idUsuarioRegistra)
				LEFT JOIN usuario_empresa as ue ON(ue.idEmpresa=e.idEmpresa) 
				WHERE 0=0 ".$condicion." ORDER BY fc.fechaRegistro DESC";
		
	    $aFacturas=$this->ejecutarSql($sql); 
	    return $aFacturas; 
	}
}
?>