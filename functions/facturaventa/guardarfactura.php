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

if( isset($_FILES['file2']) && $_FILES['file2'] != 'undefined')
    {
        $sNombre2 = $_FILES['file2']['name'];                
        $sExtension2 = substr(strrchr($sNombre2, '.'), 1);
        $sTemporal2 = $_FILES['file2']['tmp_name'];
        $nombreEncript2 = uniqid(); 
        $nombre_archivo2 = "{$nombreEncript2}.{$sExtension2}"; 

        $directorioTmp2 = 'FACTURAVENTA/';
        $ubicacionTmp2 = "{$directorioTmp2}{$nombre_archivo2}";  
        if(move_uploaded_file($sTemporal2, "../../".$directorioTmp2.$nombre_archivo2))
        {                                                 
            $sFoto2 = 'FACTURAVENTA/'.$nombre_archivo2;
        }
        else
        {
            $sFoto2 = "";
        }
}

if ($datos["idCliente"]=="") {
    


$oItem=new Data("tercero","nit",$datos["nit"]); 
$aValidate=$oItem->getDatos(); 
unset($oItem); 

if(!isset($_SESSION)){ session_start(); }

if(empty($aValidate)){
    
    $aDatos["tipoPersona"]=2; 
    $aDatos["nit"]=$datos["nit"]; 
    $aDatos["digitoVerificador"]=$datos["digitoVerificador"]==""?"0":$datos["digitoVerificador"]; 
    $aDatos["razonSocial"]=$datos["razonSocial"]; 
    $aDatos["email"]=$datos["email"]; 
    $aDatos["telefono"]=$datos["telefono"]; 
    $aDatos["idDepartamento"]=27; 
    $aDatos["idCiudad"]=904; 
    $aDatos["direccion"]=$datos["direccion"]; 
    $aDatos["fechaRegistro"]=date("Y-m-d H:i:s");
    $aDatos["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
    $aDatos["estado"]=1; 
    
        $aDatos["tipoTercero"]=1; 
    
    $aDatos["responsableIva"]=2;
    $aDatos["periodoPago"]=30; 

    $oItem=new Data("tercero","idTercero"); 
    foreach($aDatos  as $key => $value){
        $oItem->$key=$value; 
    }
    $oItem->guardar(); 
    $idTercero=$oItem->ultimoId(); 
    unset($oItem);
    foreach ($item as $key => $value) {
        if($value["estado"]==1){
        $oItem=new Data("tercero_empresa","idTerceroEmpresa"); 
        $oItem->idTercero=$idTercero; 
        $oItem->idEmpresa=$_SESSION["idEmpresa"];
        $oItem->guardar(); 
        unset($oItem); 
        }
    }
}
if(!empty($aValidate)){
    if ($aValidate['tipoTercero']==1 || $aValidate['tipoTercero']==4) {
        $idTercero=$aValidate['idTercero'];


            // if($value["estado"]==1){

            $oLista=new Lista("tercero_empresa");
            $oLista->setFiltro("idTercero","=",$idTercero);
            $oLista->setFiltro("idEmpresa","=",$_SESSION["idEmpresa"]);
            $terceroEmpresa=$oLista->getLista();
            unset($oLista);

            if (empty($terceroEmpresa)) {
                $oItem=new Data("tercero_empresa","idTerceroEmpresa"); 
                $oItem->idTercero=$idTercero; 
                $oItem->idEmpresa=$_SESSION["idEmpresa"]; 
                $oItem->guardar(); 
                unset($oItem); 
            }

            
            // }
        
    }
        if ($aValidate['tipoTercero']==2) {
            $aDatos["tipoPersona"]=2; 
            $aDatos["nit"]=$datos["nit"]; 
            
            $aDatos["razonSocial"]=$datos["razonSocial"]; 
             
            $aDatos["estado"]=1; 
            
            $aDatos["tipoTercero"]=4; 

            $oItem=new Data("tercero","idTercero",$aValidate['idTercero']); 
            foreach($aDatos  as $key => $value){
                $oItem->$key=$value; 
            }
            $oItem->guardar(); 
            $idTercero=$aValidate['idTercero']; 
            unset($oItem);
            
            
            $oLista=new Lista("tercero_empresa");
            $oLista->setFiltro("idTercero","=",$idTercero);
            $oLista->setFiltro("idEmpresa","=",$_SESSION["idEmpresa"]);
            $terceroEmpresa=$oLista->getLista();
            unset($oLista);

            if (empty($terceroEmpresa)) {
                $oItem=new Data("tercero_empresa","idTerceroEmpresa"); 
                $oItem->idTercero=$idTercero; 
                $oItem->idEmpresa=$_SESSION["idEmpresa"]; 
                $oItem->guardar(); 
                unset($oItem); 
            }
            
        }
    }
}



if(!isset($_SESSION)){ session_start(); }

$aDatos["fechaRegistro"]=date("Y-m-d H:i:s");

$aDatos["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 

$aDatos["idEmpresa"]=$datos["idEmpresa"]; 

$aDatos["fechaFactura"]=$datos["fechaFactura"]; 
if (!empty($datos["idCliente"])) {
    $idT=$datos["idCliente"];
}
if (empty($datos["idCliente"])) {
    $idT=$idTercero;
}
$aDatos["idCliente"]=$idT;

$aDatos["nroFactura"]=$datos["nroFactura"]; 

$aDatos["archivo"]=$sFoto; 

$aDatos["archivo2"]=$sFoto2; 

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








    // $oLista=new Lista("compra_cuenta_contable");
    // $oLista->setFiltro("concepto","=",'TotalPagar');
    // $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
    // $oLista->setFiltro("tipoFactura","=",'compra');
    // $aCC=$oLista->getLista();


$comp=true;

    $oLista=new Lista("impuesto_cuenta_contable");
    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
    $oLista->setFiltro("tipoImpuesto","=",'3');
    $oLista->setFiltro("tipoFactura","=",'venta');
    $aCC=$oLista->getLista();

// if (!empty($aCC)) {
    $detener=1;
if ($detener==0) {

        

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


        $oItem=new Data("tercero","idTercero",$idT);
        $aCliente=$oItem->getDatos();
        unset($oItem);



        foreach ($item as $key => $value) {
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
                // print_r($aImpuestoCuenta);

                // foreach ($aImpuestoCuenta as $keyAI => $valueAI) {

                if (empty($aImpuestoCuenta)) {
                    $comp=false;
                }

                if ($comp==true) {
                    // code...
                

                    $aCuent=$aImpuestoCuenta[0]["idEmpresaCuenta"];    
                    
                    $oLista=new Data("cuenta_contable","idCuentaContable",$aCuent);
                    $aCuentaImpuesto=$oLista->getDatos();  
                    unset($oLista);  
                    
                    // print_r($aCuentaImpuesto);

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

                            // print_r('ingreso');

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
                                // if ($aCuentaImpuestoP["naturaleza"]=='debito') {
                                    $aImpuesto["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$valueI["valor"])));
                                    $aImpuesto["saldoCredito"]=0;
                                // }
                                // if ($aCuentaImpuestoP["naturaleza"]=='credito') {
                                //     $aImpuesto["saldoDebito"]=0;
                                //     $aImpuesto["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$valueI["valor"])));
                                // }
                                
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

                // }
                

                

                



                $oLista=new Lista("compra_cuenta_contable");
                $oLista->setFiltro("concepto","=",'1');
                $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
                $aCompraCuenta=$oLista->getLista(); 
                unset($oLista);   

                if (empty($aCompraCuenta)) {
                    // $oLista=new Lista("cuenta_contable");
                    // $oLista->setFiltro("codigoCuenta","=",'13050505');
                    // $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
                    // $aCuentaCliente=$oLista->getLista(); 
                    // $cuent=$aCuentaCliente[0]["idCuentaContable"];
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
$msg=true; 



echo json_encode(array("msg"=>$msg));

?>