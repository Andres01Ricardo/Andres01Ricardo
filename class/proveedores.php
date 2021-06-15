<?php

require_once($CLASS."sql.php"); 



class Proveedores extends Sql{

	

	public function getProveedoresEmpresa($aDatos=array()){



		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }

		if(empty($_SESSION["idEmpresa"])){
			if ($aDatos["ingresoPerfilEmpresa"]==0) {
				$condicion.=" AND ue.idUsuario=".$_SESSION["idUsuario"]; 
			}
		}

		if(!empty($_SESSION["idEmpresa"])){

			$condicion.=" AND pe.idEmpresa=".$_SESSION["idEmpresa"]; 

		}

		if($aDatos["estado"]!=""){

			$condicion.=" AND p.estado=".$aDatos["estado"]; 

		}

		$sql="SELECT p.tipoPersona, p.idProveedor, p.nit, p.digitoVerificador, p.razonSocial, p.email, p.telefono, p.direccion,

			p.fechaRegistro, 

			CONCAT(u.nombreUsuario,' ',u.apellidoUsuario) as usuarioRegistra, 

			d.nombre as departamento, c.nombre as ciudad, pa.nombre as pais

			FROM proveedor as p 

			LEFT JOIN proveedor_empresa as pe ON(pe.idProveedor=p.idProveedor)

			LEFT JOIN usuario_empresa as ue ON(ue.idEmpresa=pe.idEmpresa)

			INNER JOIN pais as pa ON(pa.idPais=p.idPais)

			INNER JOIN departamento as d ON(d.idDepartamento=p.idDepartamento)

			INNER JOIN ciudad as c ON(c.idCiudad=p.idCiudad)

			INNER JOIN usuario as u ON(u.idUsuario=p.idUsuarioRegistra)

			WHERE 0=0 ".$condicion." GROUP BY p.idProveedor ORDER BY p.razonSocial ASC";



	    $aArray=$this->ejecutarSql($sql); 

	    return $aArray; 

	}



	

}

?>