<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );



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

$idCotizacion=$datos["idCotizacion"];

$oLista = new Lista('cotizacion_item');

$oLista->setFiltro("idCotizacion","=",$idCotizacion); 

$item=$oLista->getLista();

unset($oLista);


$oLista = new Data('cotizacion','idCotizacion',$idCotizacion);

$aCotizacionTotal=$oLista->getDatos();

unset($oLista);




if(!isset($_SESSION)){ session_start(); }

$aDatos["fechaRegistro"]=date("Y-m-d H:i:s");

$aDatos["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 

$aDatos["idEmpresa"]=$aCotizacionTotal["idEmpresa"]; 

$aDatos["fechaFactura"]=$datos["fechaFactura"]; 

$aDatos["idCliente"]=$aCotizacionTotal["idCliente"]; 

$aDatos["nroFactura"]=$datos["nroFactura"]; 

$aDatos["archivo"]=$sFoto; 

$aDatos["subtotal"]=str_replace("$", "", str_replace(",", "", $aCotizacionTotal["subtotal"])); 

$aDatos["descuento"]=str_replace("$", "", str_replace(",", "", $aCotizacionTotal["descuento"])); 

$aDatos["iva"]=str_replace("$", "", str_replace(",", "", $aCotizacionTotal["iva"])); 

$aDatos["total"]=str_replace("$", "", str_replace(",", "", $aCotizacionTotal["total"])); 

$aDatos["estado"]=1; 

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

    $aItem["iva"]=$value["iva"]; 

    $aItem["valorUnitario"]=str_replace("$", "", str_replace(",", "", $value["valorUnitario"])); 

    $aItem["subtotal"]=str_replace("$", "", str_replace(",", "", $value["subtotal"])); 

    $aItem["total"]=str_replace("$", "", str_replace(",", "", $value["total"]));



    $oItem=new Data("factura_venta_item","idFacturaVentaItem"); 

    foreach($aItem  as $key => $value){

        $oItem->$key=$value; 

    }

    $oItem->guardar(); 

    unset($oItem);

}



$cDatos["estado"] = 3;

    $oItem=new Data("cotizacion","idCotizacion",$idCotizacion); 
    foreach($cDatos  as $key => $value){
    $oItem->$key=$value; 
    }
    $oItem->guardar(); 
    unset($oItem);




$cLista = new Lista('usuario');

$cLista->setFiltro("idRol","=",'2');

$colista=$cLista->getLista();

foreach ($colista as $key => $contador) {


   
    $correoContador = $contador["correo"];

    $cmensaje="<p>Estimado ".$contador["nombreUsuario"]." ".$contador["apellidoUsuario"]." <br>

    El usuario ".$_SESSION["nombreUsuario"]." ".$_SESSION["apellidoUsuario"]." ha facturado una cotizacion de venta <br><br> </p>"; 




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

    El usuario ".$_SESSION["nombreUsuario"]." ".$_SESSION["apellidoUsuario"]." ha facturado una cotizacion de venta <br><br> </p>"; 




    $sEmail["correo"]=$super["correo"]; 
    

    $sEmail["asunto"]="Factura de venta enviada"; 

    $sEmail["mensaje"]=$smensaje; 

    $sControl=new Control();

    // $cControl->enviarCorreo($sEmail);
    // unset($sControl);

    $sDatos["fechaNotificacion"]=date("Y-m-d H:m:s");
    $sDatos["idUsuarioRegistra"] = $_SESSION["idUsuario"];
    $sDatos["idUsuarioNotificado"] =$super["idUsuario"];
    $sDatos["notificacion"] =  "El usuario ".$_SESSION["nombreUsuario"]." ".$_SESSION["apellidoUsuario"]." ha facturado una cotizacion de venta";
    

    $oItem=new Data("notificacion","idNotificacion"); 
    foreach($sDatos  as $key => $svalue){
    $oItem->$key=$svalue; 
    }
    $oItem->guardar(); 
    unset($oItem);
}




$msg=true; 



echo json_encode(array("msg"=>$msg));

?>