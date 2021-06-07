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
        
        $directorioTmp = 'INCAPACIDADMEDICA/';
        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  

        if(move_uploaded_file($sTemporal, '../../'.$directorioTmp.$nombre_archivo))
        {	                                             
            $sFoto = 'INCAPACIDADMEDICA/'.$nombre_archivo;
        }
        else
        {
            $sFoto = "";
        }
    
} 


if(!isset($_SESSION)){ session_start(); }

$aData["idEmpresa"]=$_SESSION["idEmpresa"];
$aData["idEmpleado"]=$datos["idEmpleado"];
$aData["fechaRegistro"]=date("Y-m-d H:i:s");
$aData["idNovedades"]=5;
$aData["idUsuarioRegistra"]=$_SESSION["idUsuario"];
$aData["estado"]=1;

$oItem=new Data("empresa_novedad","idEmpresaNovedad"); 
foreach ($aData as $key => $value) {
  $oItem->$key=$value; 
}
$oItem->guardar(); 
$idNovedad=$oItem->ultimoId();
unset($oItem); 

$aHoras["idEmpresaNovedad"]=$idNovedad; 
$aHoras["idEmpleado"]=$datos["idEmpleado"]; 
$aHoras["idTipoIncapacidad"]=$datos["tipoIncapacidad"]; 
$aHoras["fechaInicio"]=$datos["fechaInicio"]; 
$aHoras["fechaFinal"]=$datos["fechaFinal"]; 
$aHoras["anexo"]=$sFoto; 
$aHoras["descripcion"]=$datos["descripcion"]; 
$aHoras["estado"]=1;

$oItem=new Data("empleado_incapacidad_medica","idEmpleadoIncapacidadMedica"); 
foreach ($aHoras as $key => $value) {
  $oItem->$key=$value; 
}
$oItem->guardar(); 
unset($oItem); 


echo json_encode(array("msg"=>true));
?>