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
        }else{
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


$oLista=new Lista("banco_cuenta_contable");
$oLista->setFiltro("idBancoCuentaContable","=",$datos["formaPagoFactura"]);
$oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
$aFormaPago=$oLista->getLista();

if ($aFormaPago[0]["idCuentaBancaria"]!=0) {
    $aDatos["estado"]=3; 
    $aDatos["saldo"]=0;




    $totalFactura=str_replace("$", "", str_replace(".", "", $datos["totalPago"]));
    $idCuenta=$aFormaPago[0]["idCuentaBancaria"];

    $oItem=new Data("cuenta_bancaria","idCuentaBancaria",$aFormaPago[0]["idCuentaBancaria"]);
    $cuentaDatos=$oItem->getDatos(); 

        $saldoActual=$cuentaDatos["saldoActual"];

        $nuevoSaldo=$saldoActual + $totalFactura;
        $cuatropormil=$cuentaDatos['aplicaCuatroMil'];
        unset($oItem);

        $oItem=new Data("tercero","idTercero",$idT); 
        $clienteDatos=$oItem->getDatos(); 
        unset($oItem);


        $bDatos["idCuentaBancaria"]=$idCuenta;
        $bDatos["idTipoMovimiento"]=3;
        $bDatos["fechaRegistro"]=date("Y-m-d H:i:s");
        $bDatos["valorIngreso"]=$totalFactura;
        $bDatos["valorEgreso"]=0;  
        $bDatos["saldoAnterior"]=$saldoActual;
        $bDatos["saldoActual"]=$nuevoSaldo;
        $bDatos["descripcionMovimiento"]='pago de factura '.$datos["nroFactura"].' del cliente '.$clienteDatos["razonSocial"]; 

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



}
if ($aFormaPago[0]["idCuentaBancaria"]==0) {
    $aDatos["estado"]=1; 
    $aDatos["saldo"]=str_replace("$", "", str_replace(".", "", $datos["totalPago"]));
}


$aDatos["fechaVencimiento"]=$datos["fechaVencimientoFactura"];


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

    $aItem["idBodega"]=$value["idBodega"]; 

    $aItem["iva"]=$value["iva"]; 

    $aItem["valorUnitario"]=str_replace("$", "", str_replace(".", "", $value["valorUnitario"])); 

    $aItem["subtotal"]=str_replace("$", "", str_replace(".", "", $value["subtotal"])); 

    $aItem["total"]=str_replace("$", "", str_replace(".", "", $value["total"]));



    $oItem=new Data("factura_venta_item","idFacturaVentaItem"); 

    foreach($aItem  as $key => $valueFVI){

        $oItem->$key=$valueFVI; 

    }

    $oItem->guardar(); 

    unset($oItem);





    $oLista=new Lista("producto_servicio");
    $oLista->setFiltro("idProductoServicio","=",$value["idProducto"]);
    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
    $aProductoCuenta=$oLista->getLista();

    if (!empty($aProductoCuenta)) {


        $oLista=new Data("empresa","idEmpresa",$datos["idEmpresa"]);
        $aEmpresaDatos=$oLista->getDatos();
        unset($oLista);

        // $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
        
        if ($aEmpresaDatos['manejaContabilidad']==1 && $aEmpresaDatos['manejaInventario']==1) {


            $oLista = new Lista('inventario_inicial');
            $oLista->setFiltro("idEmpresa","=",$datos['idEmpresa']);
            $oLista->setFiltro("idProducto","=",$value["idProducto"]);
            $oLista->setFiltro("idBodega","=",$value["idBodega"]);
            $aInventario=$oLista->getLista();
            unset($oLista);

            if (empty($aInventario)) {

                $aItem["idProducto"]=$value["idProducto"];
                $aItem["idUnidad"]=$value["idUnidad"];
                $aItem["idCategoria"]=0;
                $aItem["existencia"]=0;
                $aItem["fecha"]= date("Y-m-d");
                $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"];
                $aItem["idEmpresa"]=$datos["idEmpresa"];
                $aItem["stockMinimo"]=0;
                $aItem["idBodega"]=$value['idBodega'];

                $oItem=new Data("inventario_inicial","idInventarioInicial"); 
                foreach($aItem  as $key => $valueInv){
                    // print_r($valueInv);
                    $oItem->$key=$valueInv; 
                }
                    $oItem->guardar(); 
                   unset($oItem);

            }  



            $moverInventario["tipoMovimiento"]=2;
            $moverInventario["fechaRegistro"]=date('Y-m-d H:i:s');
            $moverInventario["ingreso"]=0;
            $moverInventario["egreso"]=$value["cantidad"];
            $moverInventario["idUsuarioRegistra"]=$_SESSION["idUsuario"];
            $moverInventario["idProducto"]=$value["idProducto"];
            $moverInventario["idEmpresa"]=$datos["idEmpresa"];
            $moverInventario["observaciones"]="Factura Nro ".$datos["nroFactura"];
            $moverInventario["idBodega"]=$value["idBodega"];

            $oItem=new Data("inventario_productos_movimientos","idInventarioProductosMovimientos"); 
            foreach($moverInventario  as $keyMovInv => $valueMovInv){
                $oItem->$keyMovInv=$valueMovInv; 
            }
            $oItem->guardar(); 
            unset($oItem);

        }
    }

}

