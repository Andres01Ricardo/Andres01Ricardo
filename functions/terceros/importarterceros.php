<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );
$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );
// $comprobante  = (isset($_REQUEST['comprobante'] ) ? $_REQUEST['comprobante'] : "" );


// print_r($datos);

// print_r($item);

if(!isset($_SESSION)){ session_start(); }


foreach ($item as $key => $value) {
    
    $oItem=new Data("tercero","nit",$value["nit"]); 
    $aValidate=$oItem->getDatos(); 
    unset($oItem); 

    if(!empty($aValidate)){
        $oItem=new Lista("tercero_empresa");
        $oItem->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
        $oItem->setFiltro("idTercero","=",$aValidate["idTercero"]);
        $aTerceroE=$oItem->getLista();
        unset($oItem); 

        if (empty($aTerceroE)) {
            $oItem=new Data("tercero_empresa","idTerceroEmpresa");
            $oItem->idTercero=$aValidate["idTercero"];        
            $oItem->idEmpresa=$datos["idEmpresa"]; 
            $oItem->guardar(); 
            unset($oItem);
        }
    }else{

    $aDatos["tipoPersona"]=$value["digitoVerificador"]==0?1:2; 
    $aDatos["nit"]=$value["nit"]; 
    $aDatos["digitoVerificador"]=$value["digitoVerificador"];
    $aDatos["razonSocial"]=$value["razonSocial"]; 
    $aDatos["email"]='nocorreo@n.com';
    if (strlen($value["telefono"])>10) {
        $aDatos["telefono"]=$value["telefono"]; 
        $aDatos["celular"]=0;
    }
    if (strlen($value["telefono"])<11) {
        $aDatos["telefono"]=$value["telefono"]; 
        $aDatos["celular"]=$value["telefono"];
    }
    $ciudad=trim(explode("-", $value["ciudad"])[0]);
    
    $oItem=new Lista("ciudad");
    $oItem->setFiltro("nombre","like","%".$value["ciudad"]."%");
    $aCiudad=$oItem->getLista();
    unset($oItem); 
    if (!empty($aCiudad)) {
        $oItem=new Data("departamento","idDepartamento",$aCiudad[0]["idDepartamento"]); 
        $aDepartamento=$oItem->getDatos(); 
        unset($oItem); 
        
        $aDatos["idDepartamento"]=$aCiudad[0]["idDepartamento"];
        $aDatos["idCiudad"]=$aCiudad[0]["idCiudad"]; 
        $aDatos["idPais"]=$aDepartamento["idPais"];
    }
    if (empty($aCiudad)) {
        
        $aDatos["idDepartamento"]=39;
        $aDatos["idCiudad"]=1113;
        $aDatos["idPais"]=195;
    }

    
    $aDatos["responsableIva"]=1;
    $aDatos["direccion"]=$value["direccion"];
    $aDatos["fechaRegistro"]=date("Y-m-d H:i:s");
    $aDatos["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
    $aDatos["periodoPago"]='30';
    $aDatos["nombreComercial"]=$value["razonSocial"];
    
    $aDatos["genero"]=1;
    $aDatos["tipoTercero"]=7;
    
    $oItem=new Data("tercero","idTercero");
    foreach($aDatos  as $key => $value){
        $oItem->$key=$value; 
    }
    $oItem->guardar(); 
    $idtercero=$oItem->ultimoId(); 
    unset($oItem); 



    $oItem=new Data("tercero_empresa","idTerceroEmpresa");
    $oItem->idTercero=$idtercero;
    $oItem->idEmpresa=$datos["idEmpresa"]; 
    $oItem->guardar(); 
    unset($oItem);

    }

}
      


    $msg=true; 



    echo json_encode($msg);

?>