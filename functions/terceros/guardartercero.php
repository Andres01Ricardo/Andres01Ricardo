<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );


$responsabilidad = (isset($_REQUEST['responsabilidad'] ) ? $_REQUEST['responsabilidad'] : "" );

 
$oItem=new Data("tercero","nit",$datos["nit"]); 
$aValidate=$oItem->getDatos(); 
unset($oItem); 

if(empty($aValidate)){

    if(!isset($_SESSION)){ session_start(); }


    // if ($datos["fechaNacimiento"]!='') {
    //     $nacimiento=$datos["fechaNacimiento"];
    // }
    // if ($datos["fechaNacimiento"]=='') {
    //     $nacimiento=null;
    // }
    $aDatos["tipoPersona"]=$datos["tipoPersona"]; 

    $aDatos["nit"]=$datos["nit"]; 

    $aDatos["digitoVerificador"]=$datos["digitoVerificador"]==""?0:$datos["digitoVerificador"]; 

    $aDatos["razonSocial"]=$datos["razonSocial"]; 

    $aDatos["email"]=$datos["email"]; 

    $aDatos["telefono"]=$datos["telefono"]; 

    $aDatos["idPais"]=42;

    $aDatos["idDepartamento"]=$datos["idDepartamento"]; 

    $aDatos["idCiudad"]=$datos["idCiudad"]; 

    $aDatos["responsableIva"]=$datos["responsableIva"]; 

    $aDatos["direccion"]=$datos["direccion"];

    $aDatos["fechaRegistro"]=date("Y-m-d H:i:s");

    $aDatos["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 

    if ($datos["periodoPago"]=="") {
        $aDatos["periodoPago"]='30';
     } 
     if ($datos["periodoPago"]!="") {
         $aDatos["periodoPago"]=$datos["periodoPago"];
     } 

    $aDatos["nombreComercial"]=$datos["nombreComercial"];

    if ($datos["contacto"]=="") {
        $aDatos["contacto"]="";
    }
    if ($datos["contacto"]!="") {
        $aDatos["contacto"]=$datos["contacto"];
    }
    
    $aDatos["celular"]=$datos["celular"];
    
    $aDatos["genero"]=$datos["genero"];
    
    $aDatos["nombreContactoFacturacion"]=$datos["nombreContactoFacturacion"];
    
    $aDatos["emailContactoFacturacion"]=$datos["emailContactoFacturacion"];
    
    $aDatos["telefonoContactoFacturacion"]=$datos["telefonoContactoFacturacion"];
    $aDatos["nombreContacto"]=$datos["nombreContactoOtro"];
    $aDatos["apellidosContacto"]=$datos["apellidosContactoOtro"];
    $aDatos["telefonoContacto"]=$datos["telefonoContactoOtro"];
    $aDatos["emailContacto"]=$datos["emailContactoOtro"];
    $aDatos["cargoContacto"]=$datos["cargoContactoOtro"];
    $aDatos["observaciones"]=$datos["observaciones"];
    $aDatos["vendedor"]=$datos["vendedor"];
    $aDatos["cobrador"]=$datos["cobrador"];
    $aDatos["actividadEconomica"]=$datos["actividadEconomica"];
    $aDatos["producto"]=$datos["producto"];
    // $aDatos["fechaNacimiento"]=$nacimiento;

    
    if ($datos['checkCliente']==1 and $datos['checkProveedor']!=1 and $datos['checkOtro']!=1) {
        $aDatos["tipoTercero"]=1;
        $tipoTercero=1;
    }
    if ($datos['checkCliente']!=1 and $datos['checkProveedor']==1 and $datos['checkOtro']!=1) {
        $aDatos["tipoTercero"]=2;
        $tipoTercero=2;
    }
    if ($datos['checkCliente']!=1 and $datos['checkProveedor']!=1 and $datos['checkOtro']==1) {
        $aDatos["tipoTercero"]=3;
        $tipoTercero=3;
    }
    if ($datos['checkCliente']==1 and $datos['checkProveedor']==1 and $datos['checkOtro']!=1) {
        $aDatos["tipoTercero"]=4;
        $tipoTercero=4;
    }
    if ($datos['checkCliente']==1 and $datos['checkProveedor']!=1 and $datos['checkOtro']==1) {
        $aDatos["tipoTercero"]=5;
        $tipoTercero=5;
    }
    if ($datos['checkCliente']!=1 and $datos['checkProveedor']==1 and $datos['checkOtro']==1) {
        $aDatos["tipoTercero"]=6;
        $tipoTercero=6;
    }
    if ($datos['checkCliente']==1 and $datos['checkProveedor']==1 and $datos['checkOtro']==1) {
        $aDatos["tipoTercero"]=7;
        $tipoTercero=7;
    }else{
        $aDatos["tipoTercero"]=7;
    }

    
    $oItem=new Data("tercero","idTercero");
    foreach($aDatos  as $key => $value){
        $oItem->$key=$value; 
    }
    $oItem->guardar(); 
    $idtercero=$oItem->ultimoId(); 
    unset($oItem); 


    foreach ($responsabilidad as $keyR => $valueR) {

        if($valueR["check"]==1){
            $oItem=new Data("responsabilidad_fiscal_tercero","idResponsabilidadFiscalTercero"); 
            $oItem->idResponsabilidadFiscal=$keyR; 
            $oItem->idTercero=$idtercero; 
            $oItem->tipoTercero=$tipoTercero;
            $oItem->guardar(); 
            unset($oItem); 
        }
    }

    foreach ($item as $key => $value) {

        if($value["estado"]==1){
            $oItem=new Data("tercero_empresa","idTerceroEmpresa");
            $oItem->idTercero=$idtercero;        
            $oItem->idEmpresa=$value["idEmpresa"]; 
            $oItem->guardar(); 
            unset($oItem); 
        }

    }


    if ($datos["terceroEmpresa"]!="") {
        $oItem=new Data("tercero_empresa","idTerceroEmpresa");
        $oItem->idTercero=$idtercero;        
        $oItem->idEmpresa=$datos["terceroEmpresa"]; 
        $oItem->guardar(); 
        unset($oItem); 
    }

    $msg=true; 
}
else{

    $msg=false; 

}

echo json_encode(array("msg"=>$msg));

?>