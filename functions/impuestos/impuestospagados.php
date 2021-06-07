<?php
require_once($CLASS."sql.php"); 

class Impuestos extends Sql{
	
	public function getImpuestosPagados($empresa){


		$sql="SELECT ip.nombreCuenta,ip.valor,ip.fechaRegistro,bg.periodoMes,bg.periodoAnio,bg.subtitulo,bg.idEmpresa,ip.sanciones,ip.intereses
			from impuesto_pagado ip
			inner join balance_general bg on bg.idBalanceGeneral=ip.idBalanceGeneral
			WHERE bg.idEmpresa=$empresa
			ORDER BY ip.idImpuestoPagado desc";

	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}	


	public function getImpuestosPagadosFiltro($empresa,$mesdesde,$meshasta,$impuesto){

		$sql="SELECT ip.nombreCuenta,ip.valor,ip.fechaRegistro,bg.periodoMes,bg.periodoAnio,bg.subtitulo,bg.idEmpresa,ip.sanciones,ip.intereses
			from impuesto_pagado ip
			inner join balance_general bg on bg.idBalanceGeneral=ip.idBalanceGeneral
			WHERE bg.idEmpresa=$empresa and bg.periodoMes>=$mesdesde and bg.periodoMes <= $meshasta and numeroCuenta=$impuesto
			ORDER BY ip.idImpuestoPagado desc";

	    $aArray=$this->ejecutarSql($sql); 
	    return $aArray; 
	}
}
?>