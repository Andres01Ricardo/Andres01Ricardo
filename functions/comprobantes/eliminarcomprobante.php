<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 


$idEliminar=(isset($_REQUEST['idEliminar'] ) ? $_REQUEST['idEliminar'] : "" );

$idEmpresa=(isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );


// print_r('ingreso al php');


if(!isset($_SESSION)){ session_start(); }

$oItem=new Data("comprobante","idComprobante",$idEliminar); 
$oComprobante=$oItem->getDatos();
unset($oItem);

$oItem=new Data("comprobante","idComprobante",$idEliminar); 
$oItem->eliminar(); 
unset($oItem);

$valorPagoRetencion=0;
$IVAcredito=0;
$IVAdebito=0;
$pagoSeguridadSocial=0;

$oLista=new Lista("comprobante_items");
$oLista->setFiltro("idComprobante","=",$idEliminar);
$comprobanteItems=$oLista->getLista();
unset($oLista);
if (!empty($comprobanteItems)) {
	foreach ($comprobanteItems as $key => $value) {

            
        // print_r('ingreso ciclo');

			$oLista=new Lista('cuenta_contable');
            $oLista->setFiltro('idCuentaContable',"=",$value["idCuentaContable"]);
            $oLista->setFiltro("idEmpresa","=",$idEmpresa);
            $cuentaContable=$oLista->getLista();
            unset($oLista);

            
             if (substr($cuentaContable[0]["codigoCuenta"], 0,4)=='2365' &&  $oComprobante["idTipo"]==7 ) {
                $valorPagoRetencion+=$value["saldoDebito"];

                // print_r("ingreso retencion");
            }


            if (substr($cuentaContable[0]["codigoCuenta"], 0,4)=='2408' &&  $oComprobante["idTipo"]==7 ) {
                // print_r("ingreso iva");

                if ($value["saldoCredito"] !="") {

                    $IVAcredito+=$value["saldoCredito"];

                }
                if ($value["saldoDebito"] !="") {
                    
                    $IVAdebito+=$value["saldoDebito"];
                }
            
            }

            if ((substr($cuentaContable[0]["codigoCuenta"], 0,4)=='2380' || substr($cuentaContable[0]["codigoCuenta"], 0,4)=='2370') &&  $oComprobante["idTipo"]==7 ) {
                $pagoSeguridadSocial+=$value["saldoDebito"];

                // print_r("ingreso retencion");
            }



            if (substr($cuentaContable[0]["codigoCuenta"], 0,2)=='11' ) {   

                if ($value["naturaleza"]=='debito') {
                    //sacar el dinero de la cuenta

                    $idCuentaPago=$value["idCuentaContable"];

                    $oLista=new Lista('banco_cuenta_contable');
                    $oLista->setFiltro('idEmpresaCuenta',"=",$idCuentaPago);
                    $oLista->setFiltro("idEmpresa","=",$idEmpresa);
                    $bancoCuenta=$oLista->getLista();
                    unset($oLista);
                   
                
                    $oLista=new Data("cuenta_bancaria","idCuentaBancaria",$bancoCuenta[0]["idCuentaBancaria"]);
                    $cuentaBancaria=$oLista->getDatos();
                    unset($oLista);
                                    
                    $saldoCuenta=$value["saldoDebito"];

                    $saldoActual=$cuentaBancaria["saldoActual"];
                    $nuevoSaldo=$saldoActual - $saldoCuenta;
                    $cuatropormil=$cuentaBancaria['aplicaCuatroMil'];
                    $idCuenta=$cuentaBancaria['idCuentaBancaria']; 

                    

                    $oItem=new Data("cuenta_bancaria","idCuentaBancaria",$idCuenta); 
                    $oItem->saldoActual=$nuevoSaldo; 
                    $oItem->guardar(); 
                    unset($oItem);


                    $bDatos["valorIngreso"]=0;
                    $bDatos["valorEgreso"]=$saldoCuenta;

                    $idCuenta=$cuentaBancaria['idCuentaBancaria'];        
                    $bDatos["descripcionMovimiento"]='comprobante eliminado'; 
                    $bDatos["idCuentaBancaria"]=$idCuenta;
                    $bDatos["idTipoMovimiento"]=3;
                    $bDatos["fechaRegistro"]=date("Y-m-d H:i:s");         
                    
                    $bDatos["saldoAnterior"]=$saldoActual;
                    $bDatos["saldoActual"]=$nuevoSaldo;
                    $bDatos["idComprobante"]=0;

                    $oItem=new Data("cuenta_bancaria_movimientos","idCuentaBancariaMovimientos"); 
                        
                        foreach($bDatos  as $key => $value){
                            $oItem->$key=$value; 
                        }

                        $oItem->guardar(); 
                        unset($oItem);
                
                }  
                if ($value["naturaleza"]=='credito') {
                    //sacar el dinero de la cuenta

                    $idCuentaPago=$value["idCuentaContable"];

                    $oLista=new Lista('banco_cuenta_contable');
                    $oLista->setFiltro('idEmpresaCuenta',"=",$idCuentaPago);
                    $oLista->setFiltro("idEmpresa","=",$idEmpresa);
                    $bancoCuenta=$oLista->getLista();
                    unset($oLista);
                
                    $oLista=new Data("cuenta_bancaria","idCuentaBancaria",$bancoCuenta[0]["idCuentaBancaria"]);
                    $cuentaBancaria=$oLista->getDatos();
                    unset($oLista);
                                    
                    $saldoCuenta=$value["saldoCredito"];

                    $saldoActual=$cuentaBancaria["saldoActual"];
                    $nuevoSaldo=$saldoActual + $saldoCuenta;
                    $cuatropormil=$cuentaBancaria['aplicaCuatroMil'];
                    $idCuenta=$cuentaBancaria['idCuentaBancaria']; 


                    $oItem=new Data("cuenta_bancaria","idCuentaBancaria",$idCuenta); 
                    $oItem->saldoActual=$nuevoSaldo; 
                    $oItem->guardar(); 
                    unset($oItem);



                    $bDatos["valorIngreso"]=$saldoCuenta;
                    $bDatos["valorEgreso"]=0;


                    $idCuenta=$cuentaBancaria['idCuentaBancaria'];        
                    $bDatos["descripcionMovimiento"]='comprobante eliminado'; 
                    $bDatos["idCuentaBancaria"]=$idCuenta;
                    $bDatos["idTipoMovimiento"]=3;
                    $bDatos["fechaRegistro"]=date("Y-m-d H:i:s");         
                    
                    $bDatos["saldoAnterior"]=$saldoActual;
                    $bDatos["saldoActual"]=$nuevoSaldo;
                    $bDatos["idComprobante"]=0;

                    $oItem=new Data("cuenta_bancaria_movimientos","idCuentaBancariaMovimientos"); 
                        
                        foreach($bDatos  as $key => $value){
                            $oItem->$key=$value; 
                        }

                        $oItem->guardar(); 
                        unset($oItem);

                    // if ($cuatropormil==1) {

                    //     $valorcuatromil = $saldoCuenta*4/1000;
                    //     $nuevoSaldoActual = $nuevoSaldo + $valorcuatromil;
                        
                    //     $nuevoSaldo = $nuevoSaldoActual;

                    //     $oItem=new Data("cuenta_bancaria","idCuentaBancaria",$idCuenta); 
                    //     $oItem->saldoActual=$nuevoSaldo; 
                        // $oItem->guardar(); 
                    //     unset($oItem);

                    // }



                
                }   
                
            }


		$oItem=new Data("comprobante_items","idComprobanteItem",$value["idComprobanteItem"]);
		$oItem->eliminar();
		unset($oItem);
	}
}




