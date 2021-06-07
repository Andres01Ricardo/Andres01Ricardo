<?php
require_once($CLASS."sql.php"); 

class Empleados extends Sql{
	
	public function getEmpleados($idEmpresa){

		
		
		$sql="SELECT u.idEmpleadoUsuario,u.idEmpleado,u.idUsuario,em.nombre,em.apellido,eil.idEmpresa from empleado_usuario as u
			inner join empleado_informacion_laboral as eil on u.idEmpleado = eil.idEmpleado
			inner join empleado as em on em.idEmpleado = u.idEmpleado
			WHERE eil.idEmpresa= $idEmpresa";



	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}	

	
}
?>