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
        
        $directorioTmp = 'RETIRO/';
        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  

        if(move_uploaded_file($sTemporal, '../../'.$directorioTmp.$nombre_archivo))
        {	                                             
            $sFoto = 'RETIRO/'.$nombre_archivo;
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
$aData["idNovedades"]=10;
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
$aHoras["fechaRetiro"]=$datos["fechaRetiro"]; 
$aHoras["retiroVoluntario"]=$datos["retiroVoluntario"]; 
$aHoras["anexoRetiro"]=$sFoto; 
$aHoras["motivoRetiro"]=$datos["motivo"]; 

$oItem=new Data("empleado_retiro","idEmpleadoRetiro"); 
foreach ($aHoras as $key => $value) {
  $oItem->$key=$value; 
}
$oItem->guardar(); 
unset($oItem); 

$oLista = new Lista('empleado_usuario');
$oLista->setFiltro("idEmpleado","=",$datos["idEmpleado"]);
$lista=$oLista->getLista();
unset($oLista);

if(!empty($lista)){
	$oItem=new Data("usuario","idUsuario",$lista[0]["idUsuario"]); 
	$oItem->estado=0;
	$oItem->ingresoPlataforma=0;
	$oItem->cambiarClave=1;
	$oItem->guardar(); 
	unset($oItem);
}

$oLista = new Lista('empleado_informacion_laboral');
$oLista->setFiltro("idEmpleado","=",$datos["idEmpleado"]);
$oLista->setFiltro("idEmpresa","=",$_SESSION["idEmpresa"]);
$oLista->setFiltro("estado","=",1);
$lista2=$oLista->getLista();
unset($oLista);

if(!empty($lista2)){
    $oItem=new Data("empleado_informacion_laboral","idUsuario",$lista2[0]["idEmpleadoInformacionLaboral"]); 
    $oItem->estado=2;
    $oItem->guardar(); 
    unset($oItem);
}

$oItem=new Data("empleado","idEmpleado",$datos["idEmpleado"]); 
$oItem->estado=2;
$oItem->guardar(); 
unset($oItem);


echo json_encode(array("msg"=>true));
?>