<?php

require_once($CLASS."sql.php"); 



class Empresa extends Sql{

	

	public function getEmpresas($aDatos=array()){

		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }

		if(empty($_SESSION["idEmpresa"])){
			if ($aDatos["ingresoPerfilEmpresa"]=='0') {
				$condicion=" AND ue.idUsuario=".$_SESSION["idUsuario"]; 
				
			}
			// print_r($aDatos["ingresoPerfilEmpresa"]);
		}
		if(!empty($_SESSION["idEmpresa"])){
			$condicion=" AND e.idEmpresa=".$_SESSION["idEmpresa"]; 
		}


		$sql="SELECT e.idEmpresa, e.razonSocial ,e.nit, e.direccion, c.nombre as ciudad,e.telefono,e.digitoVerificador,d.nombre as departamento,e.estado
			FROM empresa as e 
			LEFT JOIN usuario_empresa as ue ON(ue.idEmpresa=e.idEmpresa)
			INNER JOIN ciudad as c ON(c.idCiudad = e.idCiudad)
			INNER JOIN departamento as d ON(d.idDepartamento = e.idDepartamento)
			WHERE 0=0 ".$condicion." GROUP BY e.idEmpresa ORDER BY e.razonSocial ASC";


	    $aEmpresas=$this->ejecutarSql($sql); 
	    // print_r($condicion);
	    return $aEmpresas; 

	}


	public function getEmpresasExterno($aDatos=array()){



		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }

		if($_SESSION["idRol"]==5){

			$condicion=" AND ue.idUsuario=".$_SESSION["idUsuario"]; 

		}
		
		

		$sql="SELECT e.idEmpresa, e.razonSocial ,e.nit, e.direccion, c.nombre as ciudad,e.telefono,e.digitoVerificador,d.nombre as departamento,e.estado

			FROM empresa as e 

			INNER JOIN usuario_empresa as ue ON(ue.idEmpresa=e.idEmpresa)

			INNER JOIN ciudad as c ON(c.idCiudad = e.idCiudad)

			INNER JOIN departamento as d ON(d.idDepartamento = e.idDepartamento)

			WHERE 0=0 ".$condicion." GROUP BY e.idEmpresa ORDER BY e.razonSocial ASC";

	    $aEmpresas=$this->ejecutarSql($sql); 

	    return $aEmpresas; 

	}



	public function getRentabilidad($aDatos=array()){



		$condicion=""; 

		

		if($aDatos["idEmpresa"]!=""){

			$condicion.=" AND e.idEmpresa=".$aDatos["idEmpresa"]; 

		}

		if($aDatos["anio"]!=""){

			$condicion.=" AND e.periodoAnio=".$aDatos["anio"]; 

		}

		if($aDatos["mes"]!=""){

			$condicion.=" AND e.periodoMes=".$aDatos["mes"]; 

		}

		$sql="SELECT e.periodoMes, e.periodoAnio, ei.valor 

				FROM estado_financiero as e 

				INNER JOIN estado_financiero_item as ei ON(e.idEstadoFinanciero=ei.idEstadoFinanciero AND ei.tipo=1)

				WHERE 0=0 ".$condicion." ORDER BY periodoAnio,periodoMes ASC";



	    $aReturn=$this->ejecutarSql($sql); 

	    return $aReturn; 

	}


