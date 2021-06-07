<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );
$deducciones  = (isset($_REQUEST['baseImpuestos'] ) ? $_REQUEST['baseImpuestos'] : "" );
$deduccionesNuevas  = (isset($_REQUEST['impuesto'] ) ? $_REQUEST['impuesto'] : "" );
// print_r($datos);


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


$msg=true; 





echo json_encode(array("msg"=>$msg));

?>