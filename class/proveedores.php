<?php

require_once($CLASS."sql.php"); 



class Proveedores extends Sql{

	

	public function getProveedoresEmpresa($aDatos=array()){



		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }

		if(!empty($_SESSION["idEmpresa"])){

			$condicion=" AND pe.idEmpresa=".$_SESSION["idEmpresa"]; 

		}
		if($aDatos["idEmpresa"]!=""){

			$condicion=" AND pe.idEmpresa=".$aDatos["idEmpresa"]; 

		}

		if($aDatos["estado"]!=""){

			$condicion.=" AND p.estado=".$aDatos["estado"]; 

		}

		$sql="SELECT p.tipoPersona, p.idTercero, p.nit, p.digitoVerificador, p.razonSocial, p.email, p.telefono, p.direccion,

			p.fechaRegistro, 

			CONCAT(u.nombreUsuario,' ',u.apellidoUsuario) as usuarioRegistra, 

			d.nombre as departamento, c.nombre as ciudad

			FROM tercero_empresa as pe

			INNER JOIN tercero as p   ON(pe.idTercero=p.idTercero)
			

			INNER JOIN departamento as d ON(d.idDepartamento=p.idDepartamento)

			INNER JOIN ciudad as c ON(c.idCiudad=p.idCiudad)

			INNER JOIN usuario as u ON(u.idUsuario=p.idUsuarioRegistra)

			WHERE 0=0 ".$condicion." AND (p.tipoTercero=2 or p.tipoTercero=4 or p.tipoTercero=6 or p.tipoTercero=7) GROUP BY p.idTercero ORDER BY p.razonSocial ASC";



	    $aArray=$this->ejecutarSql($sql); 

	    return $aArray; 

	}



	

}

?>