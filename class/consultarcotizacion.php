<?php
require_once($CLASS."sql.php"); 

class Cotizacion extends Sql{
	
	public function getCotizacion($idEmpresa){

		
		$sql="SELECT c.idCotizacion,c.estado,c.fechaRegistro,c.fechaVencimientoCotizacion,cl.nombre,cl.apellidos,c.subtotal,c.iva,c.total ,c.numeroCotizacion
			from cotizacion as c
			inner join t_clientes as cl on c.idCliente = cl.codigoCliente
			where c.idEmpresa =$idEmpresa
			ORDER BY c.idCotizacion desc";

	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}
}
?>