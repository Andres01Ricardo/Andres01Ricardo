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

$aData["idEmpresa"]=$_SESSION["idEmpresa"];
$aData["idEmpleado"]=$datos["idEmpleado"];
$aData["fechaRegistro"]=date("Y-m-d H:i:s");
$aData["idNovedades"]=1;
$aData["idUsuarioRegistra"]=$_SESSION["idUsuario"];
$aData["estado"]=1;

$oItem=new Data("empresa_novedad","idEmpresaNovedad"); 
foreach ($aData as $key => $value) {
  $oItem->$key=$value; 
}
$oItem->guardar(); 
$idNovedad=$oItem->ultimoId();
unset($oItem); 

$aDescuento["idEmpresaNovedad"]=$idNovedad; 
$aDescuento["idEmpleado"]=$datos["idEmpleado"]; 
$aDescuento["descripcion"]=$datos["descripcion"]; 
$aDescuento["fechaInicioDescuento"]=$datos["fechaInicio"]; 
$aDescuento["valorDescuento"]=str_replace("$", "", str_replace(".", "", $datos["valorDescuento"]));
$aDescuento["numeroCuotas"]=$datos["cuotas"]; 
$aDescuento["valorCuota"]=str_replace("$", "", str_replace(".", "", $datos["valorCuota"]));
$aDescuento["estado"]=1;

$oItem=new Data("empresa_descuento_empleado","idEmpresaDescuentoEmpleado"); 
foreach ($aDescuento as $key => $value) {
  $oItem->$key=$value; 
}
$oItem->guardar(); 
$idDescuento=$oItem->ultimoId();
unset($oItem); 


for ($i=0; $i < $datos["cuotas"]; $i++) { 
    $nuevafecha = strtotime ( '+'.$i.' months' , strtotime ( $datos["fechaInicio"] ) ) ;
    
    $aCuota["fechaDescuento"]=date ('Y-m-d',$nuevafecha);
    $aCuota["idEmpresaDescuentoEmpleado"]=$idDescuento;
    $aCuota["valorCuota"]=str_replace("$", "", str_replace(".", "", $datos["valorCuota"]));
    $aCuota["estado"]=1;

    $oItem=new Data("empresa_descuento_empleado_cuota","idEmpresaDescuentoEmpleadoCuota"); 
    foreach ($aCuota as $key => $value) {
      $oItem->$key=$value; 
    }
    $oItem->guardar(); 
    unset($oItem); 
}

echo json_encode(array("msg"=>true));
?>