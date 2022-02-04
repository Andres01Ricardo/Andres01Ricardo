<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );
$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );

if( isset($_FILES['file']) && $_FILES['file'] != 'undefined')

    {
        $sNombre = $_FILES['file']['name'];                
        $sExtension = substr(strrchr($sNombre, '.'), 1);
        $sTemporal = $_FILES['file']['tmp_name'];
        $nombreEncript = uniqid(); 
        $nombre_archivo = "{$nombreEncript}.{$sExtension}"; 
        $directorioTmp = 'COMPROBANTE/';

        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  
        if(move_uploaded_file($sTemporal, "../../".$directorioTmp.$nombre_archivo)){
            $sFoto = "COMPROBANTE/".$nombre_archivo;

        }else{
            $sFoto = "";
        }  
} 

if(!isset($_SESSION)){ session_start(); }



$idComprobante=$datos["idComprobante"];
$idEmpresa=$datos["idEmpresa"];



$oLista=new Lista("parametros_documentos");
$oLista->setFiltro("tipo","=",$datos["tipoDocumento"]);
$oLista->setFiltro("comprobante","=",$datos["comprobante"]);
$oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
$aNumero=$oLista->getLista();
unset($oLista);


$oLista=new Lista("comprobante");
$oLista->setFiltro("numero","=",$datos["numeroComprobante"]);
$oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
$aComprobanteValidar=$oLista->getLista();
unset($oLista);


$aDatos["idTipo"]=$datos["tipoDocumento"]; 
$aDatos["comprobante"]=$aNumero[0]["comprobante"]; 
$aDatos["fecha"]=$datos["fecha"]; 
$aDatos["fechaRegistro"]=date('Y-m-d'); 
// $aDatos["usuarioRegistra"]=44; 
$aDatos["archivo"]=$sFoto; 
$aDatos["observaciones"]=$datos["obsevaciones"]; 
$aDatos["numero"]=$datos["numeroComprobante"]; 

$oItem=new Data("comprobante","idComprobante",$idComprobante); 

foreach($aDatos  as $key => $value){
    $oItem->$key=$value; 
}
$oItem->guardar();
unset($oItem);

$oLista=new Lista("comprobante_items");
$oLista->setFiltro("idComprobante","=",$idComprobante);
$itemsEliminar=$oLista->getLista();
unset($oLista);

foreach ($itemsEliminar as $keyEL => $valueEL) {

            


            $oLista=new Lista('cuenta_contable');
            $oLista->setFiltro('idCuentaContable',"=",$valueEL["idCuentaContable"]);
            $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
            $cuentaContable=$oLista->getLista();
            unset($oLista);


            // if (substr($cuentaContable[0]["codigoCuenta"], 0,2)=='11' ) {   

            //     if ($valueEL["naturaleza"]=='debito') {
            //         //sacar el dinero de la cuenta

            //         $idCuentaPago=$valueEL["idCuentaContable"];

            //         $oLista=new Lista('banco_cuenta_contable');
            //         $oLista->setFiltro('idEmpresaCuenta',"=",$idCuentaPago);
            //         $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
            //         $bancoCuenta=$oLista->getLista();
            //         unset($oLista);
                   
                
            //         $oLista=new Data("cuenta_bancaria","idCuentaBancaria",$bancoCuenta[0]["idCuentaBancaria"]);
            //         $cuentaBancaria=$oLista->getDatos();
            //         unset($oLista);
                                    
            //         $saldoCuenta=$valueEL["saldoDebito"];

            //         $saldoActual=$cuentaBancaria["saldoActual"];
            //         $nuevoSaldo=$saldoActual - $saldoCuenta;
            //         $cuatropormil=$cuentaBancaria['aplicaCuatroMil'];
            //         $idCuenta=$cuentaBancaria['idCuentaBancaria']; 

                    

            //         $oItem=new Data("cuenta_bancaria","idCuentaBancaria",$idCuenta); 
            //         $oItem->saldoActual=$nuevoSaldo; 
            //         $oItem->guardar(); 
            //         unset($oItem);
                
            //     }  
            //     if ($valueEL["naturaleza"]=='credito') {
            //         //sacar el dinero de la cuenta

            //         $idCuentaPago=$valueEL["idCuentaContable"];

            //         $oLista=new Lista('banco_cuenta_contable');
            //         $oLista->setFiltro('idEmpresaCuenta',"=",$idCuentaPago);
            //         $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
            //         $bancoCuenta=$oLista->getLista();
            //         unset($oLista);
                
            //         $oLista=new Data("cuenta_bancaria","idCuentaBancaria",$bancoCuenta[0]["idCuentaBancaria"]);
            //         $cuentaBancaria=$oLista->getDatos();
            //         unset($oLista);
                                    
            //         $saldoCuenta=$valueEL["saldoCredito"];

            //         $saldoActual=$cuentaBancaria["saldoActual"];
            //         $nuevoSaldo=$saldoActual + $saldoCuenta;
            //         $cuatropormil=$cuentaBancaria['aplicaCuatroMil'];
            //         $idCuenta=$cuentaBancaria['idCuentaBancaria']; 


            //         $oItem=new Data("cuenta_bancaria","idCuentaBancaria",$idCuenta); 
            //         $oItem->saldoActual=$nuevoSaldo; 
            //         $oItem->guardar(); 
            //         unset($oItem);


            //         // if ($cuatropormil==1) {

            //         //     $valorcuatromil = $saldoCuenta*4/1000;
            //         //     $nuevoSaldoActual = $nuevoSaldo + $valorcuatromil;
                        
            //         //     $nuevoSaldo = $nuevoSaldoActual;

            //         //     $oItem=new Data("cuenta_bancaria","idCuentaBancaria",$idCuenta); 
            //         //     $oItem->saldoActual=$nuevoSaldo; 
            //         //     $oItem->guardar(); 
            //         //     unset($oItem);

            //         // }
                
            //     }   
                
            // }



        $oItem=new Data("comprobante_items","idComprobanteItem",$valueEL["idComprobanteItem"]);
        $oItem->eliminar();
        unset($oItem);

}


