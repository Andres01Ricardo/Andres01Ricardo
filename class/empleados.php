<?php

require_once($CLASS."sql.php"); 



class Empleados extends Sql{

	

	public function getEmpleadosEmpresa($aDatos=array()){

		if(!isset($_SESSION)){ session_start(); }

		$condicion=""; 

		if(!empty($_SESSION["idEmpresa"])){

			$condicion.=" AND ee.idEmpresa=".$_SESSION["idEmpresa"]; 

		}

		if($aDatos["idEmpresa"]!=""){

			$condicion.=" AND ee.idEmpresa=".$aDatos["idEmpresa"]; 

		}

		if($aDatos["idUsuario"]!=""){

			$condicion.=" AND ue.idUsuario=".$aDatos["idUsuario"]; 

		}

		if($aDatos["estado"]!=""){

			$condicion.=" AND e.estado=".$aDatos["estado"]; 

		}

		$sql="SELECT e.idEmpleado, e.fechaRegistro, e.tipoDocumento, e.numeroDocumento, e.nombre, e.apellido, e.genero, 

			  e.email, eil.estado, em.razonSocial ,e.estado

			  FROM empleado as e 

			  INNER JOIN empleado_informacion_laboral as eil ON(eil.idEmpleado=e.idEmpleado)

			  INNER JOIN empleado_empresa as ee ON(ee.idEmpleado=e.idEmpleado)

			  INNER JOIN empresa as em ON(em.idEmpresa=ee.idEmpresa)

			  WHERE 0=0 ".$condicion." GROUP BY e.idEmpleado ORDER BY e.nombre ASC";



	    $aArray=$this->ejecutarSql($sql); 

	    return $aArray; 

	}

	public function getEmpleadosEmpresaUsuarios($aDatos=array()){



		$condicion=""; 

		

		if($aDatos["idEmpresa"]!=""){

			$condicion.=" AND eil.idEmpresa=".$aDatos["idEmpresa"]; 

		}

		if($aDatos["idUsuario"]!=""){

			$condicion.=" AND ue.idUsuario=".$aDatos["idUsuario"]; 

		}

		if($aDatos["estado"]!=""){

			$condicion.=" AND e.estado=".$aDatos["estado"]; 

		}

		$sql="SELECT e.idEmpleado, e.fechaRegistro, e.tipoDocumento, e.numeroDocumento, e.nombre, e.apellido, e.genero, 

			  e.email, eil.estado, em.razonSocial 

			  FROM empleado as e 

			  INNER JOIN empleado_informacion_laboral as eil ON(eil.idEmpleado=e.idEmpleado)

			  INNER JOIN empresa as em ON(em.idEmpresa=eil.idEmpresa)

			  -- LEFT JOIN usuario_empresa as ue ON(ue.idEmpresa=eil.idEmpresa)

			  -- INNER JOIN empleado_usuario eu ON(eu.idEmpleado=e.idEmpleado)

			  WHERE 0=0 ".$condicion." GROUP BY e.idEmpleado ORDER BY e.nombre ASC";



	    $aArray=$this->ejecutarSql($sql); 

	    return $aArray; 

	}



	public function getEfectividadEmpleado($aDatos=array()){



		$condicion=""; 

		

		if($aDatos["idUsuario"]!=""){

			$condicion.=" AND ue.idUsuario=".$aDatos["idUsuario"]; 

		}

		$sql="SELECT COUNT(fc.idFacturaCompra) as cantidad FROM factura_compra as fc 

				INNER JOIN empresa as e ON(e.idEmpresa=fc.idEmpresa)

				INNER JOIN usuario_empresa as ue ON(ue.idEmpresa=e.idEmpresa)

				WHERE 0=0 AND fc.estado<>1 ".$condicion."";



	    $aRealizadas=$this->ejecutarSql($sql); 



	    $sql2="SELECT COUNT(fc.idFacturaCompra) as cantidad FROM factura_compra as fc 

				INNER JOIN empresa as e ON(e.idEmpresa=fc.idEmpresa)

				INNER JOIN usuario_empresa as ue ON(ue.idEmpresa=e.idEmpresa)

				WHERE 0=0 ".$condicion."";



	    $aGeneral=$this->ejecutarSql($sql2);

	    

	    $total=0; 

	    if(!empty($aGeneral)){

	    	$total=($aRealizadas[0]["cantidad"]*100)/$aGeneral[0]["cantidad"]; 

	    }

	    return $total; 

	}

}

?>