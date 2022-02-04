<?php

require_once($CLASS."sql.php"); 



class Inventario extends Sql{

	public function getInventario($aDatos=array()){



		$condicion=""; 

		

		if($aDatos["idEmpresa"]!=""){

			$condicion.=" AND i.idEmpresa=".$aDatos["idEmpresa"]; 

		}
		if($aDatos["idProducto"]!=""){

			$condicion.=" AND i.idProducto=".$aDatos["idProducto"]; 

		}

		if($aDatos["idProductoInventario"]!=""){

			$condicion.=" AND i.idProductoInventario=".$aDatos["idProductoInventario"]; 

		}


		$sql="SELECT  i.idProducto,i.producto,u.nombre as unidad,i.cantidad,i.valorUnitario,i.unidad as idUnidad, i.idProductoInventario, i.cantidadMinima,i.tipoInventario

			FROM inventario as i 

			INNER JOIN unidad as u ON(i.unidad=u.idUnidad)

			

			WHERE 0=0 ".$condicion." ";



	    $aArray=$this->ejecutarSql($sql); 

	    return $aArray; 

	}

	public function getInventarioInsumos($aDatos=array()){



		$condicion=""; 

		

		if($aDatos["idEmpresa"]!=""){

			$condicion.=" AND i.idEmpresa=".$aDatos["idEmpresa"]; 

		}
		if($aDatos["idProducto"]!=""){

			$condicion.=" AND i.idProducto=".$aDatos["idProducto"]; 

		}

		if($aDatos["idProductoInventario"]!=""){

			$condicion.=" AND i.idProductoInventario=".$aDatos["idProductoInventario"]; 

		}


		$sql="SELECT  i.idProducto,i.producto,u.nombre as unidad,i.cantidad,i.valorUnitario,i.unidad as idUnidad, i.idProductoInventario, i.cantidadMinima

			FROM inventario as i 

			INNER JOIN unidad as u ON(i.unidad=u.idUnidad)

			

			WHERE 0=0 ".$condicion." AND i.tipoInventario=1";



	    $aArray=$this->ejecutarSql($sql); 

	    return $aArray; 

	}


	public function getInventarioProductos($aDatos=array()){



		$condicion=""; 

		

		if($aDatos["idEmpresa"]!=""){

			$condicion.=" AND i.idEmpresa=".$aDatos["idEmpresa"]; 

		}
		if($aDatos["idProducto"]!=""){

			$condicion.=" AND i.idProducto=".$aDatos["idProducto"]; 

		}


		$sql="SELECT  i.idProducto,i.producto,u.nombre as unidad,i.cantidad,i.valorUnitario,i.unidad as idUnidad

			FROM inventario as i 

			INNER JOIN unidad as u ON(i.unidad=u.idUnidad)

			

			WHERE 0=0 ".$condicion." AND i.tipoInventario=2";



	    $aArray=$this->ejecutarSql($sql); 

	    return $aArray; 

	}
	

	public function getInventarioProductosProceso($aDatos=array()){



		$condicion=""; 

		

		if($aDatos["idEmpresa"]!=""){

			$condicion.=" AND i.idEmpresa=".$aDatos["idEmpresa"]; 

		}
		if($aDatos["idProducto"]!=""){

			$condicion.=" AND i.idProducto=".$aDatos["idProducto"]; 

		}


		$sql="SELECT  i.idProducto,i.producto,u.nombre as unidad,i.cantidad,i.valorUnitario,i.unidad as idUnidad,i.fechaRegistro

			FROM producto_proceso as i 

			INNER JOIN unidad as u ON(i.unidad=u.idUnidad)

			

			WHERE 0=0 ".$condicion." ";



	    $aArray=$this->ejecutarSql($sql); 

	    return $aArray; 

	}



	public function getHistorialInventario($aDatos=array()){



		$condicion=""; 

		if($aDatos["idEmpresa"]!=""){

			$condicion.=" AND h.idEmpresa=".$aDatos["idEmpresa"]; 

		}
		if($aDatos["insumo"]!=""){

			$condicion.=" AND h.idProducto=".$aDatos["insumo"]; 

		}

		$sql="SELECT h.tipoMovimiento,h.tipoInventario,h.fechaRegistro,h.cantidadAnterior,h.cantidadActual,u.nombreUsuario,u.apellidoUsuario,p.producto,h.motivo
			from inventario_movimientos h 
			inner join usuario u on u.idUsuario=h.idUsuarioRegistra
			inner join inventario p on h.idProducto = p.idProducto
			WHERE 0=0 ".$condicion." 
			ORDER BY h.idInventario_movimientos DESC";



	    $aArray=$this->ejecutarSql($sql); 

	    return $aArray; 

	}




