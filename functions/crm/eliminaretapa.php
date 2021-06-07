<?php

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

// $codigoEtapa=(isset($_REQUEST['id'] ) ? $_REQUEST['id'] : '' );
// $url=$codigoEtapa; 
// if($codigoEtapa==""){
// echo '<script>window.history.back()</script>'; 
// }

$codigoEtapa=$_POST['codigoEtapaEliminar'];


$oItem=new Data("t_etapas","codigo",$codigoEtapa); 
$oItem->eliminar();
$codigoEtapa=$oItem->ultimoId(); 
unset($oItem);

    
    header('location: ../../pipeline');

?>