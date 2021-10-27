<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );
$deducciones  = (isset($_REQUEST['baseImpuestos'] ) ? $_REQUEST['baseImpuestos'] : "" );
$deduccionesNuevas  = (isset($_REQUEST['impuesto'] ) ? $_REQUEST['impuesto'] : "" );


if( isset($_FILES['file']) && $_FILES['file'] != 'undefined')

    {
        $sNombre = $_FILES['file']['name'];                
        $sExtension = substr(strrchr($sNombre, '.'), 1);
        $sTemporal = $_FILES['file']['tmp_name'];
        $nombreEncript = uniqid(); 
        $nombre_archivo = "{$nombreEncript}.{$sExtension}"; 
        $directorioTmp = 'FACTURAVENTA/';
        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  
        if(move_uploaded_file($sTemporal, "../../".$directorioTmp.$nombre_archivo))
        {	                                              
            $sFoto = "FACTURAVENTA/".$nombre_archivo;
        }
        else
        {
            $sFoto = "";
        }
} 

$id=$datos["idFactura"];
$aDatos["fechaFactura"]=$datos["fechaFactura"]; 
$aDatos["nroFactura"]=$datos["nroFactura"]; 
$aDatos["fechaVencimiento"]=$datos["fechaVencimientoFactura"]; 
$aDatos["idCliente"]=$datos["idCliente"]; 
if ($sFoto!="") {
	$aDatos["archivo"]=$sFoto; 
}
$aDatos["saldo"]=str_replace("$", "", str_replace(".", "", $datos["totalPago"])); 
$oItem=new Data("factura_venta","idFacturaVenta",$id); 
foreach($aDatos  as $key => $value){
$oItem->$key=$value; 
}
$oItem->guardar(); 
unset($oItem);

$aDatosG["totalDeduccion"]=str_replace("$", "", str_replace(".", "", $datos["totalDeduccion"])); 
$aDatosG["valorAmortizacion"]=str_replace("$", "", str_replace(".", "", $datos["amortizacion"])); 
$aDatosG["totalPagar"]=str_replace("$", "", str_replace(".", "", $datos["totalPago"])); 

$oItem=new Data("factura_venta_gestion","idFacturaVenta",$id); 
foreach($aDatosG  as $keyG => $valueG){
$oItem->$keyG=$valueG; 
}
$oItem->guardar(); 
unset($oItem);

foreach ($deducciones as $keyd => $valued) {
    $aItem["tipoDeduccion"]=$valued["tipoDeduccion"]; 
    $aItem["idConcepto"]=$valued["conceptoSelect"]; 
    $aItem["concepto"]=$valued["conceptoSelectTexto"]; 
    $aItem["baseImpuestos"]=str_replace("$", "", str_replace(".", "", $valued["baseImpuestos"])); 
    $aItem["valor"]=str_replace("$", "", str_replace(".", "", $valued["valorDeduccion"])); 

    $oItem=new Data("factura_venta_deduccion","idFacturaVentaDeduccion",$valued["idFacturaVentaDeduccion"]); 
    foreach($aItem  as $keyF => $valueF){
        $oItem->$keyF=$valueF; 
    }
    $oItem->guardar(); 
    unset($oItem);
}
foreach ($deduccionesNuevas as $keydn => $valuedn) {
    $aItemN["idFacturaVenta"]=$id; 
    $aItemN["tipoDeduccion"]=$valuedn["tipoDeduccion"]; 
    $aItemN["idConcepto"]=$valuedn["idConcepto"]; 
    $aItemN["concepto"]=$valuedn["concepto"]; 
    $aItemN["baseImpuestos"]=$valuedn["baseImpuestos"]; 
    $aItemN["valor"]=$valuedn["valor"]; 
    $aItemN["estado"]=1; 
    
    $oItem=new Data("factura_venta_deduccion","idFacturaVentaDeduccion"); 
    foreach($aItemN  as $keyFN => $valueFN){
        $oItem->$keyFN=$valueFN; 
    }
    $oItem->guardar(); 
    unset($oItem);
}