$IVAFinal=$IVAdebito-$IVAcredito;

    if ($IVAFinal!=0) {

        $IVAFinal=$IVAFinal*(-1);

        // $oLista=new Lista("impuesto_pagado");
        // $oLista->setFiltro("idEmpresa","=",)
        // print_r($IVAFinal);

        $dDatos["tipoImpuesto"]='IVA';
        $dDatos["valor"]=$IVAFinal;
        $dDatos["valorAdicional"]=0;
        $dDatos["sanciones"] =  0;
        $dDatos["intereses"] =  0;
        $dDatos["cuentaBancaria"] = $bancoCuenta[0]["idCuentaBancaria"];
        $dDatos["idUsuarioRegistra"] = $_SESSION["idUsuario"];
        $dDatos["fechaRegistro"]=date("Y-m-d H:m:s");
        $dDatos["idEmpresa"] = $idEmpresa;

        
            
        $oItem=new Data("impuesto_pagado","idImpuestoPagado"); 
        foreach($dDatos  as $key => $value){
        $oItem->$key=$value; 
        }
        $oItem->guardar(); 
        unset($oItem);

    }

    if ($valorPagoRetencion!=0) {
        
        $valorPagoRetencion=$valorPagoRetencion*(-1);

        // print_r($valorPagoRetencion);

        $dDatos["tipoImpuesto"]='RETENCION';
        $dDatos["valor"]=$valorPagoRetencion;
        $dDatos["valorAdicional"]=0;
        $dDatos["sanciones"] =  0;
        $dDatos["intereses"] =  0;
        $dDatos["cuentaBancaria"] = $bancoCuenta[0]["idCuentaBancaria"];
        $dDatos["idUsuarioRegistra"] = $_SESSION["idUsuario"];
        $dDatos["fechaRegistro"]=date("Y-m-d H:m:s");
        $dDatos["idEmpresa"] = $idEmpresa;
        

        $oItem=new Data("impuesto_pagado","idImpuestoPagado"); 
        foreach($dDatos  as $key => $value){
        $oItem->$key=$value; 
        }
        $oItem->guardar(); 
        unset($oItem);

    }


    if ($pagoSeguridadSocial!=0) {
        
        $pagoSeguridadSocial=$pagoSeguridadSocial*(-1);

        // print_r($pagoSeguridadSocial);

        $dDatos["tipoImpuesto"]='SEGURIDADSOCIAL';
        $dDatos["valor"]=$pagoSeguridadSocial;
        $dDatos["valorAdicional"]=0;
        $dDatos["sanciones"] =  0;
        $dDatos["intereses"] =  0;
        $dDatos["cuentaBancaria"] = $bancoCuenta[0]["idCuentaBancaria"];
        $dDatos["idUsuarioRegistra"] = $_SESSION["idUsuario"];
        $dDatos["fechaRegistro"]=date("Y-m-d H:m:s");
        $dDatos["idEmpresa"] = $idEmpresa;
        

        $oItem=new Data("impuesto_pagado","idImpuestoPagado"); 
        foreach($dDatos  as $key => $value){
        $oItem->$key=$value; 
        }
        $oItem->guardar(); 
        unset($oItem);

    }




