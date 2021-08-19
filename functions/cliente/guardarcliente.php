<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );



$oItem=new Data("tercero","nit",$datos["nit"]); 

$aValidate=$oItem->getDatos(); 

unset($oItem); 
if(!isset($_SESSION)){ session_start(); }

if(empty($aValidate)){

    

    $aDatos["tipoPersona"]=$datos["tipoPersona"]; 
    $aDatos["nit"]=$datos["nit"]; 
    $aDatos["digitoVerificador"]=$datos["digitoVerificador"]==""?"0":$datos["digitoVerificador"]; 
    $aDatos["razonSocial"]=$datos["razonSocial"]; 
    $aDatos["email"]=$datos["email"]; 
    $aDatos["telefono"]=$datos["telefono"]; 
    $aDatos["idDepartamento"]=$datos["idDepartamento"]; 
    $aDatos["idCiudad"]=$datos["idCiudad"]; 
    $aDatos["direccion"]=$datos["direccion"]; 
    $aDatos["fechaRegistro"]=date("Y-m-d H:i:s");
    $aDatos["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
    $aDatos["estado"]=1; 
    if ($datos["checkProveedor"]==1) {
        $aDatos["tipoTercero"]=4; 
    }
    if ($datos["checkProveedor"]!=1) {
        $aDatos["tipoTercero"]=1; 
    }
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
        $oItem->idEmpresa=$value["idEmpresa"]; 
        $oItem->guardar(); 
        unset($oItem); 
        }
    }
    $msg=true; 

}else{
    if ($aValidate['tipoTercero']==1 || $aValidate['tipoTercero']==4) {
        $msg=false;
    }
    if ($aValidate['tipoTercero']==2) {
        $aDatos["tipoPersona"]=$datos["tipoPersona"]; 
        $aDatos["nit"]=$datos["nit"]; 
        $aDatos["digitoVerificador"]=$datos["digitoVerificador"]==""?"0":$datos["digitoVerificador"]; 
        $aDatos["razonSocial"]=$datos["razonSocial"]; 
        $aDatos["email"]=$datos["email"]; 
        $aDatos["telefono"]=$datos["telefono"]; 
        $aDatos["idDepartamento"]=$datos["idDepartamento"]; 
        $aDatos["idCiudad"]=$datos["idCiudad"]; 
        $aDatos["direccion"]=$datos["direccion"]; 
        // $aDatos["fechaRegistro"]=date("Y-m-d H:i:s");
        // $aDatos["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aDatos["estado"]=1; 
        // if ($datos["checkProveedor"]==1) {
        //     $aDatos["tipoTercero"]=4; 
        // }
        $aDatos["tipoTercero"]=4; 

        $aDatos["responsableIva"]=2;
        $aDatos["periodoPago"]=30; 

        $oItem=new Data("tercero","idTercero",$aValidate['idTercero']); 
        foreach($aDatos  as $key => $value){
            $oItem->$key=$value; 
        }
        $oItem->guardar(); 
        $idTercero=$aValidate['idTercero']; 
        unset($oItem);
        foreach ($item as $key => $value) {
            if($value["estado"]==1){
            $oItem=new Data("tercero_empresa","idTerceroEmpresa"); 
            $oItem->idTercero=$idTercero; 
            $oItem->idEmpresa=$value["idEmpresa"]; 
            $oItem->guardar(); 
            unset($oItem); 
            }
        }
        $msg=true;
    }


}


echo json_encode(array("msg"=>$msg));

?>