// if ($datos["tipoFactura"]==1) {

//     $oLista=new Lista("factura_compra_deduccion");
//     $oLista->setFiltro("idFacturaCompra","=",$datos["idFactura"]);
//     $itemsEliminarDeduccion=$oLista->getLista();
//     unset($oLista);

//     foreach ($itemsEliminarDeduccion as $keyEL => $valueEL) {
//             $oItem=new Data("factura_compra_deduccion","idFacturaCompraDeduccion",$valueEL["idFacturaCompraDeduccion"]); 
//             $oItem->eliminar();
//             unset($oItem);
//     }
// }


// if ($datos["tipoFactura"]==2) {

//     $oLista=new Lista("factura_venta_deduccion");
//     $oLista->setFiltro("idFacturaVenta","=",$datos["idFactura"]);
//     $itemsEliminarDeduccion=$oLista->getLista();
//     unset($oLista);

//     foreach ($itemsEliminarDeduccion as $keyEL => $valueEL) {
//             $oItem=new Data("factura_venta_deduccion","idFacturaVentaDeduccion",$valueEL["idFacturaVentaDeduccion"]); 
//             $oItem->eliminar();
//             unset($oItem);
//     }
// }


foreach ($item as $key => $value) {
    $operacionNaturaleza="";

    $aItem["idComprobante"]=$idComprobante; 
    $aItem["idCuentaContable"]=$value["idCuentaContable"]; 
    $aItem["idCentroCosto"]=$value["idCentroCosto"];
    $aItem["idSubcentroCosto"]=$value["idSubcentroCosto"];
    $aItem["idTercero"]=$value["idTercero"]; 
    $aItem["descripcion"]=$value["descripcion"]; 
    $aItem["tipoTercero"]='p'; 
    $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"];
    $aItem["fecha"]=$datos["fecha"];

    if ($value["debito"] !="") {
        $valor=$value["debito"];
    }
    if ($value["credito"] !="") {
        $valor=$value["credito"]; 
    }

    $valorN=floatval(str_replace(",", ".",str_replace("$", "", str_replace(".", "",$valor))));


    if ($value["debito"] !="") {
        $aItem["naturaleza"]='debito';  
        $aItem["saldoDebito"]=str_replace(",", ".",$valorN);
        $aItem["saldoCredito"]=0;
    }
    if ($value["credito"] !="") {
        $aItem["naturaleza"]='credito';
        $aItem["saldoCredito"]=str_replace(",", ".",$valorN);
        $aItem["saldoDebito"]=0;
    }

    if ($value["base"]!='') {
        $aItem["base"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$value["base"])));
    }
    if ($value["base"]=='') {
        $aItem["base"]=0;
    }

    if (is_nan($aItem["base"])) {
        $aItem["cruce"]=$aItem["base"];
        $aItem["base"]=0;
    }

    $operacionNaturaleza=$value["naturaleza"];
    
        $oItem=new Data("comprobante_items","idComprobanteItem"); 
        foreach($aItem  as $keycc => $valuecc){
            $oItem->$keycc=$valuecc; 
        }
        $oItem->guardar(); 
        unset($oItem);



        // if ($datos["tipoFactura"]==1) {
        //     if ($value["credito"]!="") {
        //         $oLista=new Lista("impuesto_cuenta_contable");
        //         $oLista->setFiltro("idEmpresaCuenta","=",$value["idCuentaContable"]);
        //         $oLista->setFiltro("idEmpresa","=",$idEmpresa);
        //         $oLista->setFiltro("tipoFactura","=",'compra');
        //         $aImpuestoCuenta=$oLista->getLista();  
        //         unset($oLista);

        //         if (!empty($aImpuestoCuenta)) {
        //             if ($aImpuestoCuenta[0]["idImpuesto"]!=0) {
        //                 $oItem=new Data("retencion","idRetencion",$aImpuestoCuenta[0]["idImpuesto"] );
        //                 $retencion=$oItem->getDatos();
        //                 unset($oItem);


        //                 $gestion["idFacturaCompra"]=$datos["idFactura"];
        //                 $gestion["tipoDeduccion"]=$retencion["tipo"];
        //                 $gestion["idConcepto"]=$datos["comprobante"];
        //                 $gestion["concepto"]=$retencion["valor"].'% - '.$retencion["descripcion"];
        //                 $gestion["baseImpuestos"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$value["base"])));
        //                 $gestion["valor"]=str_replace(",", ".",$valorN);
                        

        //                 $oItem=new Data("factura_compra_deduccion","idFacturaCompraDeduccion"); 
        //                 foreach($gestion  as $keyfc => $valuefc){
        //                     $oItem->$keyfc=$valuefc; 
        //                 }
        //                 $oItem->guardar(); 
        //                 unset($oItem);
        //             }
        //         }   
        //     }
        // }

        // if ($datos["tipoFactura"]==2) {
        //     if ($value["debito"]!="") {
                
            
        //         $oLista=new Lista("impuesto_cuenta_contable");
        //         $oLista->setFiltro("idEmpresaCuenta","=",$value["idCuentaContable"]);
        //         $oLista->setFiltro("idEmpresa","=",$idEmpresa);
        //         $oLista->setFiltro("tipoFactura","=",'venta');
        //         $aImpuestoCuenta=$oLista->getLista();  
        //         unset($oLista);

        //         if (!empty($aImpuestoCuenta)) {
        //             if ($aImpuestoCuenta[0]["idImpuesto"]!=0) {
        //                 $oItem=new Data("retencion","idRetencion",$aImpuestoCuenta[0]["idImpuesto"] );
        //                 $retencion=$oItem->getDatos();
        //                 unset($oItem);


        //                 $gestion["idFacturaVenta"]=$datos["idFactura"];
        //                 $gestion["tipoDeduccion"]=$retencion["tipo"];
        //                 $gestion["idConcepto"]=$datos["comprobante"];
        //                 $gestion["concepto"]=$retencion["valor"].'% - '.$retencion["descripcion"];
        //                 $gestion["baseImpuestos"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$value["base"])));
        //                 $gestion["valor"]=str_replace(",", ".",$valorN);

        //                 // print_r($value["base"]);
        //                 // print_r('****');
        //                 // print_r($gestion["baseImpuestos"]);
                        
        //                 $oItem=new Data("factura_venta_deduccion","idFacturaVentaDeduccion"); 
        //                 foreach($gestion  as $keyfv => $valuefv){
        //                     $oItem->$keyfv=$valuefv; 
        //                 }
        //                 $oItem->guardar(); 
        //                 unset($oItem);
        //             }
        //         }  
        //     }
        // }





        // -----------------------------------------------------------------------------------------------------------------------------------

        // if (substr($value["cuentaContable"], 0,4)=='1105' ||  substr($value["cuentaContable"], 0,4)=='1110' ) {

        //     $idCuentaPago=$value["idCuentaContable"];

        //     $oLista=new Lista('banco_cuenta_contable');
        //     $oLista->setFiltro('idEmpresaCuenta',"=",$idCuentaPago);
        //     $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
        //     $bancoCuenta=$oLista->getLista();
        //     unset($oLista);

        //     $oLista=new Data("cuenta_bancaria","idCuentaBancaria",$bancoCuenta[0]["idCuentaBancaria"]);
        //     $cuentaBancaria=$oLista->getDatos();
        //     unset($oLista);

        //     $totalFactura=$valorN;
        //     $saldoActual=$cuentaBancaria["saldoActual"];
            
        //     if ($value["debito"]!="") {
                
        //         $nuevoSaldo=$saldoActual + $totalFactura;
        //         $bDatos["valorIngreso"]=$totalFactura;
        //         $bDatos["valorEgreso"]=0;
        //     }elseif ($value["credito"]!="") {
                
        //         $nuevoSaldo=$saldoActual - $totalFactura;
        //         $bDatos["valorIngreso"]=0;
        //         $bDatos["valorEgreso"]=$totalFactura;
        //     }
            
        //     $cuatropormil=$cuentaBancaria['aplicaCuatroMil'];    
        //     $idCuenta=$cuentaBancaria['idCuentaBancaria'];        
        //     $bDatos["descripcionMovimiento"]='pago '.$factura["nroFactura"].'   '.$razonSocialTercero; 
        //     $bDatos["idCuentaBancaria"]=$idCuenta;
        //     $bDatos["idTipoMovimiento"]=1;
        //     $bDatos["fechaRegistro"]=date("Y-m-d H:i:s");         
            
        //     $bDatos["saldoAnterior"]=$saldoActual;
        //     $bDatos["saldoActual"]=$nuevoSaldo;
        //     $bDatos["idComprobante"]=$idComprobante;

        //     $oItem=new Data("cuenta_bancaria_movimientos","idCuentaBancariaMovimientos"); 
                
        //         foreach($bDatos  as $key => $value){
        //             $oItem->$key=$value; 
        //         }

        //         $oItem->guardar(); 
        //         unset($oItem);

        //     $oItem=new Data("cuenta_bancaria","idCuentaBancaria",$bancoCuenta[0]["idCuentaBancaria"]);
        //     $oItem->saldoActual=$nuevoSaldo; 
        //     $oItem->guardar(); 
        //     unset($oItem);
        // }
            // if (substr($value["cuentaContable"], 0,2)=='11' &&  $datos["tipoDocumento"]==7 ) {
            //     $idCuentaPago=$value["idCuentaContable"];

            //     $oLista=new Lista('banco_cuenta_contable');
            //     $oLista->setFiltro('idEmpresaCuenta',"=",$idCuentaPago);
            //     $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
            //     $bancoCuenta=$oLista->getLista();
            //     unset($oLista);

            //     $oLista=new Data("cuenta_bancaria","idCuentaBancaria",$bancoCuenta[0]["idCuentaBancaria"]);
            //     $cuentaBancaria=$oLista->getDatos();
            //     unset($oLista);

            //     $totalFactura=$valorN;
            //     $saldoActual=$cuentaBancaria["saldoActual"];
            //     $nuevoSaldo=$saldoActual - $totalFactura;
            //     $cuatropormil=$cuentaBancaria['aplicaCuatroMil'];    
            //     $idCuenta=$cuentaBancaria['idCuentaBancaria'];        

            //     $bDatos["idCuentaBancaria"]=$idCuenta;
            //     $bDatos["idTipoMovimiento"]=1;
            //     $bDatos["fechaRegistro"]=date("Y-m-d H:i:s");
            //     $bDatos["valorIngreso"]=0;
            //     $bDatos["valorEgreso"]=$totalFactura;  
            //     $bDatos["saldoAnterior"]=$saldoActual;
            //     $bDatos["saldoActual"]=$nuevoSaldo;
            //     $bDatos["descripcionMovimiento"]='pago de factura '.$factura["nroFactura"].' del proveedor '.$razonSocialTercero; 

            //     $oItem=new Data("cuenta_bancaria_movimientos","idCuentaBancariaMovimientos"); 
            //         foreach($bDatos  as $key => $value){
            //             $oItem->$key=$value; 
            //         }
            //         // $oItem->guardar(); 
                   
            //         unset($oItem);


            //     if ($cuatropormil==1) {

            //         $valorcuatromil = $totalFactura*4/1000;
            //         $nuevoSaldoActual = $nuevoSaldo - $valorcuatromil;
            //         $bDatos["idCuentaBancaria"]=$idCuenta;
            //         $bDatos["idTipoMovimiento"]=1;
            //         $bDatos["fechaRegistro"]=date("Y-m-d H:i:s");
            //         $bDatos["valorIngreso"]=0;
            //         $bDatos["valorEgreso"]=$valorcuatromil;  
            //         $bDatos["saldoAnterior"]=$nuevoSaldo;
            //         $bDatos["saldoActual"]=$nuevoSaldoActual;
            //         $bDatos["descripcionMovimiento"]='pago de 4xmil de factura '.$factura["nroFactura"].' del proveedor '.$razonSocialTercero; 

            //         $oItem=new Data("cuenta_bancaria_movimientos","idCuentaBancariaMovimientos"); 
            //         foreach($bDatos  as $key => $value){
            //             $oItem->$key=$value; 
            //         }
            //         // $oItem->guardar(); 
            //         unset($oItem);
            //         $nuevoSaldo = $nuevoSaldoActual;
            //     }


            //     $oItem=new Data("cuenta_bancaria","idCuentaBancaria",$bancoCuenta[0]["idCuentaBancaria"]);
            //     $oItem->saldoActual=$nuevoSaldo; 
            //     $oItem->guardar(); 
            //     unset($oItem);
            // }

            // if (substr($value["cuentaContable"], 0,2)=='11' &&  $datos["tipoDocumento"]==15 ) {   

            // $idCuentaPago=$value["idCuentaContable"];

            // $oLista=new Lista('banco_cuenta_contable');
            // $oLista->setFiltro('idEmpresaCuenta',"=",$idCuentaPago);
            // $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
            // $bancoCuenta=$oLista->getLista();
            // unset($oLista);

            // $oLista=new Data("cuenta_bancaria","idCuentaBancaria",$bancoCuenta[0]["idCuentaBancaria"]);
            // $cuentaBancaria=$oLista->getDatos();
            // unset($oLista);
            
            // $totalFactura=$valorN;

            // $saldoActual=$cuentaBancaria["saldoActual"];
            // $nuevoSaldo=$saldoActual + $totalFactura;
            // $cuatropormil=$cuentaBancaria['aplicaCuatroMil'];
            // $idCuenta=$cuentaBancaria['idCuentaBancaria']; 


            // $bDatos["idCuentaBancaria"]=$idCuenta;
            // $bDatos["idTipoMovimiento"]=3;
            // $bDatos["fechaRegistro"]=date("Y-m-d H:i:s");
            // $bDatos["valorIngreso"]=$totalFactura;
            // $bDatos["valorEgreso"]=0;  
            // $bDatos["saldoAnterior"]=$saldoActual;
            // $bDatos["saldoActual"]=$nuevoSaldo;
            // $bDatos["descripcionMovimiento"]='pago de factura '.$factura["nroFactura"].' del cliente '.$razonSocialTercero; 

            // $oItem=new Data("cuenta_bancaria_movimientos","idCuentaBancariaMovimientos"); 
            // foreach($bDatos  as $key => $value){
            //     $oItem->$key=$value; 
            // }
            // // $oItem->guardar();    
            // unset($oItem);

            // $oItem=new Data("cuenta_bancaria","idCuentaBancaria",$idCuenta); 
            // $oItem->saldoActual=$nuevoSaldo; 
            // $oItem->guardar(); 
            // unset($oItem);
                
            // }
        // -----------------------------------------------------------------------------------------------------------------------------------
    }

    $msg=true; 
    echo json_encode(array("msg"=>$msg));

?>


