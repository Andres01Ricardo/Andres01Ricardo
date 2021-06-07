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

	public function getEmpresaCalendario($aDatos=array()){

		$condicion=""; 
		
		if($aDatos["idEmpresa"]!=""){
			$condicion.=" AND fe.idEmpresa=".$aDatos["idEmpresa"]; 
		}
		if($aDatos["tipo"]!=""){
			$condicion.=" AND f.tipoImpuesto=".$aDatos["tipo"]; 
		}
		if($aDatos["anio"]!=""){
			$condicion.=" AND f.anio=".$aDatos["anio"]; 
		}
		if($aDatos["periodoDiferente"]!=""){
			$condicion.=" AND f.idPeriocidad<>".$aDatos["periodoDiferente"]; 
		}
		$sql="SELECT f.idFechaRetencionIva, fe.idFechaRetencionIvaEmpresa FROM fecha_retencion_iva as f 
				INNER JOIN fecha_retencion_iva_empresa as fe ON(fe.idFechaRetencionIva=f.idFechaRetencionIva)
				WHERE 0=0".$condicion;
		
	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}

	public function getCalendario($aDatos=array()){

		$condicion=""; 
		
		if($aDatos["idFechaRetencionIva"]!=""){
			$condicion.=" AND f.idFechaRetencionIva=".$aDatos["idFechaRetencionIva"]; 
		}
		if($aDatos["anio"]!=""){
			$condicion.=" AND f.anio=".$aDatos["anio"]; 
		}
		if($aDatos["digito"]!=""){
			$condicion.=" AND fi.digito=".$aDatos["digito"]; 
		}
		if($aDatos["idEmpresa"]!=""){
			$condicion.=" AND fe.idEmpresa=".$aDatos["idEmpresa"]; 
		}
		$sql="SELECT fi.fechaLimite, fi.digito, if(f.tipoImpuesto=1,'RETENCIÓN','IVA') as tipo, GROUP_CONCAT(DISTINCT fp.mes) as mes FROM fecha_retencion_iva as f 
			INNER JOIN fecha_retencion_iva_item as fi ON(fi.idFechaRetencionIva=f.idFechaRetencionIva)
			INNER JOIN fecha_retencion_iva_periodo as fp ON(fp.idFechaRetencionIvaItem=fi.idFechaRetencionIvaItem)
			LEFT JOIN fecha_retencion_iva_empresa as fe ON(fe.idFechaRetencionIva=f.idFechaRetencionIva)
			WHERE 0=0 ".$condicion." GROUP BY fp.idFechaRetencionIvaItem ORDER BY digito, fp.mes ASC";
		
	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}

}
?>