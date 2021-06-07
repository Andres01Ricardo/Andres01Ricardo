<?php

require_once($CLASS."sql.php"); 



class CuentasBancarias extends Sql{

	

	public function getCuentas($aDatos=Array()){



		$condicion=""; 

		if($aDatos["idEmpresa"]!=""){

			$condicion.=" AND e.idEmpresa=".$aDatos["idEmpresa"]; 

		}

		if($aDatos["idUsuario"]!=""){

			$condicion.=" AND ue.idUsuario=".$aDatos["idUsuario"]; 

		}

				

		$sql="SELECT cb.idCuentaBancaria, b.nombre as banco, cb.nombreCuenta, cb.saldoActual, 

				cb.numeroCuenta, e.razonSocial 

				FROM cuenta_bancaria as cb 

				LEFT JOIN bancos as b ON(b.idBancos=cb.idBanco)

				INNER JOIN empresa as e ON(e.idEmpresa=cb.idEmpresa)

				LEFT JOIN usuario_empresa as ue ON(ue.idEmpresa=e.idEmpresa) 

				WHERE 0=0 ".$condicion." GROUP BY cb.idCuentaBancaria";

		

	    $aArray=$this->ejecutarSql($sql); 

	    return $aArray; 

	}



	public function getMovimientosCuentaBancaria($aDatos=Array()){



		$condicion=""; 

		if($aDatos["idCuentaBancaria"]!=""){

			$condicion.=" AND cbm.idCuentaBancaria=".$aDatos["idCuentaBancaria"]; 

		}

		if($aDatos["fechaInicio"]!=""&&$aDatos["fechaFin"]!=""){

			$condicion.=" AND DATE(cbm.fechaRegistro) BETWEEN '".$aDatos["fechaInicio"]."' AND '".$aDatos["fechaFin"]."'"; 

		}		

		$sql="SELECT cbm.idCuentaBancariaMovimientos, cbm.idTipoMovimiento, tp.nombre as tipoMovimiento, cbm.fechaRegistro,

			cbm.valorIngreso, cbm.valorEgreso, cbm.saldoAnterior, cbm.saldoActual, cbm.descripcionMovimiento

			FROM cuenta_bancaria_movimientos as cbm 

			INNER JOIN tipo_movimiento as tp ON(tp.idTipoMovimiento=cbm.idTipoMovimiento)

			WHERE 0=0 ".$condicion." ORDER BY cbm.fechaRegistro DESC";

		

	    $aArray=$this->ejecutarSql($sql); 

	    return $aArray; 

	}

}

?>