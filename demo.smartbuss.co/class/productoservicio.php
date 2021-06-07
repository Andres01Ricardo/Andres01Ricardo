<?php
require_once($CLASS."sql.php"); 

class ProductoServicio extends Sql{
	
	public function getProductosServicios($aDatos=array()){

		$condicion=""; 
		if($aDatos["idEmpresa"]!=""){
			$condicion.=" AND p.idEmpresa=".$aDatos["idEmpresa"]; 
		}

		if($aDatos["tipo"]!=""){
			$condicion.=" AND p.tipo=".$aDatos["tipo"]; 
		}

		$sql="SELECT p.idProductoServicio, p.nombre, p.codigo, b.nombre as bienes, c.nombre as clase, f.nombre as familia, s.nombre as segmento, g.nombre as grupo, e.razonSocial
		    FROM producto_servicio as p 
		    INNER JOIN bienes as b ON(b.idBienes=p.idBienes)
		    INNER JOIN clase as c ON(c.idClase=b.idClase)
		    INNER JOIN familia as f ON(f.idFamilia=c.idFamilia)
		    INNER JOIN segmento as s on(s.idSegmento=f.idSegmento)
		    INNER JOIN grupo as g ON(s.idGrupo=g.idGrupo)
		    INNER JOIN empresa as e ON(e.idEmpresa=p.idEmpresa)
		    WHERE 0=0 ".$condicion." ORDER BY p.nombre ASC";
	    $aProductos=$this->ejecutarSql($sql); 

	    return $aProductos; 
	}

}
?>