foreach ($impuesto as $keyimp => $valueimp) {
    $aImpuesto["idFacturaVenta"]=$idfactura; 
    $aImpuesto["tipoDeduccion"]=$valueimp["tipoDeduccion"]; 
    if($valueimp["idConcepto"]!=""){
        $aImpuesto["idConcepto"]=$valueimp["idConcepto"]; 

        if ($valueimp["idConcepto"]==33) {
            $aImpuesto["restar"]=1; 
        }
        if ($valueimp["idConcepto"]!=33) {
            $aImpuesto["restar"]=0; 
        }
    }
    if($valueimp["baseImpuestos"]!=""){
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
$consecutivoComprobante=0;
if (!empty($aCC)) {


    $oLista=new Lista("parametros_documentos");
    $oLista->setFiltro("idParametrosDocumentos","=",$datos['tipoDocumento']);
    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
    $aNumero=$oLista->getLista();
    unset($oLista);


    // $numeroComprobante=intval($aNumero[0]["numeracionActual"]);
    $numeroComprobante=intval($datos["numeroComprobante"]);


    $oItem=new Data("tipos_documento_contable","idTiposDocumento",$aNumero[0]["tipo"]);
    $letraTipo=$oItem->getDatos();
    unset($oItem);

    $consecutivoComprobante=$letraTipo["letra"].'-'.$aNumero[0]["comprobante"].'-'.$numeroComprobante;




        $aDatos["idTipo"]=$aNumero[0]["tipo"]; 
        $aDatos["comprobante"]=$aNumero[0]["comprobante"]; 
        $aDatos["fecha"]=$datos["fechaFactura"]; 
        $aDatos["fechaRegistro"]=date('Y-m-d'); 
        $aDatos["usuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aDatos["archivo"]=$sFoto; 
        $aDatos["observaciones"]='Factura de venta No. '.$datos["nroFactura"]; 
        $aDatos["idEmpresa"]=$datos["idEmpresa"]; 
        $aDatos["numero"]=$numeroComprobante; 
        $aDatos["estado"]=NULL; 
        
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
            $oLista=new Lista("producto_servicio");
            $oLista->setFiltro("idProductoServicio","=",$value["idProducto"]);
            $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
            $aProductoCuenta=$oLista->getLista();

            if (empty($aProductoCuenta)) {
                $comp=false;
            }
            if ($comp==true) {
                
                // $oItem=new Data("grupo_inventario","idGrupoInventario",$aProductoCuenta[0]["idGrupo"]);
                // $aGrupo=$oItem->getDatos();
                // unset($oItem);
                $oLista=new Data("empresa","idEmpresa",$datos["idEmpresa"]);
                $aEmpresaDatos=$oLista->getDatos();
                unset($oLista);

                // $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
                
                if ($aEmpresaDatos['manejaContabilidad']==1 && $aEmpresaDatos['manejaInventario']==1) {
                    $oItem=new Data("grupo_inventario","idGrupoInventario",$aProductoCuenta[0]["idGrupo"]);
                    $aGrupoContable=$oItem->getDatos();
                    unset($oItem);

                    $aItem["idCuentaContable"]=$aGrupoContable["venta"];
                    
                    $aItemInv["idComprobante"]=$idComprobante; 
                    $aItemInv["idCuentaContable"]=$aGrupoContable["inventario"];
                    $aItemInv["idCentroCosto"]=" ";
                    $aItemInv["idSubcentroCosto"]=" ";
                    $aItemInv["idTercero"]=$idT;
                    $aItemInv["descripcion"]=$value["descripcion"].': '.$value["cantidad"].' unidades';
                    $aItemInv["naturaleza"]='credito';
                    $aItemInv["tipoTercero"]='p';
                    $aItemInv["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
                    $aItemInv["fecha"]=$datos["fechaFactura"]; 
                    $aItemInv["saldoDebito"]=0;
                    $aItemInv["saldoCredito"]=$aProductoCuenta[0]["costoPromedio"];
                    $aItemInv["base"]=0;
                
                    $oItem=new Data("comprobante_items","idComprobanteItem"); 
                    foreach($aItemInv  as $keyInv => $valueInv){
                        $oItem->$keyInv=$valueInv; 
                    }
                    $oItem->guardar(); 
                    unset($oItem);



                    $aItemInv["idComprobante"]=$idComprobante; 
                    $aItemInv["idCuentaContable"]=$aGrupoContable["costo"];
                    $aItemInv["idCentroCosto"]=" ";
                    $aItemInv["idSubcentroCosto"]=" ";
                    $aItemInv["idTercero"]=$idT;
                    $aItemInv["descripcion"]=$value["descripcion"].': '.$value["cantidad"].' unidades';
                    $aItemInv["naturaleza"]='debito';
                    $aItemInv["tipoTercero"]='p';
                    $aItemInv["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
                    $aItemInv["fecha"]=$datos["fechaFactura"]; 
                    $aItemInv["saldoDebito"]=$aProductoCuenta[0]["costoPromedio"];
                    $aItemInv["saldoCredito"]=0;
                    $aItemInv["base"]=0;
                
                    $oItem=new Data("comprobante_items","idComprobanteItem"); 
                    foreach($aItemInv  as $keyInv => $valueInv){
                        $oItem->$keyInv=$valueInv; 
                    }
                    $oItem->guardar(); 
                    unset($oItem);



                }else{
                    $aItem["idCuentaContable"]=$aProductoCuenta[0]["venta"];

                }
                
                    $aItem["idComprobante"]=$idComprobante; 
                    $aItem["idCentroCosto"]=" ";
                    $aItem["idSubcentroCosto"]=" ";
                    $aItem["idTercero"]=$idT;
                    $aItem["descripcion"]=$value["descripcion"];
                    $aItem["naturaleza"]='credito';
                    $aItem["tipoTercero"]='p';
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

        $iva=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$datos["iva"])));

        if ($iva!="0" && $iva!="0,0") {

            $aIVA["idComprobante"]=$idComprobante; 
            $aIVA["idCuentaContable"]=$aCC[0]["idEmpresaCuenta"];
            $aIVA["idCentroCosto"]=" ";
            $aIVA["idSubcentroCosto"]=" ";
            $aIVA["idTercero"]=$idT;
            $aIVA["descripcion"]=$value["descripcion"];
            $aIVA["naturaleza"]='credito';
            $aIVA["tipoTercero"]='p';
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
            }

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
                            $aImpuesto["idSubcentroCosto"]=" ";
                            $aImpuesto["idTercero"]=$idT;
                            $aImpuesto["descripcion"]='Fact No. '.$datos["nroFactura"];
                            $aImpuesto["naturaleza"]='debito';
                            $aImpuesto["tipoTercero"]='p';
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
                                $aImpuesto["idSubcentroCosto"]=" ";
                                $aImpuesto["idTercero"]=$idT;
                                $aImpuesto["descripcion"]='Fact No. '.$datos["nroFactura"];
                                $aImpuesto["naturaleza"]=$aCuentaImpuestoP["naturaleza"];
                                $aImpuesto["tipoTercero"]='p';
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
                                $aImpuesto["idSubcentroCosto"]=" ";
                                $aImpuesto["idTercero"]=$idT;
                                $aImpuesto["descripcion"]='Fact No. '.$datos["nroFactura"];
                                $aImpuesto["naturaleza"]=$aCuentaImpuestoS["naturaleza"];
                                $aImpuesto["tipoTercero"]='p';
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
                                $aImpuesto["idSubcentroCosto"]=" ";
                                $aImpuesto["idTercero"]=$idT;
                                $aImpuesto["descripcion"]='Fact No. '.$datos["nroFactura"];
                                $aImpuesto["naturaleza"]='debito';
                                $aImpuesto["tipoTercero"]='p';
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
                
                $oLista=new Lista("banco_cuenta_contable");
                $oLista->setFiltro("idBancoCuentaContable","=",$datos["formaPagoFactura"]);
                $oLista->setFiltro("idEmpresa","=",$_SESSION["idEmpresa"]);
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
                    $aCompra["idCuentaContable"]=$aCompraCuenta[0]["idEmpresaCuenta"];
                    $aCompra["idCentroCosto"]=" ";
                    $aCompra["idSubcentroCosto"]=" ";
                    $aCompra["idTercero"]=$idT;
                    $aCompra["descripcion"]='Fact No. '.$datos["nroFactura"];
                    $aCompra["naturaleza"]='debito';
                    $aCompra["tipoTercero"]='p';
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


                    $consecutivoComprobante=0;
                }

}
$msg=true; 



echo json_encode(array("msg"=>$msg,"numeroComprobante"=>$consecutivoComprobante));

?>