<?php
require_once($CLASS."sql.php"); 

class Clientes extends Sql{
	
	// public function getClientesEmpresa($aDatos=array()){

	// 	$condicion=""; 
	// 	if(!isset($_SESSION)){ session_start(); }
	// 	// if($_SESSION["idRol"]==2){
	// 	// 	$condicion.=" AND ue.idUsuario=".$_SESSION["idUsuario"]; 
	// 	// }
	// 	if($_SESSION["idRol"]!=1&&$_SESSION["idRol"]!=2){
	// 		$condicion.=" AND ce.idEmpresa=".$_SESSION["idEmpresa"]; 
	// 	}
	// 	if($aDatos["idEmpresa"]!=""){
	// 		$condicion.=" AND ce.idEmpresa=".$aDatos["idEmpresa"]; 
	// 	}
	// 	// if($aDatos["estado"]!=""){
	// 	// 	$condicion.=" AND c.estado=".$aDatos["estado"]; 
	// 	// }
	// 	$sql="SELECT c.tipoPersona, c.idTercero, c.nit, c.digitoVerificador, c.razonSocial, c.email, c.telefono, c.direccion,
	// 		c.fechaRegistro, 
	// 		CONCAT(u.nombreUsuario,' ',u.apellidoUsuario) as usuarioRegistra, 
	// 		d.nombre as departamento, ci.nombre as ciudad
	// 		FROM tercero as c 
	// 		LEFT JOIN tercero_empresa as ce ON(ce.idTercero=c.idTercero)
	// 		-- LEFT JOIN usuario_empresa as ue ON(ue.idEmpresa=ce.idEmpresa)
	// 		INNER JOIN departamento as d ON(d.idDepartamento=c.idDepartamento)
	// 		INNER JOIN ciudad as ci ON(ci.idCiudad=c.idCiudad)
	// 		INNER JOIN usuario as u ON(u.idUsuario=c.idUsuarioRegistra)
	// 		WHERE 0=0 ".$condicion." GROUP BY c.idTercero ORDER BY c.razonSocial ASC";
		
	//     $aArray=$this->ejecutarSql($sql); 
	//     return $aArray; 
	// }

	public function getClientesEmpresa($aDatos=array()){



		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }

		if($_SESSION["idEmpresa"]!=""){

			$condicion=" AND pe.idEmpresa=".$_SESSION["idEmpresa"]; 

		}
		if($aDatos["idEmpresa"]!=""){

			$condicion=" AND pe.idEmpresa=".$aDatos["idEmpresa"]; 

		}



		$sql="SELECT p.tipoPersona, p.idTercero, p.nit, p.digitoVerificador, p.razonSocial, p.email, p.telefono, p.direccion,

			p.fechaRegistro, 

			CONCAT(u.nombreUsuario,' ',u.apellidoUsuario) as usuarioRegistra, 

			d.nombre as departamento, c.nombre as ciudad

			FROM tercero_empresa as pe 

			INNER JOIN tercero as p ON(p.idTercero=pe.idTercero)

			INNER JOIN departamento as d ON(d.idDepartamento=p.idDepartamento)

			INNER JOIN ciudad as c ON(c.idCiudad=p.idCiudad)

			INNER JOIN usuario as u ON(u.idUsuario=p.idUsuarioRegistra)

			  WHERE 0=0 ".$condicion." GROUP BY p.idTercero ORDER BY p.razonSocial ASC";


			




	    $aProductos=$this->ejecutarSql($sql); 

	    return $aProductos; 

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