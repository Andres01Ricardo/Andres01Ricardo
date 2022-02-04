<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota");



$fechaInicio  = (isset($_REQUEST['fechaInicio'] ) ? $_REQUEST['fechaInicio'] : "" );

$fechaFin  = (isset($_REQUEST['fechaFin'] ) ? $_REQUEST['fechaFin'] : "" );





$datediff   = strtotime($fechaFin) - strtotime($fechaInicio);

$dias=ceil($datediff / (60 * 60 * 24));



for($i=0; $i<=$dias;$i++){

	

	$nuevafecha = strtotime ( '+'.$i.' day' , strtotime ( $fechaInicio )) ;

	$nuevafecha = date ( 'Y-m-d' , $nuevafecha );

	$posicion=date('N',strtotime($nuevafecha)); 

	if($posicion==7){

		$restar++; 

	}

}



$cantidad=$dias-$restar+1; 

echo json_encode(array("dias"=>$cantidad));

?>