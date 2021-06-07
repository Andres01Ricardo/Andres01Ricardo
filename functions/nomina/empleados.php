<?php
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");
require_once("../../class/empleados.php"); 

$oEmpleado=new Empleados();  
date_default_timezone_set("America/Bogota"); 

$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );

$aFiltro["estado"]=1; 
$aFiltro["idEmpresa"]=$idEmpresa; 
$aEmpleados=$oEmpleado->getEmpleadosEmpresa($aFiltro);
echo json_encode(array("lista"=>$aEmpleados));


?>