$oLista=new Lista("factura_venta_comprobante");
$oLista->setFiltro("idComprobante","=",$idEliminar);
$ventaComprobante=$oLista->getlista();
unset($oLista);
if (!empty($ventaComprobante)) {
	$idFactura=$ventaComprobante[0]['idFacturaVenta'];


	$oItem=new Data("factura_venta","idFacturaVenta",$idFactura); 
	$oItem->eliminar(); 
	unset($oItem);

	$oItem=new Lista("factura_venta_item");
	$oItem->setFiltro("idFacturaVenta","=",$idFactura); 
	$facturaVentaItem=$oItem->getLista();
	unset($oItem);

	foreach ($facturaVentaItem as $keym => $valuem) {
	$oItem=new Data("factura_venta_item","idFacturaVentaItem",$valuem["idFacturaVentaItem"]);
	$oItem->eliminar();
	unset($oItem);
	}
}

if (empty($ventaComprobante)) {
	$oLista=new Lista("factura_compra_comprobante");
	$oLista->setFiltro("idComprobante","=",$idEliminar);
	$compraComprobante=$oLista->getlista();
	unset($oLista);




	if (!empty($compraComprobante)) {
		$idFactura=$compraComprobante[0]['idFacturaCompra'];


		$oItem=new Data("factura_compra","idFacturaCompra",$idFactura); 
		$oItem->eliminar(); 
		unset($oItem);

		$oItem=new Lista("factura_compra_item");
		$oItem->setFiltro("idFacturaCompra","=",$idFactura); 
		$facturaCompraItem=$oItem->getLista();
		unset($oItem);

		foreach ($facturaCompraItem as $keym => $valuem) {
		$oItem=new Data("factura_compra_item","idFacturaCompraItem",$valuem["idFacturaCompraItem"]);
		$oItem->eliminar();
		unset($oItem);
		}
	}
}


$oItem=new Data("comprobante_recurrente","idComprobante",$idEliminar); 
$oItem->eliminar(); 
unset($oItem);
    


$msg=true; 


echo json_encode(array("msg"=>$msg));

?>