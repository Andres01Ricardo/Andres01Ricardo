<?php
require_once($CLASS."sql.php"); 

class Clientes extends Sql{
	
	public function getClientes($etapa,$idEmpresa){

		
		$sql="SELECT c.procedencia as codigoProcedencia,c.codigoCliente,c.idCliente,c.nombre,c.apellidos,c.email,c.telefono,p.nombreProcedencia as procedencia,c.direccion,concat(e.nombre,' ',e.apellido) as encargado 
			, et.nombreEtapa as etapa, c.fechaUltimoContacto,c.fechaCreacion
			from t_clientes as c
			inner join empleado_usuario as eu on eu.idUsuario = c.encargado
			left join empleado_informacion_laboral as eil  on eu.idEmpleado = eil.idEmpleado
			left join empleado as e on eu.idEmpleado = e.idEmpleado and eil.idEmpresa = $idEmpresa
			left join t_procedencia as p on c.procedencia=p.idProcedencia
			inner join t_etapas as et on c.etapa=et.codigo
			where c.etapa = $etapa and c.idEmpresa =$idEmpresa
			ORDER BY c.fechaUltimoContacto;";

	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}



	
}
?>