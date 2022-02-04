<?php

require_once($CLASS."sql.php"); 



class CuentasContables extends Sql{

	

	public function getCuentasContables($aDatos=array()){



		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }

		
		if($aDatos["idEmpresa"]!=""){

			$condicion.=" AND cc.idEmpresa=".$aDatos["idEmpresa"]; 

		}


		$sql="SELECT  cc.nombre,cc.idCuentaContable,cc.codigoCuenta as codigoCuentaContable,cc.naturaleza,cc.centroCosto,cc.detalle,cc.tercero,cc.porcentajeRetencion,cc.idEmpresa

			FROM cuenta_contable cc
			WHERE 0=0 ".$condicion." AND cc.codigoCuenta not like '000%'
			ORDER BY cc.codigoCuenta ASC";

		

	    $aCuentaContable=$this->ejecutarSql($sql); 

	    return $aCuentaContable; 

	}


	public function getCuentaContable($aDatos=array()){



		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }

		
		if($aDatos["idEmpresa"]!=""){

			$condicion.=" AND ecc.idEmpresa=".$aDatos["idEmpresa"]; 

		}

		if($aDatos["cuenta"]!=""){

			$condicion.=" AND cc.codigoCuenta like'".$aDatos["cuenta"]."%'"; 

		}
		


		$sql="SELECT  cc.nombre,cc.idCuentaContable,cc.codigoCuenta as codigoCuentaContable,cc.naturaleza

			FROM cuenta_contable cc
			INNER JOIN empresa_cuenta_contable ecc on (cc.idCuentaContable= ecc.idCuentaContable)

			WHERE 0=0 ".$condicion." GROUP BY substr(cc.codigoCuenta,1,10)";

		

	    $aCuentaContable=$this->ejecutarSql($sql); 

	    return $aCuentaContable; 

	}


	public function getCuentasContablesEmpresa($idEmpresa){



		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }

				

		$sql="SELECT  nombre,idCuentaContable,codigoCuenta as codigoCuentaContable,naturaleza,centroCosto,tipoCuenta
			FROM cuenta_contable 
			-- INNER JOIN empresa_cuenta_contable ecc on cc.idCuentaContable=ecc.idCuentaContable
			WHERE idEmpresa=$idEmpresa ";

		

	    $aCuentaContable=$this->ejecutarSql($sql); 

	    return $aCuentaContable; 

	}

	public function getCuentaContableFiltrada($cuenta){



		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }

				

		$sql="SELECT concat(codigoCuenta,' - ',nombre) as cuenta 
			
			FROM cuenta_contable 

			WHERE idCuentaContable=$cuenta ";

		

	    $aCuentaContable=$this->ejecutarSql($sql); 

	    return $aCuentaContable; 

	}

}

?>