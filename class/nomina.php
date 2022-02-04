<?php

require_once($CLASS."sql.php"); 



class Nomina extends Sql{

	

	public function getNovedades($aData=array()){



		$condicion=""; 

		if($aData["idEmpresa"]!=""){ 

			$condicion.=" AND en.idEmpresa=".$aData["idEmpresa"];

		}

		
		// if($_SESSION["idRol"]==2){
		// 	if ($aData["ingresoPerfilEmpresa"]==0) {
		// 		$condicion.=" AND ue.idUsuario=".$_SESSION["idUsuario"]; 
		// 	}else{
		// 		$condicion="";
		// 	}
		// }		

		$sql="SELECT en.idEmpresaNovedad, en.fechaRegistro, en.estado, CONCAT(e.nombre,' ',e.apellido) as empleado, em.razonSocial, n.nombre as novedad,  CONCAT(u.nombreUsuario,' ',u.apellidoUsuario) as usuarioRegistra,n.idNovedades

			FROM empresa_novedad as en 

			INNER JOIN empleado as e ON(e.idEmpleado=en.idEmpleado)

			INNER JOIN novedades as n ON(n.idNovedades=en.idNovedades)

			INNER JOIN empresa as em ON(em.idEmpresa=en.idEmpresa)

			INNER JOIN usuario as u ON(u.idUsuario=en.idUsuarioRegistra)

			LEFT JOIN usuario_empresa as ue ON(ue.idEmpresa=em.idEmpresa)

			WHERE 0=0 ".$condicion." GROUP BY en.idEmpresaNovedad ORDER BY en.fechaRegistro DESC ";

		

	    $aDatos=$this->ejecutarSql($sql); 

	    return $aDatos; 

	}



	public function getNomina($aData=array()){



		$condicion=""; 

		if($aData["idEmpresa"]!=""){ 

			$condicion.=" AND e.idEmpresa=".$aData["idEmpresa"];

		}

		if($aData["idUsuario"]!=""){ 

			$condicion.=" AND ue.idUsuario=".$aData["idUsuario"];

		}		

		if($aData["idNomina"]!=""){ 

			$condicion.=" AND n.idNomina=".$aData["idNomina"];

		}	

		$sql="SELECT n.idNomina, n.fechaRegistro, n.periodoMes, n.periodoAnio, n.tiempoPago, e.razonSocial, 

			SUM(ne.valorPagar) as valorNomina, n.estado, n.linkPlanilla ,n.idEmpresa

			FROM nomina as n 

			INNER JOIN empresa as e ON(e.idEmpresa=n.idEmpresa)

			INNER JOIN nomina_empleado as ne ON(ne.idNomina=n.idNomina)

			-- LEFT JOIN usuario_empresa as ue ON(ue.idEmpresa=e.idEmpresa)

			WHERE 0=0 ".$condicion." GROUP BY n.idNomina ORDER BY e.razonSocial ASC,n.periodoAnio DESC,n.periodoMes DESC
			 ";

		

	    $aDatos=$this->ejecutarSql($sql); 

	    return $aDatos; 

	}



	public function getTotalParafiscales($aData=array()){



		$condicion=""; 

		if($aData["idNomina"]!=""){ 

			$condicion.=" AND n.idNomina=".$aData["idNomina"];

		}

		if($aData["tipoConcepto"]!=""){ 

			$condicion.=" AND np.tipoConcepto=".$aData["tipoConcepto"];

		}

		if($aData["tipoDeduccion"]!=""){ 

			$condicion.=" AND np.tipoDeduccion=".$aData["tipoDeduccion"];

		}

		$sql="SELECT SUM(np.valor) as valor, np.tipoDeduccion FROM nomina_empleado_parafiscales as np 

				INNER JOIN nomina_empleado as ne ON(ne.idNominaEmpleado=np.idNominaEmpleado)

				INNER JOIN nomina as n ON(ne.idNomina=n.idNomina)

				WHERE 0=0 ".$condicion." GROUP BY np.tipoDeduccion ";

		

	    $aDatos=$this->ejecutarSql($sql); 

	    return $aDatos; 

	}

}

?>