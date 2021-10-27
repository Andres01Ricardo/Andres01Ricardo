<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");
include_once($CLASS . "control.php");

$oControl=new Control();

date_default_timezone_set("America/Bogota"); 

// $idNomina  = (isset($_REQUEST['idNomina'] ) ? $_REQUEST['idNomina'] : "" );

// $idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

if(!isset($_SESSION)){ session_start(); }


$aData["estado"]=2;
$oItem=new Data("nomina","idNomina",$datos['idNomina']); 
foreach ($aData as $key => $value) {
  $oItem->$key=$value; 
}
$oItem->guardar(); 
unset($oItem); 



$oItem=new Data("nomina","idNomina",$datos['idNomina']);
$nomina=$oItem->getDatos();
unset($oItem);
    
    

    $oItem=new Data("cuenta_bancaria","idCuentaBancaria",$datos["cuentaBancaria"]); 
    $cuentaDatos=$oItem->getDatos(); 
    unset($oItem);
    $idCuenta=$datos["cuentaBancaria"];

    $valorPago=floatval(str_replace(",", ".",str_replace("$", "", str_replace(".", "", $datos["valorNomina"]))));
    
        $saldoActual=$cuentaDatos["saldoActual"];
        $nuevoSaldo=$saldoActual - $valorPago;
        


        $oItem=new Data("tercero","idTercero",$fDatos["idCliente"]); 
        $clienteDatos=$oItem->getDatos(); 
        unset($oItem);


        $bDatos["idCuentaBancaria"]=$idCuenta;
        $bDatos["idTipoMovimiento"]=1;
        $bDatos["fechaRegistro"]=date("Y-m-d H:i:s");
        $bDatos["valorIngreso"]=0;
        $bDatos["valorEgreso"]=$valorPago;  
        $bDatos["saldoAnterior"]=$saldoActual;
        $bDatos["saldoActual"]=$nuevoSaldo;
        $bDatos["descripcionMovimiento"]='pago de nómina del mes '.$nomina["periodoMes"].'/'.$nomina["periodoAnio"]; 

        $oItem=new Data("cuenta_bancaria_movimientos","idCuentaBancariaMovimientos"); 
            foreach($bDatos  as $key => $value){
                $oItem->$key=$value; 
            }
            $oItem->guardar();            
            unset($oItem);

        $oItem=new Data("cuenta_bancaria","idCuentaBancaria",$idCuenta); 
        $oItem->saldoActual=$nuevoSaldo; 
        $oItem->guardar(); 
        unset($oItem);




        if ($cuentaDatos['aplicaCuatroMil']==1) {
            
            $valorcuatromil = $valorPago*4/1000;
            $nuevoSaldoActual = $nuevoSaldo - $valorcuatromil;
            $bDatos["idCuentaBancaria"]=$idCuenta;
            $bDatos["idTipoMovimiento"]=1;
            $bDatos["fechaRegistro"]=date("Y-m-d H:i:s");
            $bDatos["valorIngreso"]=0;
            $bDatos["valorEgreso"]=$valorcuatromil;  
            $bDatos["saldoAnterior"]=$nuevoSaldo;
            $bDatos["saldoActual"]=$nuevoSaldoActual;
            $bDatos["descripcionMovimiento"]='pago de 4xmil de la nómina del mes '.$nomina["periodoMes"].'/'.$nomina["periodoAnio"]; 

            $oItem=new Data("cuenta_bancaria_movimientos","idCuentaBancariaMovimientos"); 
            foreach($bDatos  as $key => $value){
                $oItem->$key=$value; 
            }
            $oItem->guardar(); 
             
            unset($oItem);

            $nuevoSaldo = $nuevoSaldoActual;



            $oItem=new Data("cuenta_bancaria","idCuentaBancaria",$idCuenta); 
            $oItem->saldoActual=$nuevoSaldo; 
            $oItem->guardar(); 
            unset($oItem);
        }




echo json_encode(array("msg"=>true));
?>