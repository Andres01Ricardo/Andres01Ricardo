<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );
$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );
$deducciones  = (isset($_REQUEST['baseImpuestos'] ) ? $_REQUEST['baseImpuestos'] : "" );
$deduccionesNuevas  = (isset($_REQUEST['impuesto'] ) ? $_REQUEST['impuesto'] : "" );
// print_r($datos);

if(!isset($_SESSION)){ session_start(); }

if( isset($_FILES['file']) && $_FILES['file'] != 'undefined')

    {

               

        $sNombre = $_FILES['file']['name'];                

        $sExtension = substr(strrchr($sNombre, '.'), 1);

        $sTemporal = $_FILES['file']['tmp_name'];

        

        $nombreEncript = uniqid(); 

        

        $nombre_archivo = "{$nombreEncript}.{$sExtension}"; 


        $directorioTmp = 'FACTURACOMPRA/';

        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  



        if(move_uploaded_file($sTemporal, "../../".$directorioTmp.$nombre_archivo))

        {	                                              

            $sFoto = "FACTURACOMPRA/".$nombre_archivo;

        }

        else

        {

            $sFoto = "";

        }

    

} 


$id=$datos["idFacturaCompra"];

// print_r($id);

$aDatos["fechaRecibido"]=$datos["fechaRecibido"]; 

$aDatos["nroFactura"]=$datos["nroFactura"]; 
$aDatos["fechaPago"]=$datos["fechaPago"]; 
$aDatos["saldo"]=str_replace("$", "", str_replace(".", "", $datos["totalPago"])); 

if ($sFoto!="") {
	$aDatos["archivo"]=$sFoto; 
}

$oItem=new Data("factura_compra","idFacturaCompra",$id); 

foreach($aDatos  as $key => $value){

$oItem->$key=$value; 

}

$oItem->guardar(); 

unset($oItem);




$aDatosG["totalDeduccion"]=str_replace("$", "", str_replace(".", "", $datos["totalDeduccion"])); 

$aDatosG["valorAmortizacion"]=str_replace("$", "", str_replace(".", "", $datos["amortizacion"])); 
$aDatosG["totalPagar"]=str_replace("$", "", str_replace(".", "", $datos["totalPago"])); 


$oItem=new Data("factura_compra_gestion","idFacturaCompra",$id); 

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

    
    $oItem=new Data("factura_compra_deduccion","idFacturaCompraDeduccion",$valued["idFacturaCompraDeduccion"]); 

    foreach($aItem  as $keyF => $valueF){

        $oItem->$keyF=$valueF; 

    }

    $oItem->guardar(); 

    unset($oItem);

}

foreach ($deduccionesNuevas as $keydn => $valuedn) {

    $aItemN["idFacturaCompra"]=$id; 

    $aItemN["tipoDeduccion"]=$valuedn["tipoDeduccion"]; 

    $aItemN["idConcepto"]=$valuedn["idConcepto"]; 

    $aItemN["concepto"]=$valuedn["concepto"]; 

    $aItemN["baseImpuestos"]=str_replace(".", ",", $valuedn["baseImpuestos"]); 

    $aItemN["valor"]=$valuedn["valor"]; 

    $aItemN["estado"]=1; 

    
    $oItem=new Data("factura_compra_deduccion","idFacturaCompraDeduccion"); 

    foreach($aItemN  as $keyFN => $valueFN){

        $oItem->$keyFN=$valueFN; 

    }

    $oItem->guardar(); 

    unset($oItem);

}


// ---------------------------------------------------------------------------------------------------------------
    $comp=true;
    $existe=0;
    // print_r($_SESSION["idUsuario"]);
    

    $oLista=new Lista("compra_cuenta_contable");
    $oLista->setFiltro("concepto","=",'1');
    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
    $oLista->setFiltro("tipoFactura","like",'compra');
    $aCC=$oLista->getLista();
    unset($oLista);


