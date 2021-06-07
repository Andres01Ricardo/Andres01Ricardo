<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");
include_once($CLASS . "control.php");

$oControl=new Control();

date_default_timezone_set("America/Bogota"); 

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );
$decrip["cadena"]=$datos["idCuenta"]; 
$id=$oControl->desencriptar($decrip); 

if( isset($_FILES['file']) && $_FILES['file'] != 'undefined')
    {
               
        $sNombre = $_FILES['file']['name'];                
        $sExtension = substr(strrchr($sNombre, '.'), 1);
        $sTemporal = $_FILES['file']['tmp_name'];
        
        $nombreEncript = uniqid(); 
        
        $nombre_archivo = "{$nombreEncript}.{$sExtension}"; 
        
        $directorioTmp = 'EXTRACTOBANCARIO/';
        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  
        
        if(move_uploaded_file($sTemporal, "../../".$directorioTmp.$nombre_archivo))
        {	                                               
            $sArchivo = 'EXTRACTOBANCARIO/'.$nombre_archivo;
        }
        else
        {
            $sArchivo = "";
        }
    
} 
$periodo=explode("-",$datos["periodo"]); 
if(!isset($_SESSION)){ session_start(); }


$oLista = new Lista('cuenta_bancaria_extracto');
$oLista->setFiltro("idCuentaBancaria","=",$id);
$oLista->setFiltro("mesPeriodo","=",$periodo[0]);
$oLista->setFiltro("anioPeriodo","=",$periodo[1]);
$lista=$oLista->getLista();


$datos["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
$datos["fechaRegistro"]=date("Y-m-d H:i:s"); 
$datos["idCuentaBancaria"]=$id; 
$datos["mesPeriodo"]=$periodo[0]; 
$datos["anioPeriodo"]=$periodo[1]; 
$datos["extracto"]=$sArchivo; 

if(count($lista)>0){
	$oItem=new Data("cuenta_bancaria_extracto","idCuentaBancariaExtracto",$lista[0]["idCuentaBancariaExtracto"]);
}else{
	$oItem=new Data("cuenta_bancaria_extracto","idCuentaBancariaExtracto"); 	
}
foreach($datos  as $key => $value){
    $oItem->$key=$value; 
}
$oItem->guardar(); 
unset($oItem);

$msg=true; 

echo json_encode(array("msg"=>$msg));
?>