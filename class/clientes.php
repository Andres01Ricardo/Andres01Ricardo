<?php
require_once($CLASS."sql.php"); 

class Clientes extends Sql{
	
	public function getClientesEmpresa($aDatos=array()){

		$condicion=""; 
		if(!isset($_SESSION)){ session_start(); }
		// if($_SESSION["idRol"]==2){
		// 	$condicion.=" AND ue.idUsuario=".$_SESSION["idUsuario"]; 
		// }
		if($_SESSION["idRol"]!=1&&$_SESSION["idRol"]!=2){
			$condicion.=" AND ce.idEmpresa=".$_SESSION["idEmpresa"]; 
		}
		if($aDatos["idEmpresa"]!=""){
			$condicion.=" AND ce.idEmpresa=".$aDatos["idEmpresa"]; 
		}
		// if($aDatos["estado"]!=""){
		// 	$condicion.=" AND c.estado=".$aDatos["estado"]; 
		// }
		$sql="SELECT c.tipoPersona, c.idCliente, c.nit, c.digitoVerificador, c.razonSocial, c.email, c.telefono, c.direccion,
			c.fechaRegistro, 
			CONCAT(u.nombreUsuario,' ',u.apellidoUsuario) as usuarioRegistra, 
			d.nombre as departamento, ci.nombre as ciudad
			FROM cliente as c 
			LEFT JOIN cliente_empresa as ce ON(ce.idCliente=c.idCliente)
			-- LEFT JOIN usuario_empresa as ue ON(ue.idEmpresa=ce.idEmpresa)
			INNER JOIN departamento as d ON(d.idDepartamento=c.idDepartamento)
			INNER JOIN ciudad as ci ON(ci.idCiudad=c.idCiudad)
			INNER JOIN usuario as u ON(u.idUsuario=c.idUsuarioRegistra)
			WHERE 0=0 ".$condicion." GROUP BY c.idCliente ORDER BY c.razonSocial ASC";
		
	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}



	public function getClientesE($aDatos=array()){

		$condicion=""; 
		if(!isset($_SESSION)){ session_start(); }
		// if($_SESSION["idRol"]==2){
		// 	$condicion.=" AND ue.idUsuario=".$_SESSION["idUsuario"]; 
		// }
		if($_SESSION["idRol"]!=1 && $_SESSION["idRol"]!=2 && $_SESSION["idRol"]!=5){
			$condicion.=" AND ce.idEmpresa=".$_SESSION["idEmpresa"]; 
		}
		if($aDatos["idEmpresa"]!=""){
			$condicion.=" AND ce.idEmpresa=".$aDatos["idEmpresa"]; 
		}
		// if($aDatos["estado"]!=""){
		// 	$condicion.=" AND c.estado=".$aDatos["estado"]; 
		// }
		$sql="SELECT *
			FROM cliente as c 
			INNER JOIN cliente_empresa as ce ON(ce.idCliente=c.idCliente)
			WHERE 0=0 ".$condicion." GROUP BY c.idCliente ORDER BY c.razonSocial ASC";
		
	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}
	
}
?>