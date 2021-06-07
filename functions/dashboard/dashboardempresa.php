<?php
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");
require_once("../../class/empresa.php"); 

$oEmpresa=new Empresa(); 
date_default_timezone_set("America/Bogota"); 

$meses[1]="Enero"; 
$meses[2]="Febrero"; 
$meses[3]="Marzo"; 
$meses[4]="Abril"; 
$meses[5]="Mayo"; 
$meses[6]="Junio"; 
$meses[7]="Julio"; 
$meses[8]="Agosto"; 
$meses[9]="Septiembre"; 
$meses[10]="Octubre"; 
$meses[11]="Noviembre"; 
$meses[12]="Diciembre"; 

if(!isset($_SESSION)){ session_start(); }
$idEmpresa=$_SESSION["idEmpresa"]; 

$aUltimoPeriodo=$oEmpresa->getRentabilidad(array("idEmpresa"=>$idEmpresa,"orden"=>1))[0];

for ($i=12; $i > 0; $i--) { 
	$nuevafecha = strtotime ( '-'.$i.' Months' , strtotime ( date('Y-m') ) ) ;
	$nuevafecha = date ( 'Y-m' , $nuevafecha );

	$fecha=explode("-", $nuevafecha); 
	$aRenta=$oEmpresa->getRentabilidad(array("idEmpresa"=>$idEmpresa,"anio"=>$fecha[0],"mes"=>$fecha[1]))[0];
	$aIngresos=$oEmpresa->getIngresos(array("idEmpresa"=>$idEmpresa,"anio"=>$fecha[0],"mes"=>$fecha[1]))[0];
	$aGastos=$oEmpresa->getGastos(array("idEmpresa"=>$idEmpresa,"anio"=>$fecha[0],"mes"=>$fecha[1]))[0];
	if(!empty($aIngresos) and $aIngresos["valor"]!=null){
		$aIngresos["periodo"]=$meses[(int)$fecha[1]]." de ".$fecha[0];
		$ingresos[]=$aIngresos;
	}
	if(!empty($aGastos and $aGastos["valor"]!=null)){
		$aGastos["periodo"]=$meses[(int)$fecha[1]]." de ".$fecha[0];
		$gastos[]=$aGastos;
	}
	if(!empty($aRenta)){
		$aRenta["periodo"]=$meses[(int)$fecha[1]]." de ".$fecha[0]; 
		$aItem[]=$aRenta; 
	}
	$aSituacion=$oEmpresa->getSituacionFinanciera(array("idEmpresa"=>$idEmpresa,"anio"=>$fecha[0],"mes"=>$fecha[1]));
	if(!empty($aSituacion)){
		$iSituacion["periodo"]=substr($meses[(int)$fecha[1]],0,4)." de ".$fecha[0];
		foreach ($aSituacion as $key => $value) {
			if($value["tipo"]==1){
				$iSituacion["activo"]=$value["total"]/1000000; 
			}elseif($value["tipo"]==2){
				$iSituacion["pasivo"]=$value["total"]/1000000; 
			}else{
				$iSituacion["patrimonio"]=$value["total"]/1000000; 
			}
		}

		$listaSituacion[]=$iSituacion; 
	}
	
}

for ($i=1; $i <= date("n"); $i++) {

	// $nuevafecha = strtotime ( '+'.$i.' Months' , strtotime ( date('Y-m') ) ) ;
	// $nuevafecha = date ( 'Y-m' , $nuevafecha );

	$oLista=new Lista("factura_compra"); 
	$oLista->setFiltro("fechaPago","LIKE",date("Y")."-".str_pad($i, 2, "0", STR_PAD_LEFT)); 
	$oLista->setFiltro("idEmpresa","=",$idEmpresa); 
	$oLista->setFiltro("estado","!=",3); 
	$aLista=$oLista->getLista(); 
	unset($oItem);

	$valorC=0;
	foreach ($aLista as $key => $value) {
		$valorC+=$value["subtotal"]; 
	}

	$oLista=new Lista("factura_venta"); 
	$oLista->setFiltro("fechaFactura","LIKE",date("Y")."-".str_pad($i, 2, "0", STR_PAD_LEFT)); 
	$oLista->setFiltro("idEmpresa","=",$idEmpresa); 
	$aLista2=$oLista->getLista(); 
	unset($oItem);

	$valorV=0;
	foreach ($aLista2 as $key => $value) {
		$valorV+=$value["subtotal"]; 
	}

	$iFact["periodo"]=substr($meses[$i],0,3);
	$iFact["compra"]=$valorC;
	$iFact["venta"]=$valorV;
	$aFacturacion[]=$iFact; 
}