if (!empty($aCC)) {

    $oLista=new Lista("factura_compra_comprobante");
    $oLista->setFiltro("idFacturaCompra","=",$id);
    $facturaCompraComprobante=$oLista->getLista();
    unset($oLista);
    

if (empty($facturaCompraComprobante)) {
    // print_r('vacio');

    if (!empty($datos["cuentaContableTotal"])) {
        $oLista=new Lista("compra_cuenta_contable");
        $oLista->setFiltro("concepto","=",'1');
        $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
        $oLista->setFiltro("tipoFactura","like",'compra');
        $oLista->setFiltro("idEmpresaCuenta","=",$datos["cuentaContableTotal"]);
        $aCCT=$oLista->getLista();
        unset($oLista);
        $tipoDocumentoTotal=$aCCT[0]['tipoDocumento'];
    }
    if (empty($datos["cuentaContableTotal"])) {
        
        // $idCuentaContableTotal=$aCC[0]["idEmpresaCuenta"];
        $tipoDocumentoTotal=$aCC[0]['tipoDocumento'];
    }


    $oLista=new Lista("parametros_documentos");
    $oLista->setFiltro("idParametrosDocumentos","=",$tipoDocumentoTotal);
    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
    $aNumero=$oLista->getLista();
    unset($oLista);

    $numeroComprobante=intval($aNumero[0]["numeracionActual"]);

    $aDatos["idTipo"]=$aNumero[0]["tipo"]; 
    $aDatos["comprobante"]=$aNumero[0]["comprobante"]; 
    $aDatos["fecha"]=$datos["fechaRecibido"]; 
    $aDatos["fechaRegistro"]=date('Y-m-d'); 
    $aDatos["usuarioRegistra"]=$_SESSION["idUsuario"]; 
    $aDatos["archivo"]=$sFoto; 
    $aDatos["observaciones"]='Factura de compra No. '.$datos["nroFactura"]; 
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

if (!empty($facturaCompraComprobante)) {
    $existe=1;
    // print_r($_SESSION["idUsuario"]);
    $idComprobante=$facturaCompraComprobante[0]['idComprobante'];

    $oItem=new Lista("comprobante_items");
    $oItem->setFiltro("idComprobante","=",$idComprobante);
    $oComprobante=$oItem->getLista();
    unset($oItem);

    foreach ($oComprobante as $keyCom => $valueCom) {
        $oItem=new Data("comprobante_items","idComprobanteItem",$valueCom["idComprobanteItem"]);
        $oItem->eliminar();
        unset($oItem);
    }
    
}

    foreach ($item as $key => $value) {
        // print_r($value);
        $oLista=new Lista("producto_cuenta_contable");
        $oLista->setFiltro("idProducto","=",$value["idProducto"]);
        $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
        $oLista->setFiltro("tipoFactura","like",'compra');
        $aProductoCuenta=$oLista->getLista();
        // print_r($aProductoCuenta);
        if (empty($aProductoCuenta)) {
            // code...
        }
        $oItem=new Data("cuenta_contable","idCuentaContable",$aProductoCuenta[0]["idEmpresaCuenta"]);
        $aCuentaContable=$oItem->getDatos();
        unset($oItem);

        $aItem["idComprobante"]=$idComprobante; 
        $aItem["idCuentaContable"]=$aProductoCuenta[0]["idEmpresaCuenta"];
        $aItem["idCentroCosto"]=" ";
        $aItem["idTercero"]=$datos["idTercero"];
        $aItem["descripcion"]=$value["descripcion"];
        $aItem["naturaleza"]='debito';
        $aItem["tipoTercero"]='p';
        $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aItem["fecha"]=$datos["fechaRecibido"]; 
        $aItem["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$value["subtotal"])));
        $aItem["saldoCredito"]=0;
        $aItem["base"]=0;

         $oItem=new Data("comprobante_items","idComprobanteItem"); 
            foreach($aItem  as $keycc => $valuecc){
                $oItem->$keycc=$valuecc; 
            }
            $oItem->guardar(); 
            unset($oItem);
        }

        $oLista=new Lista("impuesto_cuenta_contable");
        $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
        $oLista->setFiltro("tipoImpuesto","=",'3');
        $oLista->setFiltro("tipoFactura","like",'compra');
        $aCuentaContableN=$oLista->getLista();  

        if(!empty($aCuentaContableN)){

        $aIVA["idComprobante"]=$idComprobante; 
        $aIVA["idCuentaContable"]=$aCuentaContableN[0]["idEmpresaCuenta"];
        $aIVA["idCentroCosto"]=" ";
        $aIVA["idTercero"]=$datos["idTercero"];
        $aIVA["descripcion"]=$value["descripcion"];
        $aIVA["naturaleza"]='debito';
        $aIVA["tipoTercero"]='p';
        $aIVA["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aIVA["fecha"]=$datos["fechaRecibido"]; 
        $aIVA["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$datos["iva"])));
        $aIVA["saldoCredito"]=0;
        $aIVA["base"]=0;

            $oItem=new Data("comprobante_items","idComprobanteItem"); 
            foreach($aIVA  as $keyIVA => $valueIVA){
                $oItem->$keyIVA=$valueIVA; 
            }
            $oItem->guardar(); 
            unset($oItem);
        }
            if(empty($aCuentaContableN)){
                $comp=false;
            }
            if (!empty($datos["cuentaContableTotal"])) {
                
                $idCuentaContableTotal=$datos["cuentaContableTotal"];
            }
            if (empty($datos["cuentaContableTotal"])) {
                
                $idCuentaContableTotal=$aCC[0]["idEmpresaCuenta"];
            }
                $oItem=new Data("cuenta_contable","idCuentaContable",$idCuentaContableTotal);
                $aCompraCuenta=$oItem->getDatos();
                unset($oItem);  
            
            if(empty($aCompraCuenta)){
                $comp=false;
            }    
            
            $aCompra["idComprobante"]=$idComprobante; 
            $aCompra["idCuentaContable"]=$idCuentaContableTotal;
            $aCompra["idCentroCosto"]=" ";
            $aCompra["idTercero"]=$datos["idTercero"];
            $aCompra["descripcion"]=$value["descripcion"];
            $aCompra["naturaleza"]='credito';
            $aCompra["tipoTercero"]='p';
            $aCompra["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
            $aCompra["fecha"]=$datos["fechaRecibido"]; 
            $aCompra["saldoDebito"]=0;
            $aCompra["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$datos["totalPago"])));
            $aCompra["base"]=0;

            $oItem=new Data("comprobante_items","idComprobanteItem"); 
                foreach($aCompra  as $keyImpuesto => $valueImpuesto){
                    $oItem->$keyImpuesto=$valueImpuesto; 
                }
                $oItem->guardar(); 
                unset($oItem);

            foreach ($deducciones as $keyI => $valueI) {

                if ($comp==true) {
                    $oLista=new Lista("impuesto_cuenta_contable");
                    $oLista->setFiltro("idImpuesto","=",$valueI["conceptoSelect"]);
                    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
                    $oLista->setFiltro("tipoFactura","like",'compra');
                    $aImpuestoCuenta=$oLista->getLista();    

                    // print_r($aImpuestoCuenta);

                    if(empty($aImpuestoCuenta)){
                        $comp=false;
                    }

                    $idEmpresaCuenta=$aImpuestoCuenta[0]["idEmpresaCuenta"];
                    
                    $aImpuesto["idComprobante"]=$idComprobante; 
                    $aImpuesto["idCuentaContable"]=$idEmpresaCuenta;
                    $aImpuesto["idCentroCosto"]=" ";
                    $aImpuesto["idTercero"]=$datos["idTercero"];
                    $aImpuesto["descripcion"]=$value["descripcion"];
                    $aImpuesto["naturaleza"]='credito';
                    $aImpuesto["tipoTercero"]='p';
                    $aImpuesto["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
                    $aImpuesto["fecha"]=$datos["fechaRecibido"]; 
                    $aImpuesto["saldoDebito"]=0;
                    $aImpuesto["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$valueI["valorDeduccion"])));
                    $aImpuesto["base"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$valueI["baseImpuestos"])));

                    $oItem=new Data("comprobante_items","idComprobanteItem"); 
                        foreach($aImpuesto  as $keyImpuesto => $valueImpuesto){
                            $oItem->$keyImpuesto=$valueImpuesto; 
                        }
                        $oItem->guardar(); 
                        unset($oItem);
                    }
                }
                foreach ($deduccionesNuevas as $keyIN => $valueIN) {

                    if ($comp==true) {
                        $oLista=new Lista("impuesto_cuenta_contable");
                        $oLista->setFiltro("idImpuesto","=",$valueIN["idConcepto"]);
                        $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
                        $oLista->setFiltro("tipoFactura","like",'compra');
                        $aImpuestoCuenta=$oLista->getLista();    

                        // print_r($aImpuestoCuenta);

                        if(empty($aImpuestoCuenta)){
                            $comp=false;
                        }

                        $idEmpresaCuenta=$aImpuestoCuenta[0]["idEmpresaCuenta"];
                        
                        $aImpuestoN["idComprobante"]=$idComprobante; 
                        $aImpuestoN["idCuentaContable"]=$idEmpresaCuenta;
                        $aImpuestoN["idCentroCosto"]=" ";
                        $aImpuestoN["idTercero"]=$datos["idTercero"];
                        $aImpuestoN["descripcion"]=$value["descripcion"];
                        $aImpuestoN["naturaleza"]='credito';
                        $aImpuestoN["tipoTercero"]='p';
                        $aImpuestoN["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
                        $aImpuestoN["fecha"]=$datos["fechaRecibido"]; 
                        $aImpuestoN["saldoDebito"]=0;
                        $aImpuestoN["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$valueIN["valor"])));
                        $aImpuestoN["base"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$valueIN["baseImpuestos"])));

                        $oItem=new Data("comprobante_items","idComprobanteItem"); 
                            foreach($aImpuestoN  as $keyImpuestoN => $valueImpuestoN){
                                $oItem->$keyImpuestoN=$valueImpuestoN; 
                            }
                            $oItem->guardar(); 
                            unset($oItem);
                        }
                    }

                if ($comp==true) {
                    
                    if ($existe==0) {
                        $estado=1;

                        $aFacturaComprobante["idFacturaCompra"]=$id;
                        $aFacturaComprobante["idComprobante"]=$idComprobante;
                        $aFacturaComprobante["estado"]=$estado;

                        $oItem=new Data("factura_compra_comprobante","idFacturaCompraComprobante"); 
                        foreach($aFacturaComprobante  as $keyFC => $valueFC){
                            $oItem->$keyFC=$valueFC; 
                        }
                        $oItem->guardar(); 
                        unset($oItem);
                    }

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







$msg=true; 





echo json_encode(array("msg"=>$msg));

?>