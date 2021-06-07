<?php
require_once($CLASS."sql.php"); 

class Estadistica extends Sql{
	
	public function getEstadisticaProcedencia(){
		if(!isset($_SESSION)){ session_start(); }
		$idEmpresa=$_SESSION['idEmpresa'];
		$sql="SELECT c.procedencia,p.nombreProcedencia as nombre, count(procedencia) as total 
			FROM t_clientes as c
            INNER JOIN t_procedencia as p on c.procedencia = p.idProcedencia
            WHERE idEmpresa=$idEmpresa
            GROUP BY procedencia";

	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}


	public function getEncargadoClientes($empresa){


		$sql="SELECT c.idCliente,c.nombre,c.apellidos, concat(e.nombre,' ',e.apellido) as empleado,count(c.idCliente) as total from t_clientes as c
			inner join empleado as e on c.encargado = e.idEmpleado
			inner join empleado_informacion_laboral as eil on eil.idEmpleado = e.idEmpleado
			where eil.idEmpresa = $empresa
			group by encargado";

	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}
	public function getNegocios($cliente){

		
		$sql="SELECT estado, count(estado) as total 
		from actividades 
		where tipo = 'negocio' and idCliente = $cliente
		group by estado";

	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}


	public function getNegociosGanadosMeses($idEmpresa){
		
		
		$sql="SELECT concat(monthname(a.fechaCreacion),' ',year(a.fechaCreacion)) as fecha,sum(a.valor) as total 
		from actividades as a 
			inner join t_clientes as c on a.idCliente = c.codigoCliente 
			where a.tipo= 'negocio' and a.estado = 'ganado' and c.idEmpresa=$idEmpresa
			group by month(a.fechaCreacion)
			order by a.fechaCreacion";
			
	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}
	
	public function getNegociosPerdidosMeses($idEmpresa){

		
		
		$sql="SELECT concat(monthname(a.fechaCreacion),' ',year(a.fechaCreacion)) as fecha,sum(a.valor) as total from actividades as a 
		inner join t_clientes as c on a.idCliente = c.codigoCliente 
		where a.tipo= 'negocio' and a.estado = 'perdido' and c.idEmpresa=$idEmpresa
		group by month(a.fechaCreacion)
		order by a.fechaCreacion";
		
	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}


	public function getNegociosGanadosdia($idEmpresa){
		
		
		$sql="SELECT a.fechaCreacion as fecha,sum(a.valor) as total from actividades as a 
			inner join t_clientes as c on a.idCliente = c.codigoCliente 
			where a.tipo= 'negocio' and a.estado = 'ganado' and c.idEmpresa=$idEmpresa
			group by a.fechaCreacion
			order by a.fechaCreacion";
			
	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}
	
	public function getNegociosPerdidosdia($idEmpresa){

		
		
		$sql="SELECT a.fechaCreacion as fecha,sum(a.valor) as total 
		FROM actividades as a 
		INNER JOIN t_clientes as c on a.idCliente = c.codigoCliente 
		where a.tipo= 'negocio' and a.estado = 'perdido' and c.idEmpresa=$idEmpresa
		group by a.fechaCreacion
		order by a.fechaCreacion";
		
	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}
}

?>