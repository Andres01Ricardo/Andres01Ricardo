<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );


$responsabilidad = (isset($_REQUEST['responsabilidad'] ) ? $_REQUEST['responsabilidad'] : "" );

// print_r($datos);

if ($datos["clasificacion"]==1) {
   $tipo='cliente';
   $tipoT=1;
   $oItem=new Data("cliente","nit",$datos["nit"]);
   $aValidate=$oItem->getDatos();
   unset($oItem); 
}elseif ($datos["clasificacion"]==2) {
    $tipo='proveedor';
    $tipoT=2;
    $oItem=new Data("proveedor","nit",$datos["nit"]);
    $aValidate=$oItem->getDatos(); 
    unset($oItem);
}elseif ($datos["clasificacion"]==3) {
    $tipo='otro';
    $tipoT=3;
    $oItem=new Data("otros","nit",$datos["nit"]);
    $aValidate=$oItem->getDatos();
    unset($oItem); 
}


 

if(empty($aValidate)){

    if(!isset($_SESSION)){ session_start(); }


        if ($datos["fechaNacimiento"]!='') {
            $nacimiento=$datos["fechaNacimiento"];
        }
        if ($datos["fechaNacimiento"]=='') {
            $nacimiento=null;
        }

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

    $aDatos["periodoPago"]=$datos["periodoPago"]; 

    $aDatos["nombreComercial"]=$datos["nombreComercial"];
    $aDatos["contacto"]=$datos["contacto"];
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
    $aDatos["fechaNacimiento"]=$nacimiento;
    // $aDatos["tipoTercero"]=$tipo;

    if ($tipoT==1) {
        $oItem=new Data("cliente","idCliente");
        foreach($aDatos  as $key => $value){
            $oItem->$key=$value; 
        }
        $oItem->guardar(); 
        $idtercero=$oItem->ultimoId(); 
        unset($oItem);    
    }
    if ($tipoT==2) {
        $oItem=new Data("proveedor","idProveedor");
        foreach($aDatos  as $key => $value){
            $oItem->$key=$value; 
        }
        $oItem->guardar(); 
        $idtercero=$oItem->ultimoId(); 
        unset($oItem);    
    }
    if ($tipoT==3) {
        $oItem=new Data("otros","idOtro");
        foreach($aDatos  as $key => $value){
            $oItem->$key=$value; 
        }
        $oItem->guardar(); 
        $idtercero=$oItem->ultimoId(); 
        unset($oItem);    
    }
    


    foreach ($responsabilidad as $keyR => $valueR) {

        if($valueR["check"]==1){

        $oItem=new Data("responsabilidad_fiscal_tercero","idResponsabilidadFiscalTercero"); 

        $oItem->idResponsabilidadFiscal=$keyR; 

        $oItem->idTercero=$idtercero; 

        if ($datos["clasificacion"]==1) {
           $oItem->tipoTercero='cliente';
        }elseif ($datos["clasificacion"]==2) {
           $oItem->tipoTercero='proveedor';       
        }elseif ($datos["clasificacion"]==3) {
           $oItem->tipoTercero='otros';   
        }

        $oItem->guardar(); 

        unset($oItem); 

        }

    }




    foreach ($item as $key => $value) {

        if($value["estado"]==1){

        // $oItem=new Data("tercero_empresa","idClienteEmpresa");
        if ($datos["clasificacion"]==1) {
           $oItem=new Data("cliente_empresa","idClienteEmpresa");
           $oItem->idCliente=$idtercero;
        }elseif ($datos["clasificacion"]==2) {
            $oItem=new Data("proveedor_empresa","idProveedorEmpresa");
            $oItem->idProveedor=$idtercero;  
        }elseif ($datos["clasificacion"]==3) {
            $oItem=new Data("otro_empresa","idOtroEmpresa");
            $oItem->idOtro=$idtercero;
        }

        // $oItem->idTercero=$idTercero;        

        $oItem->idEmpresa=$value["idEmpresa"]; 

        $oItem->guardar(); 

        unset($oItem); 

        }

    }





    $msg=true; 
}
else{

    $msg=false; 

}

 



echo json_encode(array("msg"=>$msg));

?>