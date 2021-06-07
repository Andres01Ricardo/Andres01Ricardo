<?php

require_once($CLASS."sql.php"); 



class Legalizaciones extends Sql{


	public function getLegalizacionesEmpleado($empleado){

		$sql="SELECT l.idLegalizacion,l.concepto,l.valor,l.tipoFactura,l.emiteFactura,l.fechaFactura,u.nombreUsuario,u.apellidoUsuario,l.estado,l.idUsuarioRegistra,l.tipoLegalizacion,l.archivo
			from legalizaciones l
            inner join usuario u on u.idUsuario=l.idUsuarioRegistra
            inner join empleado_usuario eu on eu.idUsuario=l.idUsuarioRegistra
			WHERE idUsuarioRegistra = $empleado 
			ORDER BY fechaFactura ASC";

	    $aLegalizacion=$this->ejecutarSql($sql); 
	    return $aLegalizacion; 


	}

	public function getProyectosLegalizaciones($empleado){

		$sql="SELECT l.idProyectoLegalizacion,l.contrato,l.motivo,l.persona,l.fechaLegalizacion,l.inicioViaje,l.finViaje,l.primerViaje,c.nombre as ciudadDesde, ci.nombre as ciudadHasta, d.nombre as departamentoDesde, de.nombre as departamentoHasta,e.nombre, e.apellido,l.idEmpresa
			from proyecto_legalizacion l
            inner join ciudad c on (l.ciudadDesde=c.idCiudad) 
			inner join ciudad ci on (l.ciudadHasta=ci.idCiudad)
			inner join departamento d on (l.departamentoDesde=d.idDepartamento) 
			inner join departamento de on (l.departamentoHasta=de.idDepartamento)
			inner join empleado e on (e.idEmpleado=l.persona)
			-- inner join usuario u on (u.idUsuario=l.persona)--
			WHERE idEmpleado = $empleado

			ORDER BY fechaLegalizacion ASC";

	    $aLegalizacion=$this->ejecutarSql($sql); 
	    return $aLegalizacion; 


	}

	public function getProyectoLegalizacion($proyecto){

		$sql="SELECT l.idProyectoLegalizacion,l.contrato,l.motivo,l.persona,l.fechaLegalizacion,l.inicioViaje,l.finViaje,l.primerViaje,c.nombre as ciudadDesde, ci.nombre as ciudadHasta, d.nombre as departamentoDesde, de.nombre as departamentoHasta,e.nombre, e.apellido
			from proyecto_legalizacion l
            inner join ciudad c on (l.ciudadDesde=c.idCiudad) 
			inner join ciudad ci on (l.ciudadHasta=ci.idCiudad)
			inner join departamento d on (l.departamentoDesde=d.idDepartamento) 
			inner join empleado e on (e.idEmpleado=l.persona)
			
			WHERE idProyectoLegalizacion = $proyecto

			ORDER BY fechaLegalizacion ASC";

	    $aLegalizacion=$this->ejecutarSql($sql); 
	    return $aLegalizacion; 


	}

	public function getSaldoLegalizacionesEmpleado($empleado){

		$sql="SELECT sum(valor) as total 
			from legalizaciones 
			-- WHERE estado=1 and idUsuarioRegistra=$empleado  --
			WHERE estado=1 and idEmpleado=$empleado  
			GROUP BY idUsuarioRegistra";

	    $aSaldoLegalizacion=$this->ejecutarSql($sql); 
	    return $aSaldoLegalizacion; 

	}


	public function getItemsLegalizaciones($idProyecto){

		$sql="SELECT l.idLegalizacion,l.concepto,l.valor,l.tipoFactura,l.emiteFactura,l.fechaFactura,e.nombre,e.apellido,l.estado,l.idUsuarioRegistra,l.tipoLegalizacion,l.archivo
			from legalizaciones l
            -- inner join usuario u on u.idUsuario=l.idUsuarioRegistra--
            -- inner join empleado_usuario eu on eu.idUsuario=l.idUsuarioRegistra--
            INNER JOIN proyecto_legalizacion pl on pl.idProyectoLegalizacion=l.idProyectoLegalizacion
            INNER JOIN empleado e on e.idEmpleado=pl.persona
			WHERE l.idProyectoLegalizacion = $idProyecto 
			ORDER BY fechaFactura ASC";

	    $aLegalizacion=$this->ejecutarSql($sql); 
	    return $aLegalizacion; 


	}

	public function getItemsLegalizacionesPDF($idProyecto){

		$sql="SELECT sum(l.valor) as valorItem,l.idLegalizacion,l.concepto,l.valor,l.tipoFactura,l.emiteFactura,l.fechaFactura,e.nombre,e.apellido,l.estado,l.idUsuarioRegistra,l.tipoLegalizacion
			from legalizaciones l
 
            INNER JOIN proyecto_legalizacion pl on pl.idProyectoLegalizacion=l.idProyectoLegalizacion
            INNER JOIN empleado e on e.idEmpleado=pl.persona
			WHERE l.idProyectoLegalizacion = $idProyecto
			GROUP BY l.tipoLegalizacion 
			ORDER BY fechaFactura ASC";

	    $aLegalizacion=$this->ejecutarSql($sql); 
	    return $aLegalizacion; 


	}
	
}

?>