<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 


$idEliminar=(isset($_REQUEST['idEliminar'] ) ? $_REQUEST['idEliminar'] : "" );
$tipoNovedad=(isset($_REQUEST['tipoNovedad'] ) ? $_REQUEST['tipoNovedad'] : "" );




$oItem=new Data("empresa_novedad","idEmpresaNovedad",$idEliminar); 
$oItem->eliminar(); 
unset($oItem);

switch ($tipoNovedad) {
	case 1:
		$oItem=new Data("empleado_descuento","idEmpresaNovedad",$idEliminar); 
		break;
	case 2:
		$oItem=new Data("empleado_permiso","idEmpresaNovedad",$idEliminar); 
		break;
	case 3:
		$oItem=new Data("empleado_horas_extras","idEmpresaNovedad",$idEliminar);
		break;
	case 4:
		$oItem=new Data("empleado_vacaciones","idEmpresaNovedad",$idEliminar);
		break;
	case 5:
		$oItem=new Data("empleado_incapacidad_medica","idEmpresaNovedad",$idEliminar);
		break;
	case 6:
		$oItem=new Data("empleado_cambio_salario","idEmpresaNovedad",$idEliminar);
		break;
	case 7:
		$oItem=new Data("empleado_auxilios_extralegales","idEmpresaNovedad",$idEliminar);
		break;
	case 8:
		$oItem=new Data("empleado_cambio_seguridad_social","idEmpresaNovedad",$idEliminar);
		break;
	case 9:
		$oItem=new Data("empleado_comision","idEmpresaNovedad",$idEliminar);
		break;
	case 10:
		$oItem=new Data("empleado_retiro","idEmpresaNovedad",$idEliminar);
		break;
	
	default:
		# code...
		break;
}

$oItem->eliminar();
unset($oItem);
    
    


$msg=true; 


echo json_encode(array("msg"=>$msg));

?>