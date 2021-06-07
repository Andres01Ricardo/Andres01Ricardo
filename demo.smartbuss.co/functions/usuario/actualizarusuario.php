<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );
$id  = (isset($_REQUEST['id'] ) ? $_REQUEST['id'] : "" );


if( isset($_FILES['file']) && $_FILES['file'] != 'undefined')
    {
               
        $sNombre = $_FILES['file']['name'];                
        $sExtension = substr(strrchr($sNombre, '.'), 1);
        $sTemporal = $_FILES['file']['tmp_name'];
        
        $nombreEncript = uniqid(); 
        
        $nombre_archivo = "{$nombreEncript}.{$sExtension}"; 
        
        $directorioTmp = 'USUARIOS/'.$directorio;
        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  

        if(move_uploaded_file($sTemporal, "../../".$directorioTmp.$nombre_archivo))
        {	                                             
            $sFoto = 'USUARIOS/'.$nombre_archivo;
        }
        else
        {
            $sFoto = "";
        }
    
} 
if(!isset($_SESSION)){ session_start(); }
$aDatos["nombreUsuario"]=$datos["nombres"]; 
$aDatos["apellidoUsuario"]=$datos["apellidos"]; 
$aDatos["tipoDocumento"]=$datos["tipoDocumento"];  
$aDatos["genero"]=$datos["genero"]; 
$aDatos["correo"]=$datos["correo"]; 
$aDatos["telefono"]=$datos["telefono"]; 
$aDatos["direccion"]=$datos["direccion"]; 
$aDatos["idDepartamentoResidencia"]=$datos["idDepartamentoResidencia"]; 
$aDatos["idCiudadResidencia"]=$datos["idCiudadResidencia"]; 
if($sFoto!=""){
    $aDatos["foto"]=$sFoto; 
    $_SESSION["foto"]=$sFoto;
}

$oItem=new Data("usuario","idUsuario",$datos["idUsuario"]); 
foreach($aDatos  as $key => $value){
	$oItem->$key=$value; 
}
$oItem->guardar(); 
unset($oItem); 

if($_SESSION["idRol"]!=2&&$_SESSION["idRol"]!=1){

}
echo json_encode(array("msg"=>true));
?>