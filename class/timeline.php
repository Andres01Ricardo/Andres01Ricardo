<?php
require_once($CLASS."sql.php"); 

class Actividades extends Sql{
	
	public function getActividades($cliente){

		
		
		$sql="SELECT a.tipo,a.fechaCreacion,a.horaCreacion,a.motivo,a.vencimiento,concat(e.nombreUsuario,' ' ,e.apellidoUsuario) as encargado,concat(u.nombreUsuario,' ' ,u.apellidoUsuario) as creador,a.duracion,i.icono from actividades as a
			left join usuario as e on a.encargado = e.idUsuario
			left join iconos as i on a.icono = i.idIcono
			left join usuario as u on a.creador = u.idUsuario
			WHERE a.idCliente=$cliente
			ORDER BY a.idActividad desc";

	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}	

	public function getNotas($cliente){

		$sql="SELECT a.fechaCreacion,a.horaCreacion,a.motivo,concat(u.nombreUsuario,' ' ,u.apellidoUsuario) as creador,i.icono from actividades as a
			
			left join iconos as i on a.icono = i.idIcono
			left join usuario as u on a.creador = u.idUsuario
			WHERE a.idCliente=$cliente and a.tipo = 'nota'
			ORDER BY a.idActividad desc";

	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}	
	public function getTareasPendientes($cliente){

		$sql="SELECT a.idActividad,a.fechaCreacion,a.horaCreacion,a.vencimiento,a.motivo,concat(e.nombreUsuario,' ' ,e.apellidoUsuario) as encargado,concat(u.nombreUsuario,' ' ,u.apellidoUsuario) as creador,i.icono from actividades as a
			left join usuario as e on a.encargado = e.idUsuario
			left join iconos as i on a.icono = i.idIcono
			left join usuario as u on a.creador = u.idUsuario
			WHERE a.idCliente=$cliente and a.tipo = 'tarea' and a.estado='pendiente'
			ORDER BY a.idActividad desc";
	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}

	public function getTareasRealizadas($cliente){

		$sql="SELECT a.fechaCreacion,a.horaCreacion,a.vencimiento,a.motivo,concat(e.nombreUsuario,' ' ,e.apellidoUsuario) as encargado,concat(u.nombreUsuario,' ' ,u.apellidoUsuario) as creador,i.icono from actividades as a
			left join usuario as e on a.encargado = e.idUsuario
			left join iconos as i on a.icono = i.idIcono
			left join usuario as u on a.creador = u.idUsuario
			WHERE a.idCliente=$cliente and a.tipo = 'tarea' and a.estado='realizada'
			ORDER BY a.idActividad desc";
	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}



	public function getCorreos($cliente){

		$sql="SELECT a.fechaCreacion,a.horaCreacion,a.motivo,concat(e.nombreUsuario,' ' ,e.apellidoUsuario) as encargado,concat(u.nombreUsuario,' ' ,u.apellidoUsuario) as creador,i.icono,a.estado from actividades as a
			left join usuario as e on a.encargado = e.idUsuario
			left join iconos as i on a.icono = i.idIcono
			left join usuario as u on a.creador = u.idUsuario
			WHERE a.idCliente=$cliente and a.tipo = 'correo'
			ORDER BY a.idActividad desc";

	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}


	public function getLlamadas($cliente){

		$sql="SELECT a.fechaCreacion,a.horaCreacion,a.motivo,a.duracion,concat(u.nombreUsuario,' ' ,u.apellidoUsuario) as creador,i.icono,a.estado from actividades as a
			
			left join iconos as i on a.icono = i.idIcono
			left join usuario as u on a.creador = u.idUsuario
			WHERE a.idCliente=$cliente and a.tipo = 'llamada'
			ORDER BY a.idActividad desc";

	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}

	public function getNegociosNegociacion($cliente){

		$sql="SELECT *
			from actividades as a
			left join usuario as e on a.encargado = e.idUsuario
			left join usuario as u on a.creador = u.idUsuario
			WHERE a.idCliente=$cliente and a.tipo = 'negocio' and a.estado = 'negociacion'
			ORDER BY a.idActividad desc";

	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}


	public function getNegociosGanado($cliente){

		$sql="SELECT * from actividades as a
			left join usuario as e on a.encargado = e.idUsuario
			left join iconos as i on a.icono = i.idIcono
			left join usuario as u on a.creador = u.idUsuario
			WHERE a.idCliente=$cliente and a.tipo = 'negocio' and a.estado = 'ganado'
			ORDER BY a.idActividad desc";

	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}


	public function getNegociosPerdido($cliente){

		$sql="SELECT * from actividades as a

			left join usuario as e on a.encargado = e.idUsuario
			left join iconos as i on a.icono = i.idIcono
			left join usuario as u on a.creador = u.idUsuario
			WHERE a.idCliente=$cliente and a.tipo = 'negocio' and a.estado = 'perdido'
			ORDER BY a.idActividad desc";


	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}


	public function getEmpleados($empresa){

		$sql="SELECT u.idUsuario,e.nombre,e.apellido 
		from empleado_usuario as eu
		inner join empleado as e on eu.idEmpleado = e.idEmpleado
		inner join empleado_informacion_laboral as eil on eil.idEmpleado = e.idEmpleado
		inner join usuario u on u.idUsuario=eu.idUsuario
		where eil.idEmpresa = $empresa";

	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}


}
?>