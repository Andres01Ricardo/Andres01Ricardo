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
    $aDatos["tipoTercero"]=7;
    
    $oItem=new Data("tercero","idTercero");
    foreach($aDatos  as $key => $value){
        $oItem->$key=$value; 
    }
    $oItem->guardar(); 
    $idtercero=$oItem->ultimoId(); 
    unset($oItem); 

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
}else{
        $idTercero=$aValidate["idTercero"];
        foreach ($item as $key => $value) {

            $oLista=new Lista("tercero_empresa");
            $oLista->setFiltro("idTercero","=",$idTercero);
            $oLista->setFiltro("idEmpresa","=",$value["idEmpresa"]);
            $terceroE=$oLista->getLista();
            unset($oLista);

            if (empty($terceroE)) {
                
                if($value["estado"]==1){
                    $oItem=new Data("tercero_empresa","idTerceroEmpresa"); 
                    $oItem->idTercero=$idTercero; 
                    $oItem->idEmpresa=$value["idEmpresa"]; 
                    $oItem->guardar(); 
                    unset($oItem); 
                }
            }
        }
        $msg=true;


}

echo json_encode(array("msg"=>$msg));

?>