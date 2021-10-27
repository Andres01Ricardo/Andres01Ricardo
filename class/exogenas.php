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
			WHERE 0=0 ".$condicion." GROUP BY ci.idCuentaContable ";

	    $aProveedores=$this->ejecutarSql($sql); 
	    return $aProveedores; 
	}


}

?>