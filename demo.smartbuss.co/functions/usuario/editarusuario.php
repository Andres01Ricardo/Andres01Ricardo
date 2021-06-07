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
//        var_dump("verdadero");                                                
            $sFoto = $nombre_archivo;
        }
        else
        {
//        	var_dump($sTemporal, $directorioTmp.$nombre_archivo, "falso", move_uploaded_file($sTemporal, '/'.$directorioTmp.$nombre_archivo)); 
            $sFoto = "";
        }
    
} 

$aDatos["nombreUsuario"]=$datos["nombres"]; 
$aDatos["apellidoUsuario"]=$datos["apellidos"]; 
$aDatos["tipoDocumento"]=$datos["tipoDocumento"]; 
$aDatos["numeroDocumento"]=$datos["numeroDocumento"]; 
$aDatos["genero"]=$datos["genero"]; 
$aDatos["correo"]=$datos["correo"]; 
$aDatos["telefono"]=$datos["telefono"]; 
$aDatos["direccion"]=$datos["direccion"]; 
$aDatos["idDepartamentoResidencia"]=$datos["idDepartamentoResidencia"]; 
$aDatos["idCiudadResidencia"]=$datos["idCiudadResidencia"]; 
$aDatos["idRol"]=$datos["idRol"]; 
$aDatos["foto"]=$sFoto; 
$aDatos["ingresoPerfilEmpresa"]=$datos["ingresoEmpresa"]; 

$oItem=new Data("usuario","idUsuario",$id); 
foreach($aDatos  as $key => $value){
	$oItem->$key=$value; 
}
$oItem->guardar(); 
unset($oItem); 

echo json_encode(array("msg"=>true));
?>