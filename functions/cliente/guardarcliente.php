<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );







$oItem=new Data("cliente","nit",$datos["nit"]); 

$aValidate=$oItem->getDatos(); 

unset($oItem); 

if(empty($aValidate)){

    if(!isset($_SESSION)){ session_start(); }



    $aDatos["tipoPersona"]=$datos["tipoPersona"]; 

    $aDatos["nit"]=$datos["nit"]; 

    $aDatos["digitoVerificador"]=$datos["digitoVerificador"]==""?"":$datos["digitoVerificador"]; 

    $aDatos["razonSocial"]=$datos["razonSocial"]; 

    $aDatos["email"]=$datos["email"]; 

    $aDatos["telefono"]=$datos["telefono"]; 

    $aDatos["idDepartamento"]=$datos["idDepartamento"]; 

    $aDatos["idCiudad"]=$datos["idCiudad"]; 

    $aDatos["direccion"]=$datos["direccion"]; 

    $aDatos["fechaRegistro"]=date("Y-m-d H:i:s");

    $aDatos["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 

    $aDatos["estado"]=1; 



    $oItem=new Data("cliente","idCliente"); 

    foreach($aDatos  as $key => $value){

        $oItem->$key=$value; 

    }

    $oItem->guardar(); 

    $idCliente=$oItem->ultimoId(); 

    unset($oItem);



    foreach ($item as $key => $value) {

        if($value["estado"]==1){

        $oItem=new Data("cliente_empresa","idClienteEmpresa"); 

        $oItem->idCliente=$idCliente; 

        $oItem->idEmpresa=$value["idEmpresa"]; 

        $oItem->guardar(); 

        unset($oItem); 

        }

    }





    $msg=true; 

}else{

    $msg=false; 

}

 



echo json_encode(array("msg"=>$msg));

?>