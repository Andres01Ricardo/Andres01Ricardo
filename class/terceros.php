<?php

require_once($CLASS."sql.php"); 



class Terceros extends Sql{

	

	public function getTercerosEmpresa($aDatos=array()){



		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }

		
		if($_SESSION["idRol"]!=1 && $_SESSION["idRol"]!=2 && $_SESSION["idRol"]!=5){

			$condicion.=" AND pe.idEmpresa=".$_SESSION["idEmpresa"]; 

		}


		if($aDatos["estado"]!=""){

			$condicion.=" AND p.estado=".$aDatos["estado"]; 

		}

		if($aDatos["idEmpresa"]!=""){

			$condicion.=" AND pe.idEmpresa=".$aDatos["idEmpresa"]; 

		}

		$sql="SELECT *

			FROM tercero as p 

			INNER JOIN tercero_empresa as pe ON(pe.idTercero=p.idTercero)

			WHERE 0=0 ".$condicion." ORDER BY nit";



	    $aProveedores=$this->ejecutarSql($sql); 

	    return $aProveedores; 

	}





	public function getClientesEmpresa($aDatos=array()){



		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }

		if($_SESSION["idRol"]==2){

			$condicion.=" AND ue.idUsuario=".$_SESSION["idUsuario"]; 

		}

		if($_SESSION["idRol"]!=1&&$_SESSION["idRol"]!=2){

			$condicion.=" AND pe.idEmpresa=".$_SESSION["idEmpresa"]; 

		}

		if($aDatos["estado"]!=""){

			$condicion.=" AND p.estado=".$aDatos["estado"]; 

		}



		$sql="SELECT p.tipoPersona, p.idTercero	, p.nit, p.digitoVerificador, p.razonSocial, p.email, p.telefono, p.direccion,

			p.fechaRegistro, 

			CONCAT(u.nombreUsuario,' ',u.apellidoUsuario) as usuarioRegistra, 

			d.nombre as departamento, c.nombre as ciudad

			FROM tercero as p 

			-- INNER JOIN tercero_empresa as pe ON(pe.idCliente=p.idCliente)

			-- LEFT JOIN usuario_empresa as ue ON(ue.idEmpresa=pe.idEmpresa)

			INNER JOIN departamento as d ON(d.idDepartamento=p.idDepartamento)

			INNER JOIN ciudad as c ON(c.idCiudad=p.idCiudad)

			INNER JOIN usuario_contable as u ON(u.idUsuario=p.idUsuarioRegistra)

			WHERE 0=0 ".$condicion." and tipoTercero='cliente' GROUP BY p.idTercero ORDER BY p.razonSocial ASC";



	    $aClientes=$this->ejecutarSql($sql); 

	    return $aClientes; 

	}





	public function getOtrosEmpresa($aDatos=array()){



		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }

		if($_SESSION["idRol"]==2){

			$condicion.=" AND ue.idUsuario=".$_SESSION["idUsuario"]; 

		}

		if($_SESSION["idRol"]!=1&&$_SESSION["idRol"]!=2){

			$condicion.=" AND pe.idEmpresa=".$_SESSION["idEmpresa"]; 

		}

		if($aDatos["estado"]!=""){

			$condicion.=" AND p.estado=".$aDatos["estado"]; 

		}

		$sql="SELECT p.tipoPersona, p.idtercero, p.nit, p.digitoVerificador, p.razonSocial, p.email, p.telefono, p.direccion,

			p.fechaRegistro, 

			CONCAT(u.nombreUsuario,' ',u.apellidoUsuario) as usuarioRegistra, 

			d.nombre as departamento, c.nombre as ciudad

			FROM tercero as p 

			

			INNER JOIN departamento as d ON(d.idDepartamento=p.idDepartamento)

			INNER JOIN ciudad as c ON(c.idCiudad=p.idCiudad)

			INNER JOIN usuario_contable as u ON(u.idUsuario=p.idUsuarioRegistra)

			WHERE 0=0 ".$condicion." and tipoTercero='otro' GROUP BY p.idTercero ORDER BY p.razonSocial ASC";



	    $aOtros=$this->ejecutarSql($sql); 

	    return $aOtros; 

	}




	public function getTercerosEmpresass($aDatos=array()){



		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }

		if($_SESSION["idRol"]==2){

			$condicion.=" AND ue.idUsuario=".$_SESSION["idUsuario"]; 

		}

		if($_SESSION["idRol"]!=1&&$_SESSION["idRol"]!=2){

			$condicion.=" AND pe.idEmpresa=".$_SESSION["idEmpresa"]; 

		}

		if($aDatos["estado"]!=""){

			$condicion.=" AND p.estado=".$aDatos["estado"]; 

		}

		$sql="SELECT p.tipoPersona, p.idTercero, p.nit, p.digitoVerificador, p.razonSocial, p.email, p.telefono, p.direccion,p.tipoTercero,

			p.fechaRegistro, 

			CONCAT(u.nombreUsuario,' ',u.apellidoUsuario) as usuarioRegistra, 

			d.nombre as departamento, c.nombre as ciudad

			FROM tercero as p 

			

			INNER JOIN departamento as d ON(d.idDepartamento=p.idDepartamento)

			INNER JOIN ciudad as c ON(c.idCiudad=p.idCiudad)

			INNER JOIN usuario_contable as u ON(u.idUsuario=p.idUsuarioRegistra)

			WHERE 0=0 ".$condicion." GROUP BY p.idTercero ORDER BY p.razonSocial ASC";



	    $aTerceros=$this->ejecutarSql($sql); 

	    return $aTerceros; 

	}

	public function getEmpleadosEmpresaTercero($aDatos=array()){

		$condicion=""; 
		if(!isset($_SESSION)){ session_start(); }
		// if($_SESSION["idRol"]==2){
		// 	$condicion.=" AND ue.idUsuario=".$_SESSION["idUsuario"]; 
		// }
		if($_SESSION["idRol"]!=1&&$_SESSION["idRol"]!=2){
			$condicion.=" AND ee.idEmpresa=".$_SESSION["idEmpresa"]; 
		}
		if($aDatos["idEmpresa"]!=""){
			$condicion.=" AND ee.idEmpresa=".$aDatos["idEmpresa"]; 
		}
		// if($aDatos["estado"]!=""){
		// 	$condicion.=" AND c.estado=".$aDatos["estado"]; 
		// }
		$sql="SELECT e.idEmpleado,e.tipoDocumento,e.numeroDocumento as nit, CONCAT(e.nombre,' ',e.apellido) as razonSocial,ee.idEmpleadoEmpresa 
		FROM empleado e
		INNER JOIN empleado_informacion_laboral eil on e.idEmpleado=eil.idEmpleado
		INNER JOIN empleado_empresa ee on ee.idEmpleado=e.idEmpleado
		WHERE 0=0 ".$condicion." ";
		
	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}

}

?>