	public function getHistorialInventarioProceso($aDatos=array()){



		$condicion=""; 

		if($aDatos["idEmpresa"]!=""){

			$condicion.=" AND h.idEmpresa=".$aDatos["idEmpresa"]; 

		}

		$sql="SELECT h.tipoMovimiento,h.tipoInventario,h.fechaRegistro,h.cantidadAnterior,h.cantidadActual,u.nombreUsuario,u.apellidoUsuario,p.producto,h.motivo
			from producto_proceso_movimientos h 
			inner join usuario u on u.idUsuario=h.idUsuarioRegistra
			inner join inventario p on h.idProducto = p.idProducto
			WHERE 0=0 ".$condicion." 
			ORDER BY h.idInventario_movimientos DESC";



	    $aArray=$this->ejecutarSql($sql); 

	    return $aArray; 

	}

	public function getInventarioProductosTerminados($aDatos=array()){



		$condicion=""; 

		if($aDatos["idEmpresa"]!=""){
			$condicion.=" AND ipm.idEmpresa=".$aDatos["idEmpresa"]; 
		}
		if($aDatos["idProducto"]!=""){
			$condicion.=" AND ipm.idProducto=".$aDatos["idProducto"]; 
		}

		if($aDatos["idBodega"]!=""){
			$condicion.=" AND ipm.idBodega=".$aDatos["idBodega"]; 
		}

		$sql="SELECT ipm.tipoMovimiento,sum(ipm.ingreso) as ingreso,sum(ipm.egreso) as egreso,ipm.fechaRegistro,u.nombreUsuario,u.apellidoUsuario,ps.nombre,ps.idProductoServicio,ipm.observaciones,ipm.idBodega
			from inventario_productos_movimientos ipm
			inner join producto_servicio ps on ps.idProductoServicio=ipm.idProducto
			INNER JOIN usuario u on u.idUsuario=ipm.idUsuarioRegistra
			WHERE 0=0 ".$condicion." 
			GROUP BY ipm.idProducto , ipm.idBodega";



	    $aArray=$this->ejecutarSql($sql); 

	    return $aArray; 

	}


	public function getInventarioProductosContable($aDatos=array()){



		$condicion=""; 

		if($aDatos["idEmpresa"]!=""){
			$condicion.=" AND ipm.idEmpresa=".$aDatos["idEmpresa"]; 
		}
		if($aDatos["idProducto"]!=""){
			$condicion.=" AND ipm.idProducto=".$aDatos["idProducto"]; 
		}

		if($aDatos["idBodega"]!=""){
			$condicion.=" AND ipm.idBodega=".$aDatos["idBodega"]; 
		}

		$sql="SELECT ipm.tipoMovimiento,sum(ipm.ingreso) as ingreso,sum(ipm.egreso) as egreso,ipm.fechaRegistro,u.nombreUsuario,u.apellidoUsuario,ps.nombre,ps.idProductoContable,ipm.observaciones,ipm.idBodega
			from inventario_productos_movimientos ipm
			inner join producto_contable ps on ps.idProductoContable=ipm.idProducto
			INNER JOIN usuario u on u.idUsuario=ipm.idUsuarioRegistra
			WHERE 0=0 ".$condicion." 
			GROUP BY ipm.idProducto , ipm.idBodega";



	    $aArray=$this->ejecutarSql($sql); 

	    return $aArray; 

	}




	public function getHistorialInventarioTerminado($aDatos=array()){



		$condicion=""; 

		if($aDatos["idEmpresa"]!=""){
			$condicion.=" AND ipm.idEmpresa=".$aDatos["idEmpresa"]; 
		}
		if($aDatos["idProducto"]!=""){
			$condicion.=" AND ipm.idProducto=".$aDatos["idProducto"]; 
		}

		$sql="SELECT ipm.tipoMovimiento,ipm.ingreso,ipm.egreso,ipm.fechaRegistro,u.nombreUsuario,u.apellidoUsuario,ps.codigo,ps.nombre,ps.idProductoServicio,ipm.observaciones
			from inventario_productos_movimientos ipm
			inner join producto_servicio ps on ps.idProductoServicio=ipm.idProducto
			INNER JOIN usuario u on u.idUsuario=ipm.idUsuarioRegistra
			WHERE 0=0 ".$condicion." 
			
			ORDER BY ipm.fechaRegistro DESC";
			



	    $aArray=$this->ejecutarSql($sql); 

	    return $aArray; 

	}




}

?>