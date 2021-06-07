<?php
require_once($CLASS."sql.php"); 

class FacturaVenta extends Sql{
	
	public function getFacturasVenta($aDatos=array()){

		$condicion=""; 
		if(!isset($_SESSION)){ session_start(); }
		if($_SESSION["idRol"]==2){
			$condicion.=" AND ue.idUsuario=".$_SESSION["idUsuario"]; 
		}
		if($_SESSION["idEmpresa"]!=""){
			$condicion.=" AND e.idEmpresa=".$_SESSION["idEmpresa"]; 
		}
		if($aDatos["idFacturaVenta"]!=""){
			$condicion.=" AND fv.idFacturaVenta=".$aDatos["idFacturaVenta"]; 
		}
		if($aDatos["fecha"]!=""){
			$condicion.=" AND fv.fechaRegistro LIKE '%".$aDatos["fecha"]."%'"; 
		}
		$sql="SELECT fv.idFacturaVenta, fv.fechaRegistro, fv.fechaFactura, c.razonSocial, u.nombreUsuario, u.apellidoUsuario, fv.subtotal,
			fv.total, fv.estado, e.razonSocial as empresa, fv.nroFactura, fv.archivo
			FROM factura_venta as fv 
			INNER JOIN cliente as c ON(c.idCliente=fv.idCliente)
			INNER JOIN usuario as u ON(u.idUsuario=fv.idUsuarioRegistra)
			INNER JOIN empresa as e ON(e.idEmpresa=fv.idEmpresa)
			LEFT JOIN usuario_empresa as ue ON(ue.idEmpresa=e.idEmpresa)
			WHERE 0=0 ".$condicion." ORDER BY fv.fechaRegistro DESC";
		
	    $aFacturas=$this->ejecutarSql($sql); 
	    return $aFacturas; 
	}
}
?>