public function getIngresos($aDatos=array()){



		$condicion=""; 

		

		if($aDatos["idEmpresa"]!=""){

			$condicion.=" AND e.idEmpresa=".$aDatos["idEmpresa"]; 

		}

		if($aDatos["anio"]!=""){

			$condicion.=" AND e.periodoAnio=".$aDatos["anio"]; 

		}

		if($aDatos["mes"]!=""){

			$condicion.=" AND e.periodoMes=".$aDatos["mes"]; 

		}

		$sql="SELECT sum(ei.valor) as valor

				FROM estado_financiero as e 

				INNER JOIN estado_financiero_item as ei ON(e.idEstadoFinanciero=ei.idEstadoFinanciero AND ei.tipo=2)

				WHERE 0=0 ".$condicion;



	    $aReturnI=$this->ejecutarSql($sql); 

	    return $aReturnI; 

	}
	public function getGastos($aDatos=array()){



		$condicion=""; 

		

		if($aDatos["idEmpresa"]!=""){

			$condicion.=" AND e.idEmpresa=".$aDatos["idEmpresa"]; 

		}

		if($aDatos["anio"]!=""){

			$condicion.=" AND e.periodoAnio=".$aDatos["anio"]; 

		}

		if($aDatos["mes"]!=""){

			$condicion.=" AND e.periodoMes=".$aDatos["mes"]; 

		}

		$sql="SELECT  sum(ei.valor) as valor

				FROM estado_financiero as e 

				INNER JOIN estado_financiero_item as ei ON(e.idEstadoFinanciero=ei.idEstadoFinanciero AND ei.tipo=3)

				WHERE 0=0 ".$condicion;



	    $aReturnG=$this->ejecutarSql($sql); 

	    return $aReturnG; 

	}


	public function getRentabilidadCuenta($aDatos=array()){



		$condicion=""; 

		

		if($aDatos["idEmpresa"]!=""){

			$condicion.=" AND e.idEmpresa=".$aDatos["idEmpresa"]; 

		}

		if($aDatos["anio"]!=""){

			$condicion.=" AND e.periodoAnio=".$aDatos["anio"]; 

		}

		if($aDatos["mes"]!=""){

			$condicion.=" AND e.periodoMes=".$aDatos["mes"]; 

		}

		if($aDatos["cuenta"]!=""){

			$condicion.=" AND ei.cuenta LIKE '".$aDatos["cuenta"]."'"; 

		}

		if($aDatos["desde"]!=""){

			$condicion.=" AND e.periodoMes >=".$aDatos["desde"]; 

		}
		if($aDatos["hasta"]!=""){

			$condicion.=" AND e.periodoMes <=".$aDatos["hasta"]; 

		}

		$sql="SELECT e.periodoMes, e.periodoAnio, ei.valor 

				FROM estado_financiero as e 

				INNER JOIN estado_financiero_item as ei ON(e.idEstadoFinanciero=ei.idEstadoFinanciero)

				WHERE 0=0 ".$condicion." ORDER BY periodoAnio,periodoMes ASC";



	    $aReturn=$this->ejecutarSql($sql); 

	    return $aReturn; 

	}

	public function getSituacionFinanciera($aDatos=array()){



		$condicion=""; 

		

		if($aDatos["idEmpresa"]!=""){

			$condicion.=" AND b.idEmpresa=".$aDatos["idEmpresa"]; 

		}

		if($aDatos["anio"]!=""){

			$condicion.=" AND b.periodoAnio=".$aDatos["anio"]; 

		}

		if($aDatos["mes"]!=""){

			$condicion.=" AND b.periodoMes=".$aDatos["mes"]; 

		}

		$sql="SELECT b.periodoMes, b.periodoAnio, bi.titulo, bi.total, 

			IF(bi.titulo LIKE 'TOTAL ACTIVO',1,IF(bi.titulo LIKE 'TOTAL PASIVO',2,3)) as tipo 

			FROM balance_general as b

			INNER JOIN balance_general_item as bi ON(bi.idBalanceGeneral=b.idBalanceGeneral)

			WHERE 0=0 ".$condicion." AND 

			(bi.titulo LIKE 'TOTAL ACTIVO' OR bi.titulo LIKE 'TOTAL PASIVO' OR bi.titulo LIKE 'TOTAL PATRIMONIO') 

			ORDER BY b.periodoAnio ASC,b.periodoMes ASC";



	    $aReturn=$this->ejecutarSql($sql); 

	    return $aReturn; 

	}

	public function getActivoAcumulado($aDatos=array()){



		$condicion=""; 

		

		if($aDatos["idEmpresa"]!=""){

			$condicion.=" AND b.idEmpresa=".$aDatos["idEmpresa"]; 

		}

		if($aDatos["anio"]!=""){

			$condicion.=" AND b.periodoAnio=".$aDatos["anio"]; 

		}
		if($aDatos["desde"]!=""){

			$condicion.=" AND b.periodoMes >=".$aDatos["desde"]; 

		}
		if($aDatos["hasta"]!=""){

			$condicion.=" AND b.periodoMes <=".$aDatos["hasta"]; 

		}

		$sql="SELECT b.periodoMes, b.periodoAnio, bi.titulo, bi.total 

			FROM balance_general as b

			INNER JOIN balance_general_item as bi ON(bi.idBalanceGeneral=b.idBalanceGeneral)

			WHERE 0=0 ".$condicion." AND 

			(bi.titulo LIKE 'TOTAL ACTIVO') 

			ORDER BY b.periodoAnio,b.periodoMes ASC";



	    $aReturn=$this->ejecutarSql($sql); 

	    return $aReturn; 

	}

	public function getPasivoAcumulado($aDatos=array()){



		$condicion=""; 

		

		if($aDatos["idEmpresa"]!=""){

			$condicion.=" AND b.idEmpresa=".$aDatos["idEmpresa"]; 

		}

		if($aDatos["anio"]!=""){

			$condicion.=" AND b.periodoAnio=".$aDatos["anio"]; 

		}
		if($aDatos["desde"]!=""){

			$condicion.=" AND b.periodoMes >=".$aDatos["desde"]; 

		}
		if($aDatos["hasta"]!=""){

			$condicion.=" AND b.periodoMes <=".$aDatos["hasta"]; 

		}

		$sql="SELECT b.periodoMes, b.periodoAnio, bi.titulo, bi.total 

			FROM balance_general as b

			INNER JOIN balance_general_item as bi ON(bi.idBalanceGeneral=b.idBalanceGeneral)

			WHERE 0=0 ".$condicion." AND 

			(bi.titulo LIKE 'TOTAL PASIVO') 

			ORDER BY b.periodoAnio,b.periodoMes ASC";



	    $aReturn=$this->ejecutarSql($sql); 

	    return $aReturn; 

	}

	public function getCuentaSituacionFinanciera($aDatos=array()){



		$condicion=""; 

		

		if($aDatos["idEmpresa"]!=""){

			$condicion.=" AND b.idEmpresa=".$aDatos["idEmpresa"]; 

		}

		if($aDatos["anio"]!=""){

			$condicion.=" AND b.periodoAnio=".$aDatos["anio"]; 

		}

		if($aDatos["mes"]!=""){

			$condicion.=" AND b.periodoMes=".$aDatos["mes"]; 

		}

		if($aDatos["cuenta"]!=""){

			$condicion.=" AND bi.titulo LIKE '".$aDatos["cuenta"]."'"; 

		}
		if($aDatos["desde"]!=""){

			$condicion.=" AND b.periodoMes >=".$aDatos["desde"]; 

		}
		if($aDatos["hasta"]!=""){

			$condicion.=" AND b.periodoMes <=".$aDatos["hasta"]; 

		}

		$sql="SELECT b.periodoMes, b.periodoAnio, bi.titulo, bi.total 

			FROM balance_general as b

			INNER JOIN balance_general_item as bi ON(bi.idBalanceGeneral=b.idBalanceGeneral)

			WHERE 0=0 ".$condicion." 

			ORDER BY b.periodoAnio,b.periodoMes ASC";



	    $aReturn=$this->ejecutarSql($sql); 

	    return $aReturn; 

	}



	public function getCuentaFinanciera($aDatos=array()){



		$condicion=""; 

		

		if($aDatos["idEmpresa"]!=""){

			$condicion.=" AND b.idEmpresa=".$aDatos["idEmpresa"]; 

		}

		if($aDatos["anio"]!=""){

			$condicion.=" AND b.periodoAnio=".$aDatos["anio"]; 

		}

		if($aDatos["mes"]!=""){

			$condicion.=" AND b.periodoMes=".$aDatos["mes"]; 

		}

		if($aDatos["cuenta"]!=""){

			$condicion.=" AND bgc.numeroCuenta LIKE '".$aDatos["cuenta"]."'"; 

		}

		$sql="SELECT b.idBalanceGeneral, bgc.numeroCuenta, bgc.nombreCuenta, bgc.valor

			FROM balance_general as b

			INNER JOIN balance_general_item as bi ON(bi.idBalanceGeneral=b.idBalanceGeneral)

            INNER JOIN balance_general_cuenta as bgc ON(bgc.idBalanceGeneralItem=bi.idBalanceGeneralItem)

			WHERE 0=0 ".$condicion."

			ORDER BY b.periodoAnio,b.periodoMes ASC";

			

	    $aReturn=$this->ejecutarSql($sql); 

	    return $aReturn; 

	}



}

?>