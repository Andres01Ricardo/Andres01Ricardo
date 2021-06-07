<?php
require_once("../../php/restrict.php");

require_once("../../class/cuentasbancarias.php");

date_default_timezone_set("America/Bogota"); 

$idCuentaBancaria  = (isset($_REQUEST['idCuentaBancaria'] ) ? $_REQUEST['idCuentaBancaria'] : "" );
$fechaInicio  = (isset($_REQUEST['fechaInicio'] ) ? $_REQUEST['fechaInicio'] : "" );
$fechaFin  = (isset($_REQUEST['fechaFin'] ) ? $_REQUEST['fechaFin'] : "" );

$oCuentasBancarias=new CuentasBancarias(); 

$aFiltro["idCuentaBancaria"]=$idCuentaBancaria; 
$aFiltro["fechaInicio"]=$fechaInicio; 
$aFiltro["fechaFin"]=$fechaFin; 

$aMovimientos=$oCuentasBancarias->getMovimientosCuentaBancaria($aFiltro); 

foreach($aMovimientos as $index => $iMovimiento){ 
	$valor=$iMovimiento["valorIngreso"]; 
	if($iMovimiento["valorEgreso"]>0){
	  $valor=$iMovimiento["valorEgreso"]*-1; 
	}
	$aMovimientos[$index]["movimiento"]="$".number_format($valor,0,".",","); 
	$aMovimientos[$index]["saldoActual"]="$".number_format($iMovimiento["saldoActual"],0,".",","); 
	$aMovimientos[$index]["saldoAnterior"]="$".number_format($iMovimiento["saldoAnterior"],0,".",","); 
}
echo json_encode($aMovimientos); 
?>
