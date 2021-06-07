<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );
$datosRepresentante  = (isset($_REQUEST['representante'] ) ? $_REQUEST['representante'] : "" );
$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );
$idRepresentanteLegal  = (isset($_REQUEST['idRepresentanteLegal'] ) ? $_REQUEST['idRepresentanteLegal'] : "" );

$sFoto = "";
$sRepresentante = "";
$sCamara = "";
$sRut = "";

if( isset($_FILES['cedula']) && $_FILES['file'] != 'undefined')
    {
               
        $sNombre = $_FILES['file']['name'];                
        $sExtension = substr(strrchr($sNombre, '.'), 1);
        $sTemporal = $_FILES['file']['tmp_name'];
        
        $nombreEncript = uniqid(); 
        
        $nombre_archivo = "{$nombreEncript}.{$sExtension}"; 
        
        $directorioTmp = $URL.'REPRESENTANTE/'.$directorio;
        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  

        if(move_uploaded_file($sTemporal, '/'.$directorioTmp.$nombre_archivo))
        {	
            $sRepresentante = 'REPRESENTANTE/'.$nombre_archivo;
        }
    
} 
if( isset($_FILES['logo']) && $_FILES['logo'] != 'undefined')
    {
               
        $sNombre = $_FILES['logo']['name'];                
        $sExtension = substr(strrchr($sNombre, '.'), 1);
        $sTemporal = $_FILES['logo']['tmp_name'];
        
        $nombreEncript = uniqid(); 
        
        $nombre_archivo = "{$nombreEncript}.{$sExtension}"; 
        
        $directorioTmp = $URL.'EMPRESA/'.$directorio;
        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  

        if(move_uploaded_file($sTemporal, '/'.$directorioTmp.$nombre_archivo))
        {   
            $sFoto = 'EMPRESA/'.$nombre_archivo;
        }
    
} 
if( isset($_FILES['camaraComercio']) && $_FILES['camaraComercio'] != 'undefined')
    {
               
        $sNombre = $_FILES['camaraComercio']['name'];                
        $sExtension = substr(strrchr($sNombre, '.'), 1);
        $sTemporal = $_FILES['camaraComercio']['tmp_name'];
        
        $nombreEncript = uniqid(); 
        
        $nombre_archivo = "{$nombreEncript}.{$sExtension}"; 
        
        $directorioTmp = $URL.'CAMARACOMERCIO/'.$directorio;
        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  

        if(move_uploaded_file($sTemporal, '/'.$directorioTmp.$nombre_archivo))
        {   
            $sCamara = 'CAMARACOMERCIO/'.$nombre_archivo;
        }
    
} 
if( isset($_FILES['rut']) && $_FILES['rut'] != 'undefined')
    {
               
        $sNombre = $_FILES['rut']['name'];                
        $sExtension = substr(strrchr($sNombre, '.'), 1);
        $sTemporal = $_FILES['rut']['tmp_name'];
        
        $nombreEncript = uniqid(); 
        
        $nombre_archivo = "{$nombreEncript}.{$sExtension}"; 
        
        $directorioTmp = $URL.'RUT/'.$directorio;
        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  

        if(move_uploaded_file($sTemporal, '/'.$directorioTmp.$nombre_archivo))
        {   
            $sRut = 'RUT/'.$nombre_archivo;
        }
    
} 

$aDatos["nit"]=$datos["NIT"]; 
$aDatos["digitoVerificador"]=$datos["digitoVerificador"]==""?0:$datos["digitoVerificador"]; 
$aDatos["razonSocial"]=$datos["razonSocial"]; 
$aDatos["email"]=$datos["correo"]; 
$aDatos["telefono"]=$datos["telefono"]; 
$aDatos["idDepartamento"]=$datos["idDepartamento"]; 
$aDatos["idCiudad"]=$datos["idCiudad"]; 
$aDatos["direccion"]=$datos["direccion"]; 
if($sFoto!=""){
$aDatos["logo"]=$sFoto;     
}
if($sRut!=""){
$aDatos["rut"]=$sRut;  
}
if($sCamara!=""){
$aDatos["camaraComercio"]=$sCamara; 
}

$oItem=new Data("empresa","idEmpresa",$idEmpresa); 
foreach($aDatos  as $key => $value){
    $oItem->$key=$value; 
}
$oItem->guardar(); 
unset($oItem);


$aRepresentante["tipoDocumento"]=$datosRepresentante["tipoDocumento"];
$aRepresentante["numeroDocumento"]=$datosRepresentante["numeroDocumento"];  
$aRepresentante["nombres"]=$datosRepresentante["nombres"]; 
$aRepresentante["apellidos"]=$datosRepresentante["apellidos"]; 
$aRepresentante["email"]=$datosRepresentante["correo"]; 
$aRepresentante["telefono"]=$datosRepresentante["telefono"]; 
$aRepresentante["cedula"]=$sRepresentante; 
$aRepresentante["idEmpresa"]=$idEmpresa; 

$oItem=new Data("representante_legal","idRepresentanteLegal",$idRepresentanteLegal); 
foreach($aRepresentante  as $key => $value){
    $oItem->$key=$value; 
}
$oItem->guardar(); 
unset($oItem);

$oItem=new Data("empresa","idEmpresa",$idEmpresa); 
$aEmpresa=$oItem->getDatos(); 
unset($oItem); 

$oItem=new Data("usuario","numeroDocumento",$aEmpresa["nit"].$aEmpresa["digitoVerificador"]); 
$aUser=$oItem->getDatos(); 
unset($oItem); 

$aUsuario["nombreUsuario"]=$datos["razonSocial"];
$aUsuario["correo"]=$datos["correo"]; 
$aUsuario["telefono"]=$datos["telefono"]; 
$aUsuario["direccion"]=$datos["direccion"]; 
$aUsuario["idDepartamentoResidencia"]=$datos["idDepartamento"]; 
$aUsuario["idCiudadResidencia"]=$datos["idCiudad"]; 
if($sFoto!=""){
    $aUsuario["foto"]=$sFoto; 
}


$oItem=new Data("usuario","idUsuario",$aUser["idUsuario"]); 
foreach($aUsuario  as $key => $value){
    $oItem->$key=$value; 
}
$oItem->guardar(); 
unset($oItem);

$msg=true; 


echo json_encode(array("msg"=>$msg));
?>