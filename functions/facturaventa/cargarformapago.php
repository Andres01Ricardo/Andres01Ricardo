<?php

require_once("../../php/restrict.php");


include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");


date_default_timezone_set("America/Bogota"); 

$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );



$oItem=new Lista("banco_cuenta_contable");
$oItem->setFiltro("idEmpresa","=",$idEmpresa);
$aBancos=$oItem->getLista();
unset($oItem); 


echo json_encode($aBancos); 

?>