// ----------------------------------------------------------------------------------------------------------------------------




    $comp=true;

    $oLista=new Lista("impuesto_cuenta_contable");
    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
    $oLista->setFiltro("tipoImpuesto","=",'3');
    $oLista->setFiltro("tipoFactura","=",'venta');
    $aCC=$oLista->getLista();

    if (!empty($aCC)) {  


    $oLista=new Lista("factura_venta_comprobante");
    $oLista->setFiltro("idFacturaVenta","=",$id);
    $oLista->setFiltro("estado","=",'1');
    $facturaComprobante=$oLista->getLista();      

        if (empty($facturaComprobante)) {
            $oLista=new Lista("parametros_documentos");
            $oLista->setFiltro("idParametrosDocumentos","=",$aCC[0]['tipoDocumento']);
            $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
            $aNumero=$oLista->getLista();
            unset($oLista);

            $numeroComprobante=intval($aNumero[0]["numeracionActual"]);

                $aDatos["idTipo"]=$aNumero[0]["tipo"]; 
                $aDatos["comprobante"]=$aNumero[0]["comprobante"]; 
                $aDatos["fecha"]=$datos["fechaFactura"]; 
                $aDatos["fechaRegistro"]=date('Y-m-d'); 
                $aDatos["usuarioRegistra"]=$_SESSION["idUsuario"]; 
                $aDatos["archivo"]=$sFoto; 
                $aDatos["observaciones"]='Factura de venta No. '.$datos["nroFactura"]; 
                $aDatos["idEmpresa"]=$datos["idEmpresa"]; 
                $aDatos["numero"]=$numeroComprobante; 
                
                $oItem=new Data("comprobante","idComprobante"); 
                foreach($aDatos  as $key => $value){
                    $oItem->$key=$value; 
                }
                $oItem->guardar(); 
                $idComprobante=$oItem->ultimoId(); 
                unset($oItem);

                $nCom["numeracionActual"]=$numeroComprobante+1;
                $oItem=new Data("parametros_documentos","idParametrosDocumentos",$aNumero[0]["idParametrosDocumentos"]); 
                foreach($nCom  as $keyC => $valueC){
                    $oItem->$keyC=$valueC; 
                }
                $oItem->guardar(); 
                unset($oItem);
            }
            if (!empty($facturaComprobante)) {

                $oLista=new Lista("comprobante_items");
                $oLista->setFiltro("idComprobante","=",$facturaComprobante[0]["idComprobante"]);
                $comEliminar=$oLista->getlista();
                unset($oLista);
                foreach ($comEliminar as $keym => $valuem) {
                    $oItem=new Data("comprobante_items","idComprobanteItem",$valuem["idComprobanteItem"]);
                    $oItem->eliminar();
                    unset($oItem);
                }

                $idComprobante=$facturaComprobante[0]["idComprobante"];                
            }

            $oItem=new Data("tercero","idTercero",$idT);
            $aCliente=$oItem->getDatos();
            unset($oItem);

            foreach ($item as $key => $value) {
                if ($value["centroCosto"]!="") {

                    $oLista=new Lista("centro_costo_contable");
                    $oLista->setFiltro("idProducto","=",$value["idProducto"]);
                    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
                    $oLista->setFiltro("tipoFactura","=",'venta');
                    $oLista->setFiltro("idCentroCosto","=",'venta');
                    $oLista->setFiltro("tipoFactura","=",'venta');
                    $aProductoCuenta=$oLista->getLista();

                    $oLista=new Lista("producto_cuenta_contable");
                    $oLista->setFiltro("idProducto","=",$value["idProducto"]);
                    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
                    $oLista->setFiltro("tipoFactura","=",'venta');
                    $aProductoCuenta=$oLista->getLista();

                    if (empty($aProductoCuenta)) {
                        $comp=false;
                    }
                    if ($comp==true) {
                        $oItem=new Data("cuenta_contable","idCuentaContable",$aProductoCuenta[0]["idEmpresaCuenta"]);
                        $aCuentaContable=$oItem->getDatos();
                        unset($oItem);

                        $aItem["idComprobante"]=$idComprobante; 
                        $aItem["idCuentaContable"]=$aProductoCuenta[0]["idEmpresaCuenta"];
                        if ($value["idCentroCosto"]=="") {
                            $aItem["idCentroCosto"]=" ";
                        }
                        if ($value["idCentroCosto"]!="") {
                            $aItem["idCentroCosto"]=$value["idCentroCosto"];
                        }
                        $aItem["idTercero"]=$idT;
                        $aItem["descripcion"]=$value["descripcion"];
                        $aItem["naturaleza"]='credito';
                        $aItem["tipoTercero"]='c';
                        $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
                        $aItem["fecha"]=$datos["fechaFactura"]; 
                        $aItem["saldoDebito"]=0;
                        $aItem["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$value["subtotal"])));
                        $aItem["base"]=0;
                    
                        $oItem=new Data("comprobante_items","idComprobanteItem"); 
                        foreach($aItem  as $keycc => $valuecc){
                            $oItem->$keycc=$valuecc; 
                        }
                        $oItem->guardar(); 
                        unset($oItem);
                    }
                }
            }
            $oItem=new Data("cuenta_contable","idCuentaContable",$aCC[0]["idEmpresaCuenta"]);
            $aCuentaContable=$oItem->getDatos();
            unset($oItem);

            $aIVA["idComprobante"]=$idComprobante; 
            $aIVA["idCuentaContable"]=$aCC[0]["idEmpresaCuenta"];
            $aIVA["idCentroCosto"]=" ";
            $aIVA["idTercero"]=$idT;
            $aIVA["descripcion"]=$value["descripcion"];
            $aIVA["naturaleza"]='credito';
            $aIVA["tipoTercero"]='c';
            $aIVA["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
            $aIVA["fecha"]=$datos["fechaFactura"]; 
            $aIVA["saldoDebito"]=0;
            $aIVA["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$datos["iva"])));
            $aIVA["base"]=0;

                $oItem=new Data("comprobante_items","idComprobanteItem"); 
                foreach($aIVA  as $keyIVA => $valueIVA){
                    $oItem->$keyIVA=$valueIVA; 
                }
                $oItem->guardar(); 
                unset($oItem);

                $totalDeduccionesFactura=0;

                foreach ($impuesto as $keyI => $valueI) {
                    if (empty($_SESSION["idEmpresa"])) {
                        $idEmpresaB=$datos["idEmpresa"];
                    }
                    if (!empty($_SESSION["idEmpresa"])) {
                        $idEmpresaB=$_SESSION["idEmpresa"];
                    }
                    $oLista=new Lista("impuesto_cuenta_contable");
                    $oLista->setFiltro("idImpuesto","=",$valueI["idConcepto"]);
                    $oLista->setFiltro("idEmpresa","=",$idEmpresaB);
                    $oLista->setFiltro("tipoFactura","=",'venta');
                    $aImpuestoCuenta=$oLista->getLista();  
                    unset($oLista);  

                    if (empty($aImpuestoCuenta)) {
                        $comp=false;
                    }

                    if ($comp==true) {

                        $aCuent=$aImpuestoCuenta[0]["idEmpresaCuenta"];    
                        
                        $oLista=new Data("cuenta_contable","idCuentaContable",$aCuent);
                        $aCuentaImpuesto=$oLista->getDatos();  
                        unset($oLista);  
                        
                            if ( strpos($aCuentaImpuesto["nombre"],'RETENCION EN LA FUENTE') !== false ) {
                                $aImpuesto["idComprobante"]=$idComprobante; 
                                $aImpuesto["idCuentaContable"]=$aCuentaImpuesto["idCuentaContable"];
                                $aImpuesto["idCentroCosto"]=" ";
                                $aImpuesto["idTercero"]=$idT;
                                $aImpuesto["descripcion"]=$value["descripcion"];
                                $aImpuesto["naturaleza"]='debito';
                                $aImpuesto["tipoTercero"]='c';
                                $aImpuesto["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
                                $aImpuesto["fecha"]=$datos["fechaFactura"]; 
                                $aImpuesto["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$valueI["valor"])));
                                $aImpuesto["saldoCredito"]=0;
                                $aImpuesto["base"]=str_replace(".", ",",$valueI["baseImpuestos"]);

                                $totalDeduccionesFactura=$totalDeduccionesFactura+floatval(str_replace(",", ".",str_replace("$", "", str_replace(".", "",$valueI["valor"]))));

                                $oItem=new Data("comprobante_items","idComprobanteItem"); 
                                foreach($aImpuesto  as $keyImpuesto => $valueImpuesto){
                                    $oItem->$keyImpuesto=$valueImpuesto; 
                                }
                                $oItem->guardar(); 
                                unset($oItem);
                            }
                        }
                            
                        if ($comp==true) {    
                            if ( strpos($aCuentaImpuesto["nombre"],'RETENCION EN LA FUENTE') === false ) {
                                
                                if (count($aImpuestoCuenta)>1) {
                                    $oLista=new Data("cuenta_contable","idCuentaContable",$aImpuestoCuenta[0]["idEmpresaCuenta"]);
                                    $aCuentaImpuestoP=$oLista->getDatos();  
                                    unset($oLista); 
                                    $aImpuesto["idComprobante"]=$idComprobante; 
                                    $aImpuesto["idCuentaContable"]=$aImpuestoCuenta[0]["idEmpresaCuenta"];
                                    $aImpuesto["idCentroCosto"]=" ";
                                    $aImpuesto["idTercero"]=$idT;
                                    $aImpuesto["descripcion"]=$value["descripcion"];
                                    $aImpuesto["naturaleza"]=$aCuentaImpuestoP["naturaleza"];
                                    $aImpuesto["tipoTercero"]='c';
                                    $aImpuesto["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
                                    $aImpuesto["fecha"]=$datos["fechaFactura"]; 
                                    if ($aCuentaImpuestoP["naturaleza"]=='debito') {
                                        $aImpuesto["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$valueI["valor"])));
                                        $aImpuesto["saldoCredito"]=0;
                                    }
                                    if ($aCuentaImpuestoP["naturaleza"]=='credito') {
                                        $aImpuesto["saldoDebito"]=0;
                                        $aImpuesto["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$valueI["valor"])));
                                    }
                                    $aImpuesto["base"]=str_replace(".", ",",$valueI["baseImpuestos"]);
                                    $oItem=new Data("comprobante_items","idComprobanteItem"); 
                                    foreach($aImpuesto  as $keyImpuesto => $valueImpuesto){
                                        $oItem->$keyImpuesto=$valueImpuesto; 
                                    }
                                    $oItem->guardar(); 
                                    unset($oItem);
                                    $oLista=new Data("cuenta_contable","idCuentaContable",$aImpuestoCuenta[1]["idEmpresaCuenta"]);
                                    $aCuentaImpuestoS=$oLista->getDatos();  
                                    unset($oLista);
                                    $aImpuesto["idComprobante"]=$idComprobante; 
                                    $aImpuesto["idCuentaContable"]=$aImpuestoCuenta[1]["idEmpresaCuenta"];
                                    $aImpuesto["idCentroCosto"]=" ";
                                    $aImpuesto["idTercero"]=$idT;
                                    $aImpuesto["descripcion"]=$value["descripcion"];
                                    $aImpuesto["naturaleza"]=$aCuentaImpuestoS["naturaleza"];
                                    $aImpuesto["tipoTercero"]='c';
                                    $aImpuesto["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
                                    $aImpuesto["fecha"]=$datos["fechaFactura"]; 
                                    if ($aCuentaImpuestoS["naturaleza"]=='debito') {
                                        $aImpuesto["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$valueI["valor"])));
                                        $aImpuesto["saldoCredito"]=0;
                                    }
                                    if ($aCuentaImpuestoS["naturaleza"]=='credito') {
                                        $aImpuesto["saldoDebito"]=0;
                                        $aImpuesto["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$valueI["valor"])));
                                    }
                                    $aImpuesto["base"]=str_replace(".", ",",$valueI["baseImpuestos"]);
                                    $oItem=new Data("comprobante_items","idComprobanteItem"); 
                                    foreach($aImpuesto  as $keyImpuesto => $valueImpuesto){
                                        $oItem->$keyImpuesto=$valueImpuesto; 
                                    }
                                    $oItem->guardar(); 
                                    unset($oItem);
                                    }
                            }

                        }
                        if ($comp==true) {
                            if (count($aImpuestoCuenta)<2) {
                                $oLista=new Data("cuenta_contable","idCuentaContable",$aImpuestoCuenta[0]["idEmpresaCuenta"]);
                                    $aCuentaImpuestoP=$oLista->getDatos();  
                                    unset($oLista); 

                                    $aImpuesto["idComprobante"]=$idComprobante; 
                                    $aImpuesto["idCuentaContable"]=$aImpuestoCuenta[0]["idEmpresaCuenta"];
                                    $aImpuesto["idCentroCosto"]=" ";
                                    $aImpuesto["idTercero"]=$idT;
                                    $aImpuesto["descripcion"]=$value["descripcion"];
                                    $aImpuesto["naturaleza"]='debito';
                                    $aImpuesto["tipoTercero"]='c';
                                    $aImpuesto["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
                                    $aImpuesto["fecha"]=$datos["fechaFactura"]; 
                                    $aImpuesto["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$valueI["valor"])));
                                    $aImpuesto["saldoCredito"]=0;

                                    $aImpuesto["base"]=str_replace(".", ",",$valueI["baseImpuestos"]);

                                    $oItem=new Data("comprobante_items","idComprobanteItem"); 
                                    foreach($aImpuesto  as $keyImpuesto => $valueImpuesto){
                                        $oItem->$keyImpuesto=$valueImpuesto; 
                                    }
                                    $oItem->guardar(); 
                                    unset($oItem);

                                    $totalDeduccionesFactura=$totalDeduccionesFactura+floatval(str_replace(",", ".",str_replace("$", "", str_replace(".", "",$valueI["valor"]))));
                            }
                        }
                    }

                    $oLista=new Lista("compra_cuenta_contable");
                    $oLista->setFiltro("concepto","=",'1');
                    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
                    $aCompraCuenta=$oLista->getLista(); 
                    unset($oLista);   

                    if (empty($aCompraCuenta)) {
                        $comp=false;
                    }
                    if (!empty($aCompraCuenta)) {
                        $cuent=$aCompraCuenta[0]["idEmpresaCuenta"];
                    }

                    if ($comp==true) {
                        $saldoTotalFactura=floatval(str_replace(",", ".",str_replace("$", "", str_replace(".", "",$datos["total"]))))-$totalDeduccionesFactura;
                        
                        $aCompra["idComprobante"]=$idComprobante; 
                        $aCompra["idCuentaContable"]=$cuent;
                        $aCompra["idCentroCosto"]=" ";
                        $aCompra["idTercero"]=$idT;
                        $aCompra["descripcion"]=$value["descripcion"];
                        $aCompra["naturaleza"]='debito';
                        $aCompra["tipoTercero"]='c';
                        $aCompra["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
                        $aCompra["fecha"]=$datos["fechaFactura"]; 
                        $aCompra["saldoDebito"]=str_replace(",", ".",$saldoTotalFactura);
                        $aCompra["saldoCredito"]=0;
                        $aCompra["base"]=0;

                        $oItem=new Data("comprobante_items","idComprobanteItem"); 
                            foreach($aCompra  as $keyImpuesto => $valueImpuesto){
                                $oItem->$keyImpuesto=$valueImpuesto; 
                            }
                            $oItem->guardar(); 
                            unset($oItem);
                        $estado=1;
                        $aFacturaComprobante["idFacturaVenta"]=$idfactura;
                        $aFacturaComprobante["idComprobante"]=$idComprobante;
                        $aFacturaComprobante["estado"]=$estado;

                        $oItem=new Data("factura_venta_comprobante","idFacturaVentaComprobante"); 
                        foreach($aFacturaComprobante  as $keyFC => $valueFC){
                            $oItem->$keyFC=$valueFC; 
                        }
                        $oItem->guardar(); 
                        unset($oItem);
                    }
                    if ($comp==false) {
                        $oLista=new Lista("comprobante");
                        $oLista->setFiltro("idComprobante","=",$idComprobante);
                        $comEliminar=$oLista->getlista();
                        unset($oLista);
                        foreach ($comEliminar as $keym => $valuem) {
                            $oItem=new Data("comprobante","idComprobante",$valuem["idComprobante"]);
                            $oItem->eliminar();
                            unset($oItem);
                        }
                        $oLista=new Lista("comprobante_items");
                        $oLista->setFiltro("idComprobante","=",$idComprobante);
                        $comprobanteItemsEliminar=$oLista->getlista();
                        unset($oLista);
                        foreach ($comprobanteItemsEliminar as $keym => $valuem) {
                            $oItem=new Data("comprobante_items","idComprobanteItem",$valuem["idComprobanteItem"]);
                            $oItem->eliminar();
                            unset($oItem);
                        }
                    }

    }


// ----------------------------------------------------------------------------------------------------------------------------




$msg=true; 
echo json_encode(array("msg"=>$msg));

?>