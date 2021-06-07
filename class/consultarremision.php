<?php
require_once($CLASS."sql.php"); 

class Remision extends Sql{
	
	public function getRemision($idEmpresa){

		
		$sql="SELECT c.idRemision,c.numero,c.fecha,cl.nombre,cl.apellidos,c.observaciones,c.bodega,c.estado
			from remision as c
			inner join t_clientes as cl on c.idCliente = cl.codigoCliente
			where c.idEmpresa =$idEmpresa
			ORDER BY c.idRemision desc";

	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}
}
?>