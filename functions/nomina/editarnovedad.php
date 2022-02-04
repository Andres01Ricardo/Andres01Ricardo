<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

if(!isset($_SESSION)){ session_start(); }


if ($datos["tipoNovedad"]==4) {
    $aDatos["fechaSolicitud"]=$datos["fechaSolicitudVacaciones"]; 

    $aDatos["fechaInicio"]=$datos["fechaInicioVacaciones"]; 

    $aDatos["fechaFin"]=$datos["fechaFinVacaciones"]; 

    $aDatos["fechaReinicioActividades"]=$datos["fechaReinicioVacaciones"]; 

    $aDatos["cantidadDias"]=$datos["cantidadDiasVacaciones"]; 


    // $aDatos["estado"]=1; 

    $oItem=new Data("empleado_vacaciones","idEmpresaNovedad",$datos["idNovedad"]); 
    foreach($aDatos  as $key => $value){
        $oItem->$key=$value; 
    }
    $oItem->guardar();  
    unset($oItem);


    $oItem=new Data("empleado_vacaciones","idEmpresaNovedad",$datos["idNovedad"]);
    $empleadoV=$oItem->getDatos();
    unset($oItem);


    $datosNovedad["fechaRegistro"]=date('Y-m-d H:i:s');
    $datosNovedad["idUsuarioRegistra"]=$_SESSION['idUsuario'];

    $oItem=new Data("empresa_novedad","idEmpresaNovedad",$empleadoV["idEmpresaNovedad"]); 
    foreach($datosNovedad  as $keyN => $valueN){
        $oItem->$keyN=$valueN; 
    }
    $oItem->guardar();  
    unset($oItem);


    
}


if ($datos["tipoNovedad"]==7) {
    $aDatosA["idAuxilioExtralegal"]=$datos["idAuxilioExtralegal"]; 

    $aDatosA["otroAuxilio"]=$datos["otroAuxilioExtralegal"]; 

    $aDatosA["valorAuxilio"]=str_replace("$", "", str_replace(".", "", $datos["valorAuxilioExtralegal"])); 




    $oItem=new Data("empleado_auxilios_extralegales","idEmpresaNovedad",$datos["idNovedad"]); 

    foreach($aDatosA  as $keyA => $valueA){
        $oItem->$keyA=$valueA; 
    }
    $oItem->guardar();  
    unset($oItem);





    $oItem=new Data("empleado_auxilios_extralegales","idEmpresaNovedad",$datos["idNovedad"]);
    $empleadoV=$oItem->getDatos();
    unset($oItem);


    $datosNovedad["fechaRegistro"]=date('Y-m-d H:i:s');
    $datosNovedad["idUsuarioRegistra"]=$_SESSION['idUsuario'];

    $oItem=new Data("empresa_novedad","idEmpresaNovedad",$empleadoV["idEmpresaNovedad"]); 
    foreach($datosNovedad  as $keyN => $valueN){
        $oItem->$keyN=$valueN; 
    }
    $oItem->guardar();  
    unset($oItem);



    
}

    


    $msg=true; 



echo json_encode(array("msg"=>$msg));

?>