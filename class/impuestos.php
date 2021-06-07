<?php
require_once($CLASS."sql.php"); 

class Impuestos extends Sql{
	
	public function getFechaImpuestos($aDatos=array()){

		$condicion=""; 
		
		if($aDatos["idEmpresa"]!=""){
			$condicion.=" AND e.idEmpresa=".$aDatos["idEmpresa"]; 
		}
		if($aDatos["idUsuario"]!=""){
			$condicion.=" AND ue.idUsuario=".$aDatos["idUsuario"]; 
		}
		$sql="SELECT fcd.idFacturaCompraDeduccion, ri.descripcion, c.nombre as ciudad, d.nombre as departamento, 
			fc.fechaPago, e.razonSocial, MONTH(fc.fechaPago) as mes
			FROM factura_compra_deduccion as fcd 
			INNER JOIN factura_compra as fc ON(fc.idFacturaCompra=fcd.idFacturaCompra)
			INNER JOIN retencion as ri ON(ri.idRetencion=fcd.tipoDeduccion)
			INNER JOIN ciudad as c ON(c.idCiudad=ri.idCiudad)
			INNER JOIN departamento as d ON(d.idDepartamento=c.idDepartamento)
			INNER JOIN empresa as e ON(e.idEmpresa=fc.idEmpresa)
			LEFT JOIN usuario_empresa as ue ON(ue.idEmpresa=e.idEmpresa)
			WHERE 0=0 ".$condicion." GROUP BY e.idEmpresa, c.idCiudad, mes  ORDER BY mes";

	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}

	
}
?>