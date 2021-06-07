<?php

require_once($CLASS."sql.php"); 



class CuentasContables extends Sql{

	

	public function getCuentasContables(){



		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }

				

		$sql="SELECT  nombre,idCuentaContable,codigoCuenta as codigoCuentaContable,naturaleza

			FROM cuenta_contable

			WHERE 0=0 ";

		

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