<?php
require_once($CLASS."sql.php"); 

class Empresa extends Sql{
	
	public function getEmpresas($aDatos=array()){

		$condicion=""; 
		if(!isset($_SESSION)){ session_start(); }
		if($_SESSION["idRol"]==2){
			$condicion=" AND ue.idUsuario=".$_SESSION["idUsuario"]; 
		}
		$sql="SELECT e.idEmpresa, e.razonSocial, e.periodoPago, e.nit, e.digitoVerificador, e.telefono, 
				e.direccion, c.nombre as ciudad, d.nombre as departamento, 
				e.tipoPersona, e.email, e.estado
			  FROM empresa as e 
			  INNER JOIN ciudad as c ON(c.idCiudad=e.idCiudad)
              INNER JOIN departamento as d ON(d.idDepartamento=e.idDepartamento)
			  LEFT JOIN usuario_empresa as ue ON(ue.idEmpresa=e.idEmpresa)
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
		if($aDatos["orden"]==1){
			$orden=" DESC"; 
		}else{
			$orden=" ASC"; 
		}
		$sql="SELECT e.idEstadoFinanciero, e.periodoMes, e.periodoAnio, ei.valor 
				FROM estado_financiero as e 
				INNER JOIN estado_financiero_item as ei ON(e.idEstadoFinanciero=ei.idEstadoFinanciero AND ei.tipo=1)
				WHERE 0=0 ".$condicion." ORDER BY periodoAnio,periodoMes ".$orden;

	    $aReturn=$this->ejecutarSql($sql); 
	    return $aReturn; 
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
		if($aDatos["idEstadoFinanciero"]!=""){
			$condicion.=" AND e.idEstadoFinanciero=".$aDatos["idEstadoFinanciero"]; 
		}

		if($aDatos["orden"]==1){
			$orden=" DESC"; 
		}else{
			$orden=" ASC"; 
		}
		$sql="SELECT e.periodoMes, e.periodoAnio, ei.valor, ei.porcentaje, ei.cuenta 
				FROM estado_financiero as e 
				INNER JOIN estado_financiero_item as ei ON(e.idEstadoFinanciero=ei.idEstadoFinanciero)
				WHERE 0=0 ".$condicion." ORDER BY periodoAnio,periodoMes ".$orden;

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
			IF(bi.titulo LIKE 'TOTAL ACTIVO',1,IF(bi.titulo LIKE 'TOTAL PASIVO',2,3)) as tipo, b.idBalanceGeneral 
			FROM balance_general as b
			INNER JOIN balance_general_item as bi ON(bi.idBalanceGeneral=b.idBalanceGeneral)
			WHERE 0=0 ".$condicion." AND 
			(bi.titulo LIKE 'TOTAL ACTIVO' OR bi.titulo LIKE 'TOTAL PASIVO' OR bi.titulo LIKE 'TOTAL PATRIMONIO') 
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
		if($aDatos["idBalanceGeneral"]!=""){
			$condicion.=" AND b.idBalanceGeneral=".$aDatos["idBalanceGeneral"]; 
		}
		if($aDatos["tipo"]!=""){
			$condicion.=" AND bi.tipo=".$aDatos["tipo"]; 
		}
		$sql="SELECT b.periodoMes, b.periodoAnio, bi.titulo, bi.total, bi.porcentaje 
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
		if($aDatos["idBalanceGeneral"]!=""){
			$condicion.=" AND b.idBalanceGeneral=".$aDatos["idBalanceGeneral"]; 
		}
		if($aDatos["tipo"]!=""){
			$condicion.=" AND bgc.tipo=".$aDatos["tipo"]; 
		}
		$sql="SELECT b.idBalanceGeneral, bgc.numeroCuenta, bgc.nombreCuenta, bgc.valor, bgc.porcentaje
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