$fechaIndicador[0]=$aUltimoPeriodo["periodoAnio"];
$fechaIndicador[1]=$aUltimoPeriodo["periodoMes"];
// $nuevafecha = strtotime ( '-1 Months' , strtotime ( date('Y-m') ) ) ;
// $fechaIndicador = date ( 'Y-n' , $nuevafecha );
// $fechaIndicador=explode("-",$fechaIndicador); 
$aIndicador=$oEmpresa->getSituacionFinanciera(array("idEmpresa"=>$idEmpresa,"anio"=>$fechaIndicador[0],"mes"=>$fechaIndicador[1]));

$activo=0; 
$pasivo=0; 
$patrimonio=0; 

if(!empty($aIndicador)){
	foreach ($aIndicador as $key => $value) {
		if($value["tipo"]==1){
			$activo=$value["total"]; 
		}elseif($value["tipo"]==2){
			$pasivo=$value["total"]; 
		}else{
			$patrimonio=$value["total"]; 
		}
	}
$nivelEndeudamiento=round(($pasivo*100)/$activo); 
}


 $totalActivoCorriente=$oEmpresa->getCuentaSituacionFinanciera(array("idEmpresa"=>$idEmpresa,"anio"=>$fechaIndicador[0],"mes"=>$fechaIndicador[1],"cuenta"=>'TOTAL ACTIVO CORRIENTE'))[0];
 $totalPasivoCorriente=$oEmpresa->getCuentaSituacionFinanciera(array("idEmpresa"=>$idEmpresa,"anio"=>$fechaIndicador[0],"mes"=>$fechaIndicador[1],"cuenta"=>'TOTAL PASIVO CORRIENTE'))[0];
 $totalPatrimonio=$oEmpresa->getCuentaSituacionFinanciera(array("idEmpresa"=>$idEmpresa,"anio"=>$fechaIndicador[0],"mes"=>$fechaIndicador[1],"cuenta"=>'TOTAL PATRIMONIO'))[0];
  $totalActivo=$oEmpresa->getCuentaSituacionFinanciera(array("idEmpresa"=>$idEmpresa,"anio"=>$fechaIndicador[0],"mes"=>$fechaIndicador[1],"cuenta"=>'TOTAL ACTIVO'))[0];


 $utilidadOperacional=$oEmpresa->getRentabilidadCuenta(array("idEmpresa"=>$idEmpresa,"anio"=>$fechaIndicador[0],"mes"=>$fechaIndicador[1],"cuenta"=>'UTILIDAD OPERACIONAL'))[0];


$indiceLiquidez=$totalActivoCorriente["total"]/$totalPasivoCorriente["total"]; 
$capitalTrabajo=$totalActivoCorriente["total"]-$totalPasivoCorriente["total"]; 

$rentabilidadPatrimonio=$utilidadOperacional["valor"]/$totalPatrimonio["total"]; 
$rentabilidadActivo=$totalActivo["total"]/$totalPatrimonio["total"]; 
$vSolidez=$activo/$pasivo; 

$listIndicador["nivelEndeudamiento"]=$nivelEndeudamiento;
$listIndicador["solidez"]=$vSolidez; 
$listIndicador["indiceLiquidez"]=$indiceLiquidez;
$listIndicador["rentabilidadPatrimonio"]=$rentabilidadPatrimonio;
$listIndicador["rentabilidadActivo"]=$rentabilidadActivo;
$listIndicador["capitalTrabajo"]="$".number_format($capitalTrabajo,0,",","."); 

echo json_encode(array("rentabilidad"=>$aItem,"situacion"=>$listaSituacion,"facturacion"=>$aFacturacion,"indicador"=>$listIndicador,"ingresos"=>$ingresos,"gastos"=>$gastos));

?>