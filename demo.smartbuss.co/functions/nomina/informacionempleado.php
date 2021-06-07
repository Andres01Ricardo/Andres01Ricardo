<?php
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");
require_once("../../class/empleados.php"); 

$oEmpleado=new Empleados();  
date_default_timezone_set("America/Bogota"); 

$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );
$idPeriodo  = (isset($_REQUEST['idPeriodo'] ) ? $_REQUEST['idPeriodo'] : "" );
$idEmpleado  = (isset($_REQUEST['idEmpleado'] ) ? $_REQUEST['idEmpleado'] : "" );
$tiempo  = (isset($_REQUEST['tiempo'] ) ? $_REQUEST['tiempo'] : "" );


$aNivel[1]="Nivel I"; 
$aNivel[2]="Nivel II"; 
$aNivel[3]="Nivel III"; 
$aNivel[4]="Nivel IV"; 
$aNivel[5]="Nivel V"; 

$aPeriodo=explode("-", $idPeriodo); 
$oLista = new Lista('empleado_informacion_laboral');
$oLista->setFiltro("idEmpleado","=",$idEmpleado);
$oLista->setFiltro("idEmpresa","=",$idEmpresa);
$lista=$oLista->getLista();

$salario=$lista[0]["valorSalario"]; 
$riesgo=$lista[0]["riesgoLaboral"];

$oLista = new Lista('empresa_novedad');
$oLista->setFiltro("idEmpleado","=",$idEmpleado);
$oLista->setFiltro("idEmpresa","=",$idEmpresa);
$lista=$oLista->getLista();
unset($oLista); 

$oItem = new Data('salario_minimo',"anio", $aPeriodo[1]);
$aSalario=$oItem->getDatos();
unset($oItem);


//$cantidadSalarios=intdiv($salario,$aSalario["salarioMensual"]);


$oItem = new Data('empresa',"idEmpresa", $idEmpresa);
$sEmpresa=$oItem->getDatos();
unset($oItem);

if($sEmpresa["periodoPago"]==1){
$diasPago=30; 
$cantidadHora=240; 
}else{
$diasPago=15; 
$cantidadHora=120; 
}
$valorHora=$salario/$cantidadHora;
$oItem = new Data('aportes_parafiscales',"anio", $aPeriodo[1]);
$aLey=$oItem->getDatos();
unset($oItem);

if($lista[0]["tipoContrato"]!=2){
	$aDeduccionesley[0]["valor"]=($aLey["saludEmpleado"]/100)*$salario;
	$aDeduccionesley[0]["descripcion"]="Salud ".$aLey["saludEmpleado"]."%";
	$aDeduccionesley[0]["tipo"]=1; 
	$aDeduccionesley[0]["oculto"]=0; 
	$aDeduccionesley[0]["concepto"]=1; 

	$aDeduccionesley[1]["valor"]=($aLey["pensionEmpleado"]/100)*$salario;
	$aDeduccionesley[1]["descripcion"]="Pension ".$aLey["pensionEmpleado"]."%";
	$aDeduccionesley[1]["tipo"]=1; 
	$aDeduccionesley[1]["oculto"]=0; 
	$aDeduccionesley[1]["concepto"]=2; 

	$aDeduccionesley[2]["valor"]=($aLey["riesgo".$riesgo]/100)*$salario;
	$aDeduccionesley[2]["descripcion"]="ARL (".$aNivel[$riesgo].") ".$aLey["riesgo".$riesgo]."%";
	$aDeduccionesley[2]["tipo"]=1; 
	$aDeduccionesley[2]["oculto"]=1; 
	$aDeduccionesley[2]["concepto"]=3; 

	$aDeduccionesley[3]["valor"]=($aLey["cajaCompensacion"]/100)*$salario;
	$aDeduccionesley[3]["descripcion"]="Caja Compensación ".$aLey["cajaCompensacion"]."%";
	$aDeduccionesley[3]["tipo"]=1; 
	$aDeduccionesley[3]["oculto"]=1; 
	$aDeduccionesley[3]["concepto"]=4; 

	$aDeduccionesley[4]["valor"]=($aLey["saludEmpleador"]/100)*$salario;
	$aDeduccionesley[4]["descripcion"]="Salud ".$aLey["saludEmpleador"]."%";
	$aDeduccionesley[4]["tipo"]=1; 
	$aDeduccionesley[4]["oculto"]=1; 
	$aDeduccionesley[4]["concepto"]=1; 

	$aDeduccionesley[5]["valor"]=($aLey["pensionEmpleador"]/100)*$salario;
	$aDeduccionesley[5]["descripcion"]="Pension ".$aLey["pensionEmpleador"]."%";
	$aDeduccionesley[5]["tipo"]=1; 
	$aDeduccionesley[5]["oculto"]=1; 
	$aDeduccionesley[5]["concepto"]=2; 
}



$oItem = new Data('horas_extras',"anio", $aPeriodo[1]);
$aExtras=$oItem->getDatos();
unset($oItem);

$fecha=$aPeriodo[1]."-".str_pad($aPeriodo[0], 2, "0", STR_PAD_LEFT); 

