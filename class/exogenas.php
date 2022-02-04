<?php

require_once($CLASS."sql.php"); 



class Exogenas extends Sql{

	

	public function getCuentasMovimientoAnual($aDatos=array()){

		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }
		
		if(!empty($_SESSION["idEmpresa"])){
			$condicion.=" AND c.idEmpresa=".$_SESSION["idEmpresa"]; 
		}
		if($aDatos["idEmpresa"]!=""){
			$condicion.=" AND c.idEmpresa=".$aDatos["idEmpresa"]; 
		}

		// if($aDatos["estado"]!=""){
		// 	$condicion.=" AND p.estado=".$aDatos["estado"]; 
		// }
		$sql="SELECT *
			FROM comprobante as c
			INNER JOIN comprobante_items as ci  ON(c.idComprobante=ci.idComprobante)
			INNER JOIN cuenta_contable  as cc  ON(cc.idCuentaContable=ci.idCuentaContable)
			WHERE 0=0 ".$condicion." GROUP BY ci.idCuentaContable ORDER BY cc.codigoCuenta ASC";

	    $aProveedores=$this->ejecutarSql($sql); 
	    return $aProveedores; 
	}





	public function getTerceroDetalladoCuenta($aDatos=array()){



		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }
		if($_SESSION["idRol"]==1 || $_SESSION["idRol"]==2 || $_SESSION["idRol"]==5){
			$condicion=" AND cc.idEmpresa=".$aDatos["idEmpresa"]; 
		}
		
		if($_SESSION["idRol"]==3){
			$condicion=" AND cc.idEmpresa=".$_SESSION["idEmpresa"]; 
		}
		if($aDatos["desde"]!=""){ 

			$condicion.=" AND ccm.fecha>='".$aDatos["desde"]."'";

		}
		if($aDatos["hasta"]!=""){ 

			$condicion.=" AND ccm.fecha <='".$aDatos["hasta"]."'";

		}
		if($aDatos["cuenta"]!=""){ 

			$condicion.=" AND substring(cc.codigoCuenta,1,10) ='".$aDatos["cuenta"]."'";

		}
		
		

		$sql="SELECT substring(cc.codigoCuenta,1,10) as codigoCuenta,cc.nombre,cc.idEmpresa,sum(ccm.saldoDebito) as debito,sum(ccm.saldoCredito) as credito,MAX(ccm.fecha) as fecha,cc.naturaleza,ccm.tipoTercero,ccm.idTercero,ccm.idComprobante
			FROM cuenta_contable cc
			
			INNER JOIN comprobante_items ccm on ccm.idCuentaContable=cc.idCuentaContable
			INNER JOIN tercero t on ccm.idTercero = t.idTercero
			WHERE 0=0  ".$condicion."
			GROUP BY substring(cc.codigoCuenta,1,10),ccm.idTercero
			ORDER BY t.nit ASC,cc.codigoCuenta ASC";


	    $aBalanceComprobacion=$this->ejecutarSql($sql); 

	    return $aBalanceComprobacion; 

	}



	public function getExogena1001($aDatos=array()){



		// $condicion=""; 

		// if(!isset($_SESSION)){ session_start(); }

		// if($aDatos["idEmpresa"]!=""){
		// 	$condicion=" AND c.idEmpresa=".$aDatos["idEmpresa"]; 
		// }
		
		// if($aDatos["cuenta"]!=""){ 

		// 	$condicion.=" AND ci.idCuentaContable ='".$aDatos["cuenta"]."'";
		// }
		// if($aDatos["desde"]!=""){ 

		// 	$condicion.=" AND ci.fecha >='".$aDatos["desde"]."'";
		// }

		// if($aDatos["hasta"]!=""){ 

		// 	$condicion.=" AND ci.fecha <='".$aDatos["hasta"]."'";
		// }

		
		// $sql="SELECT c.idEmpresa,sum(ci.saldoDebito) as debito,sum(ci.saldoCredito) as credito,ci.idTercero,cc.codigoCuenta
		// 	FROM comprobante_items ci	
		// 	INNER JOIN comprobante c on c.idComprobante=ci.idComprobante	
		// 	INNER JOIN tercero t on ci.idTercero = t.idTercero
		// 	INNER JOIN cuenta_contable cc on cc.idCuentaContable = ci.idCuentaContable
		// 	INNER JOIN exogena ex on ex.idCuentaContable = ci.idCuentaContable
		// 	WHERE 0=0 ".$condicion."
		// 	GROUP BY ci.idTercero,ex.idConcepto,ci.idCuentaContable
		// 	ORDER BY t.nit ASC";


	 //    $exogena=$this->ejecutarSql($sql); 

	 //    return $exogena; 


		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }

		if($aDatos["idEmpresa"]!=""){
			$condicion=" AND c.idEmpresa=".$aDatos["idEmpresa"]; 
		}
		
		if($aDatos["cuenta"]!=""){ 

			$condicion.=" AND ci.idCuentaContable ='".$aDatos["cuenta"]."'";
		}
		if($aDatos["desde"]!=""){ 

			$condicion.=" AND ci.fecha >='".$aDatos["desde"]."'";
		}

		if($aDatos["hasta"]!=""){ 

			$condicion.=" AND ci.fecha <='".$aDatos["hasta"]."'";
		}


		if($aDatos["idFormato"]!=""){ 

			$condicion.=" AND ex.idFormato =".$aDatos["idFormato"];
		}


		if($aDatos["idTercero"]!=""){ 

			$condicion.=" AND ci.idTercero =".$aDatos["idTercero"];
		}

		if($aDatos["idConcepto"]!=""){ 

			$condicion.=" AND ex.idConcepto =".$aDatos["idConcepto"];
		}


		if($aDatos["idCategoria"]!=""){ 

			$condicion.=" AND ex.idCategoria =".$aDatos["idCategoria"];
		}

		
		$sql="SELECT c.idEmpresa,sum(ci.saldoDebito) as debito,sum(ci.saldoCredito) as credito,sum(ci.base) as base,ci.idTercero,ci.idCuentaContable,cc.codigoCuenta,ex.idConcepto,ex.idTipoSuma,ex.idFormato,ex.idCategoria
			FROM comprobante_items ci	
			INNER JOIN comprobante c on c.idComprobante=ci.idComprobante	
			INNER JOIN tercero t on ci.idTercero = t.idTercero
			INNER JOIN cuenta_contable cc on cc.idCuentaContable = ci.idCuentaContable
			INNER JOIN exogena ex on ex.idCuentaContable = ci.idCuentaContable
			WHERE 0=0 ".$condicion."
			GROUP BY ci.idTercero,ex.idConcepto,ex.idCategoria
			ORDER BY ex.idConcepto ASC,t.nit ASC";


	    $exogena=$this->ejecutarSql($sql); 

	    return $exogena; 

	}



	public function getExogena1003($aDatos=array()){



		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }

		if($aDatos["idEmpresa"]!=""){
			$condicion=" AND c.idEmpresa=".$aDatos["idEmpresa"]; 
		}
		
		if($aDatos["cuenta"]!=""){ 

			$condicion.=" AND ci.idCuentaContable ='".$aDatos["cuenta"]."'";
		}
		if($aDatos["desde"]!=""){ 

			$condicion.=" AND ci.fecha >='".$aDatos["desde"]."'";
		}

		if($aDatos["hasta"]!=""){ 

			$condicion.=" AND ci.fecha <='".$aDatos["hasta"]."'";
		}



		if($aDatos["idFormato"]!=""){ 

			$condicion.=" AND ex.idFormato =".$aDatos["idFormato"];
		}

		
		$sql="SELECT c.idEmpresa,sum(ci.saldoDebito) as debito,sum(ci.saldoCredito) as credito,sum(ci.base) as base,ci.idTercero,ci.idCuentaContable,cc.codigoCuenta,ex.idConcepto,ex.idTipoSuma,ex.idFormato
			FROM comprobante_items ci	
			INNER JOIN comprobante c on c.idComprobante=ci.idComprobante	
			INNER JOIN tercero t on ci.idTercero = t.idTercero
			INNER JOIN cuenta_contable cc on cc.idCuentaContable = ci.idCuentaContable
			INNER JOIN exogena ex on ex.idCuentaContable = ci.idCuentaContable
			WHERE 0=0 ".$condicion."
			GROUP BY ci.idTercero,ex.idConcepto,ci.idCuentaContable
			ORDER BY ex.idConcepto ASC,t.nit ASC";


	    $exogena=$this->ejecutarSql($sql); 

	    return $exogena; 

	}


	public function getExogena1005($aDatos=array()){



		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }

		if($aDatos["idEmpresa"]!=""){
			$condicion=" AND c.idEmpresa=".$aDatos["idEmpresa"]; 
		}
		
		if($aDatos["cuenta"]!=""){ 

			$condicion.=" AND ci.idCuentaContable ='".$aDatos["cuenta"]."'";
		}
		if($aDatos["desde"]!=""){ 

			$condicion.=" AND ci.fecha >='".$aDatos["desde"]."'";
		}

		if($aDatos["hasta"]!=""){ 

			$condicion.=" AND ci.fecha <='".$aDatos["hasta"]."'";
		}



		if($aDatos["idFormato"]!=""){ 

			$condicion.=" AND ex.idFormato =".$aDatos["idFormato"];
		}

		
		$sql="SELECT c.idEmpresa,sum(ci.saldoDebito) as debito,sum(ci.saldoCredito) as credito,sum(ci.base) as base,ci.idTercero,ci.idCuentaContable,cc.codigoCuenta,ex.idConcepto,ex.idTipoSuma,ex.idFormato,ex.idCategoria
			FROM comprobante_items ci	
			INNER JOIN comprobante c on c.idComprobante=ci.idComprobante	
			INNER JOIN tercero t on ci.idTercero = t.idTercero
			INNER JOIN cuenta_contable cc on cc.idCuentaContable = ci.idCuentaContable
			INNER JOIN exogena ex on ex.idCuentaContable = ci.idCuentaContable
			WHERE 0=0 ".$condicion."
			GROUP BY ci.idTercero,ex.idConcepto
			ORDER BY ex.idConcepto ASC,t.nit ASC";


	    $exogena=$this->ejecutarSql($sql); 

	    return $exogena; 

	}


	public function getExogena1012($aDatos=array()){



		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }

		if($aDatos["idEmpresa"]!=""){
			$condicion=" AND c.idEmpresa=".$aDatos["idEmpresa"]; 
		}
		
		if($aDatos["cuenta"]!=""){ 

			$condicion.=" AND ci.idCuentaContable ='".$aDatos["cuenta"]."'";
		}
		if($aDatos["desde"]!=""){ 

			$condicion.=" AND ci.fecha >='".$aDatos["desde"]."'";
		}

		if($aDatos["hasta"]!=""){ 

			$condicion.=" AND ci.fecha <='".$aDatos["hasta"]."'";
		}



		if($aDatos["idFormato"]!=""){ 

			$condicion.=" AND ex.idFormato =".$aDatos["idFormato"];
		}

		
		$sql="SELECT c.idEmpresa,sum(ci.saldoDebito) as debito,sum(ci.saldoCredito) as credito,sum(ci.base) as base,ci.idTercero,ci.idCuentaContable,cc.codigoCuenta,ex.idConcepto,ex.idTipoSuma,ex.idFormato,ex.idCategoria
			FROM comprobante_items ci	
			INNER JOIN comprobante c on c.idComprobante=ci.idComprobante	
			INNER JOIN tercero t on ci.idTercero = t.idTercero
			INNER JOIN cuenta_contable cc on cc.idCuentaContable = ci.idCuentaContable
			INNER JOIN exogena ex on ex.idCuentaContable = ci.idCuentaContable
			WHERE 0=0 ".$condicion."
			GROUP BY ci.idCuentaContable,ex.idConcepto
			ORDER BY ex.idConcepto ASC,t.nit ASC";


	    $exogena=$this->ejecutarSql($sql); 

	    return $exogena; 

	}


	public function getExogena2276($aDatos=array()){



		$condicion=""; 

		if(!isset($_SESSION)){ session_start(); }

		if($aDatos["idEmpresa"]!=""){
			$condicion=" AND c.idEmpresa=".$aDatos["idEmpresa"]; 
		}
		
		if($aDatos["cuenta"]!=""){ 

			$condicion.=" AND ci.idCuentaContable ='".$aDatos["cuenta"]."'";
		}
		if($aDatos["desde"]!=""){ 

			$condicion.=" AND ci.fecha >='".$aDatos["desde"]."'";
		}

		if($aDatos["hasta"]!=""){ 

			$condicion.=" AND ci.fecha <='".$aDatos["hasta"]."'";
		}



		if($aDatos["idFormato"]!=""){ 

			$condicion.=" AND ex.idFormato =".$aDatos["idFormato"];
		}

		
		$sql="SELECT c.idEmpresa,sum(ci.saldoDebito) as debito,sum(ci.saldoCredito) as credito,sum(ci.base) as base,ci.idTercero,ci.idCuentaContable,cc.codigoCuenta,ex.idConcepto,ex.idTipoSuma,ex.idFormato,ex.idCategoria
			FROM comprobante_items ci	
			INNER JOIN comprobante c on c.idComprobante=ci.idComprobante	
			INNER JOIN tercero t on ci.idTercero = t.idTercero
			INNER JOIN cuenta_contable cc on cc.idCuentaContable = ci.idCuentaContable
			INNER JOIN exogena ex on ex.idCuentaContable = ci.idCuentaContable
			WHERE 0=0 ".$condicion."
			GROUP BY ci.idTercero,ex.idCategoria,ex.idConcepto
			ORDER BY ex.idConcepto ASC,t.nit ASC";


	    $exogena=$this->ejecutarSql($sql); 

	    return $exogena; 

	}

}

?>