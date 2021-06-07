<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );

$impuesto  = (isset($_REQUEST['impuesto'] ) ? $_REQUEST['impuesto'] : "" );



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







if(!isset($_SESSION)){ session_start(); }

$aDatos["fechaRegistro"]=date("Y-m-d H:i:s");

$aDatos["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 

$aDatos["idEmpresa"]=$datos["idEmpresa"]; 

$aDatos["fechaFactura"]=$datos["fechaFactura"]; 

$aDatos["idCliente"]=$datos["idCliente"]; 

$aDatos["nroFactura"]=$datos["nroFactura"]; 

$aDatos["archivo"]=$sFoto; 

$aDatos["subtotal"]=str_replace("$", "", str_replace(".", "", $datos["subtotal"])); 

$aDatos["descuento"]=str_replace("$", "", str_replace(".", "", $datos["descuento"])); 

$aDatos["iva"]=str_replace("$", "", str_replace(".", "", $datos["iva"])); 

$aDatos["total"]=str_replace("$", "", str_replace(".", "", $datos["total"])); 

$aDatos["estado"]=1; 

$aDatos["fechaVencimiento"]=$datos["fechaVencimientoFactura"];
$aDatos["saldo"]=str_replace("$", "", str_replace(".", "", $datos["total"]));


$oItem=new Data("factura_venta","idFacturaVenta"); 

foreach($aDatos  as $key => $value){

    $oItem->$key=$value; 

}


$oItem->guardar(); 
$idfactura=$oItem->ultimoId(); 

unset($oItem);


foreach ($item as $key => $value) {

    $aItem["idFacturaVenta"]=$idfactura; 

    $aItem["detalleProducto"]=$value["producto"]; 

    $aItem["idProductoServicio"]=$value["idProducto"]==""?0:$value["idProducto"]; 

    $aItem["descripcion"]=$value["descripcion"]; 

    $aItem["idUnidad"]=$value["idUnidad"]; 

    $aItem["cantidad"]=$value["cantidad"]; 

    $aItem["iva"]=$value["iva"]; 

    $aItem["valorUnitario"]=str_replace("$", "", str_replace(".", "", $value["valorUnitario"])); 

    $aItem["subtotal"]=str_replace("$", "", str_replace(".", "", $value["subtotal"])); 

    $aItem["total"]=str_replace("$", "", str_replace(".", "", $value["total"]));



    $oItem=new Data("factura_venta_item","idFacturaVentaItem"); 

    foreach($aItem  as $key => $value){

        $oItem->$key=$value; 

    }

    $oItem->guardar(); 

    unset($oItem);

}




foreach ($impuesto as $keyimp => $valueimp) {

    $aImpuesto["idFacturaVenta"]=$idfactura; 

    $aImpuesto["tipoDeduccion"]=$valueimp["tipoDeduccion"]; 

    if($value["idConcepto"]!=""){

        $aImpuesto["idConcepto"]=$valueimp["idConcepto"]; 

    }

    if($value["baseImpuestos"]!=""){

        $aImpuesto["baseImpuestos"]=$valueimp["baseImpuestos"]; 

    }

    $aImpuesto["concepto"]=$valueimp["concepto"]; 

    $aImpuesto["valor"]=$valueimp["valor"]; 





    $oItem=new Data("factura_venta_deduccion","idFacturaVentaDeduccion"); 

    foreach($aImpuesto  as $key => $valor){

        $oItem->$key=$valor; 

    }

    $oItem->guardar(); 

    unset($oItem);

}





$cLista = new Lista('usuario');

$cLista->setFiltro("idRol","=",'2');

$colista=$cLista->getLista();

foreach ($colista as $key => $contador) {


   
    $correoContador = $contador["correo"];

    $cmensaje="<p>Estimado ".$contador["nombreUsuario"]." ".$contador["apellidoUsuario"]." <br>

    El usuario ".$_SESSION["nombreUsuario"]." ".$_SESSION["apellidoUsuario"]." ha enviado una factura de venta <br><br> </p>"; 




    $cEmail["correo"]=$contador["correo"]; 
    

    $cEmail["asunto"]="Factura de venta enviada"; 

    $cEmail["mensaje"]=$cmensaje; 

    $cControl=new Control();

    // $cControl->enviarCorreo($cEmail);
    unset($cControl);

    $dDatos["fechaNotificacion"]=date("Y-m-d H:m:s");
    $dDatos["idUsuarioRegistra"] = $_SESSION["idUsuario"];
    $dDatos["idUsuarioNotificado"] =$contador["idUsuario"];
    $dDatos["notificacion"] =  "El usuario ".$_SESSION["nombreUsuario"]." ".$_SESSION["apellidoUsuario"]." ha enviado una factura de venta";
    

    $oItem=new Data("notificacion","idNotificacion"); 
    foreach($dDatos  as $key => $value){
    $oItem->$key=$value; 
    }
    $oItem->guardar(); 
    unset($oItem);
}




$sLista = new Lista('usuario');

$sLista->setFiltro("idRol","=",'1');

$solista=$sLista->getLista();

foreach ($solista as $key => $super) {

    $smensaje="<p>Estimado ".$super["nombreUsuario"]." ".$super["apellidoUsuario"]." <br>

    El usuario ".$_SESSION["nombreUsuario"]." ".$_SESSION["apellidoUsuario"]." ha enviado una factura de venta <br><br> </p>"; 




    $sEmail["correo"]=$super["correo"]; 
    

    $sEmail["asunto"]="Factura de venta enviada"; 

    $sEmail["mensaje"]=$smensaje; 

    $sControl=new Control();

    // $cControl->enviarCorreo($sEmail);
    unset($sControl);

    $sDatos["fechaNotificacion"]=date("Y-m-d H:m:s");
    $sDatos["idUsuarioRegistra"] = $_SESSION["idUsuario"];
    $sDatos["idUsuarioNotificado"] =$super["idUsuario"];
    $sDatos["notificacion"] =  "El usuario ".$_SESSION["nombreUsuario"]." ".$_SESSION["apellidoUsuario"]." ha enviado una factura de venta";
    

    $oItem=new Data("notificacion","idNotificacion"); 
    foreach($sDatos  as $key => $svalue){
    $oItem->$key=$svalue; 
    }
    $oItem->guardar(); 
    unset($oItem);
}






    $oLista=new Lista("impuesto_cuenta_contable");
    $oLista->setFiltro("impuesto","=",'iva venta');
    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
    $aCC=$oLista->getLista();

if (!empty($aCC)) {

        

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


        $oItem=new Data("cliente","idCliente",$datos["idCliente"]);
        $aCliente=$oItem->getDatos();
        unset($oItem);



        foreach ($item as $key => $value) {
            $oLista=new Lista("producto_cuenta_contable");
            $oLista->setFiltro("idProducto","=",$value["idProducto"]);
            $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
            $oLista->setFiltro("tipoFactura","=",'venta');
            $aProductoCuenta=$oLista->getLista();
            
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
            $aItem["idTercero"]=$datos["idCliente"];
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




// --------------------------------------------------------------------------------------------------------------------------------


        $oItem=new Data("cuenta_contable","idCuentaContable",$aCC[0]["idEmpresaCuenta"]);
        $aCuentaContable=$oItem->getDatos();
        unset($oItem);

        $aIVA["idComprobante"]=$idComprobante; 
        $aIVA["idCuentaContable"]=$aCC[0]["idEmpresaCuenta"];
        $aIVA["idCentroCosto"]=" ";
        $aIVA["idTercero"]=$datos["idCliente"];
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


                if ($valueI["tipoDeduccion"]==1) {
                    $impuesto='retencion venta';
                }
                if ($valueI["tipoDeduccion"]==2) {
                    $impuesto='reteica venta';
                }
                $naturaleza='debito';

                $oLista=new Lista("impuesto_cuenta_contable");
                $oLista->setFiltro("impuesto","=",$impuesto);
                $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
                $aImpuestoCuenta=$oLista->getLista();    

                
                $aImpuesto["idComprobante"]=$idComprobante; 
                $aImpuesto["idCuentaContable"]=$aImpuestoCuenta[0]["idEmpresaCuenta"];
                $aImpuesto["idCentroCosto"]=" ";
                $aImpuesto["idTercero"]=$datos["idCliente"];
                $aImpuesto["descripcion"]=$value["descripcion"];
                $aImpuesto["naturaleza"]='debito';
                $aImpuesto["tipoTercero"]='c';
                $aImpuesto["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
                $aImpuesto["fecha"]=$datos["fechaFactura"]; 
                $aImpuesto["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$valueI["valor"])));
                $aImpuesto["saldoCredito"]=0;
                $aImpuesto["base"]=$valueI["baseImpuestos"];


    $totalDeduccionesFactura=$totalDeduccionesFactura+floatval(str_replace(",", ".",str_replace("$", "", str_replace(".", "",$valueI["valor"]))));

                $oItem=new Data("comprobante_items","idComprobanteItem"); 
                    foreach($aImpuesto  as $keyImpuesto => $valueImpuesto){
                        $oItem->$keyImpuesto=$valueImpuesto; 
                    }
                    $oItem->guardar(); 
                    unset($oItem);
                }

                $oLista=new Lista("venta_cuenta_contable");
                $oLista->setFiltro("concepto","=",'TotalPagarVenta');
                $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
                $aCompraCuenta=$oLista->getLista();    


                $saldoTotalFactura=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$datos["total"])))-$totalDeduccionesFactura;

                
                $aCompra["idComprobante"]=$idComprobante; 
                $aCompra["idCuentaContable"]=$aCompraCuenta[0]["idEmpresaCuenta"];
                $aCompra["idCentroCosto"]=" ";
                $aCompra["idTercero"]=$datos["idCliente"];
                $aCompra["descripcion"]=$value["descripcion"];
                $aCompra["naturaleza"]='debito';
                $aCompra["tipoTercero"]='c';
                $aCompra["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
                $aCompra["fecha"]=$datos["fechaFactura"]; 
                $aCompra["saldoDebito"]=$saldoTotalFactura;
                $aCompra["saldoCredito"]=0;
                $aCompra["base"]=0;

                $oItem=new Data("comprobante_items","idComprobanteItem"); 
                    foreach($aCompra  as $keyImpuesto => $valueImpuesto){
                        $oItem->$keyImpuesto=$valueImpuesto; 
                    }
                    $oItem->guardar(); 
                    unset($oItem);



    

// --------------------------------------------------------------------------------------------------------------------------------

}
$msg=true; 



echo json_encode(array("msg"=>$msg));

?>