$aPeriodo[0]=str_pad($aPeriodo[0], 2, "0", STR_PAD_LEFT); 
foreach ($lista as $key => $value) {
	switch ($value["idNovedades"]) {
		case 1:
			$oLista = new Lista('empresa_descuento_empleado');
			$oLista->setFiltro("idEmpresaNovedad","=",$value["idEmpresaNovedad"]);
			$aDescuento=$oLista->getLista();
			unset($oLista); 

			foreach ($aDescuento as $iDescuento) {
				$oLista = new Lista('empresa_descuento_empleado_cuota');
				$oLista->setFiltro("idEmpresaDescuentoEmpleado","=",$iDescuento["idEmpresaDescuentoEmpleado"]);
				$oLista->setFiltro("fechaDescuento","LIKE",$fecha);
				$aCuota=$oLista->getLista()[0];
				unset($oLista); 

				$aItem["idTipo"]=$value["idNovedades"]; 
				$aItem["texto"]="Cuota de descuento '".$iDescuento["descripcion"]."'"; 
				$aItem["id"]=$aCuota["idEmpresaDescuentoEmpleadoCuota"]; 
				$aItem["valor"]=$aCuota["valorCuota"]; 
				if($aCuota["valorCuota"]!=""){
					$aDescuentos[]=$aItem; 	
				}
				
			}
		break;
		case 2:
			//codigo por preguntar
		break;
		case 3:
			$oLista = new Lista('empleado_horas_extras');
			$oLista->setFiltro("idEmpresaNovedad","=",$value["idEmpresaNovedad"]);
			$oLista->setFiltro("fechaHoraExtra","LIKE",$fecha);
			$aHoras=$oLista->getLista();
			unset($oLista);
			if(count($aHoras)>0){
				foreach ($aHoras as $iHora) {
				 	$hDiurna+=$iHora["horaDiurna"]; 
				 	$hNocturna+=$iHora["horaNocturna"]; 
				 	$dDiurna+=$iHora["horaDiurnaDominical"]; 
				 	$dNocturna+=$iHora["horaNocturnaDominical"]; 
				 } 
				 
				 if($hDiurna>0){
				 	$valorD=$valorHora*$hDiurna*(1+($aExtras["diurna"]/100));
				 	$texto[]="Extras Diurnas: ".$hDiurna; 
				 }
				 if($hNocturna>0){
				 	$valorN=$valorHora*$hNocturna*(1+($aExtras["nocturna"]/100)); 
				 	$texto[]="Extras Nocturnas: ".$hNocturna;
				 }
				 if($dDiurna>0){
				 	$valordD=$valorHora*$dDiurna*(1+($aExtras["diurnaDominical"]/100)); 
				 	$texto[]="Extras Diurnas Dominical: ".$dDiurna;
				 }
				 if($dNocturna>0){
				 	$valordN=$valorHora*$dNocturna*(1+($aExtras["nocturnaDominical"]/100)); 
				 	$texto[]="Extras Nocturnas Dominical: ".$dNocturna;
				 }
				 
				$aItem["idTipo"]=$value["idNovedades"]; 
				$aItem["texto"]="Horas Extras (".implode(",",$texto).")"; 
				$aItem["valor"]=$valorD+$valorN+$valordD+$valordN;
				$aAdiciones[]=$aItem; 
			}
			
		break;
		case 7:
			$oLista = new Lista('empleado_auxilios_extralegales');
			$oLista->setFiltro("idEmpresaNovedad","=",$value["idEmpresaNovedad"]);
			$aAux=$oLista->getLista();
			unset($oLista);
			if(count($aAux)>0){
				foreach ($aAux as $iAux) {

					$oItem = new Data('auxilio_extralegal',"idAuxilioExtralegal", $iAux["idAuxilioExtralegal"]);
					$auxilio=$oItem->getDatos();
					unset($oItem);
					$otro=""; 
					if($iAux["otroAuxilio"]!="NULL"){
						$otro="(".$iAux["otroAuxilio"].")"; 
					}
				 	$aItem["idTipo"]=$value["idNovedades"]; 
					$aItem["texto"]=$auxilio["nombre"].$otro; 
					$aItem["valor"]=$iAux["valorAuxilio"];
					$aAdiciones[]=$aItem; 
				 } 

				 
				
			}
			
		break;
		case 9:
			$oLista = new Lista('empleado_comision');
			$oLista->setFiltro("idEmpresaNovedad","=",$value["idEmpresaNovedad"]);
			$oLista->setFiltro("mes","=",$aPeriodo[0]);
			$oLista->setFiltro("anio","=",$aPeriodo[1]);
			$aComision=$oLista->getLista();
			unset($oLista);
			if(count($aComision)>0){
				foreach ($aComision as $iComision) {

					$oItem = new Data('auxilio_extralegal',"idAuxilioExtralegal", $iAux["idAuxilioExtralegal"]);
					$auxilio=$oItem->getDatos();
					unset($oItem);

				 	$aItem["idTipo"]=$value["idNovedades"]; 
					$aItem["texto"]=$iComision["descripcion"]; 
					$aItem["valor"]=$iComision["valorComision"];
					$aAdiciones[]=$aItem; 
				 } 

			}
			
		break;
		default:
			# code...
			break;
	}
}

$aArray=array(
	"valorSalario"=>$salario,
	"nivelRiesgo"=>$aNivel[$riesgo],
	"deducciones"=>$aDescuentos,
	"deduccionesLey"=>$aDeduccionesley,
	"adiciones"=>$aAdiciones,
	"diasPago"=>$diasPago,
); 
echo json_encode($aArray);


?>