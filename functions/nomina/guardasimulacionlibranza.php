<?php
require_once("../../php/restrict.php");
include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 


if(!isset($_SESSION)){ session_start(); }

$idEmpleado=$_POST['idEmpleado'];
$cuotas=$_POST['cuotas'];
$valorCredito=$_POST['valorCredito'];
$valorCreditoInicial=$_POST['valorCredito'];
$tasaInteres=$_POST['tasaInteres'];
$hoy=date("Y-m-d");
$mes=date("m");
$porcentajeTasaInteres= $tasaInteres/100;
$valorCuota = ($valorCredito*(($porcentajeTasaInteres)*(pow(1+$porcentajeTasaInteres,$cuotas))))/((pow(1+$porcentajeTasaInteres,$cuotas))-1);
$valorCuota2=round($valorCuota);
$montoTotalPagar=$valorCuota2*$cuotas;
$totalInteresesPagar = $montoTotalPagar - $valorCredito;

$aDatos["plazo"]=$cuotas;
$aDatos["tasaInteres"]=$tasaInteres;
$aDatos["estadoSolicitud"]='pendiente';
$aDatos["cuota"]=$valorCuota2;
$aDatos["valorSolicitado"]=$valorCredito;
$aDatos["montoTotal"]=$montoTotalPagar;
$aDatos["idEmpleado"]=$idEmpleado;
$aDatos["autorizacionLibranza"]='pendiente';
$aDatos["totalIntereses"]=$totalInteresesPagar;
$aDatos["valorDesembolso"]=$valorCredito;
$aDatos["fechaRegistro"]=$hoy;
$aDatos["idEmpresa"]=$_SESSION['idEmpresa'];

$oItem=new Data("libranza","idLibranza"); 
    foreach($aDatos  as $key => $value){
        $oItem->$key=$value; 
    }
    $oItem->guardar(); 
    $idLibranza=$oItem->ultimoId(); 
    unset($oItem);

$deudaInicial=$valorCredito;
for ($i = 1; $i <= $cuotas; $i++) {
  
$deudaInicial=round($deudaInicial);
$pagoIntereses=$deudaInicial*$porcentajeTasaInteres;
$pagoCapital=$valorCuota-$pagoIntereses;

$pagoIntereses=round($pagoIntereses);
$pagoCapital=round($pagoCapital);

$bDatos['idLibranza']=$idLibranza;
$bDatos['cuotaNumero']=$i;
$bDatos['deudaInicial']=$deudaInicial;
$bDatos['pagoIntereses']=$pagoIntereses;
$bDatos['pagoCapital']=$pagoCapital;
$bDatos['valorCuota']=$valorCuota2;
$bDatos['valorPagadoCuota']=0;
$bDatos['fechaVencimientoCuota']='0000-00-00';
$bDatos['estadoCuota']='no aplica';
$bDatos['comprobantePago']=0;



$oItem=new Data("libranza_item","idLibranzaItem"); 
    foreach($bDatos  as $keyi => $valuei){
        $oItem->$keyi=$valuei; 
    }
    $oItem->guardar();  
    unset($oItem);

    $deudaInicial=$deudaInicial-$pagoCapital;

}

// $msg=true; 
// echo json_encode(array("msg"=>$msg,"id"=>$idEmpleado,"valorCuota"=>$valorCuota2,"valorCredito"=>$valorCreditoInicial));
  header("location: ../../cuotaaceptada/$idLibranza");

?>
