<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");
include_once($CLASS . "control.php");

$oControl=new Control();

date_default_timezone_set("America/Bogota"); 

$idNomina  = (isset($_REQUEST['idNomina'] ) ? $_REQUEST['idNomina'] : "" );

$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );

$valor  = (isset($_REQUEST['valor'] ) ? $_REQUEST['valor'] : "" );

if(!isset($_SESSION)){ session_start(); }


$aData["estado"]=2;
$oItem=new Data("nomina","idNomina",$idNomina); 
foreach ($aData as $key => $value) {
  $oItem->$key=$value; 
}
$oItem->guardar(); 
unset($oItem); 





    $totalFactura=$totalFactura;

    $oItem=new Data("cuenta_bancaria","idCuentaBancaria",$datos["cuentaBancaria"]); 
    $idCuenta=$datos["cuentaBancaria"];

    
        $cuentaDatos=$oItem->getDatos(); 
        $saldoActual=$cuentaDatos["saldoActual"];
        $nuevoSaldo=$saldoActual + $totalFactura;
        $cuatropormil=$cuentaDatos['aplicaCuatroMil'];
        unset($oItem);

        $oItem=new Data("tercero","idTercero",$fDatos["idCliente"]); 
        $clienteDatos=$oItem->getDatos(); 
        unset($oItem);

        $bDatos["idCuentaBancaria"]=$idCuenta;
        $bDatos["idTipoMovimiento"]=3;
        $bDatos["fechaRegistro"]=date("Y-m-d H:i:s");
        $bDatos["valorIngreso"]=0;
        $bDatos["valorEgreso"]=$valor;  
        $bDatos["saldoAnterior"]=$saldoActual;
        $bDatos["saldoActual"]=$nuevoSaldo;
        $bDatos["descripcionMovimiento"]='pago de factura '.$fDatos["nroFactura"].' del cliente '.$clienteDatos["razonSocial"]; 

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










echo json_encode(array("msg"=>true));
?>