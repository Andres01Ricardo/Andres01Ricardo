<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );
// $item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );
// $banco  = (isset($_REQUEST['banco'] ) ? $_REQUEST['banco'] : "" );


if(!isset($_SESSION)){ session_start(); }




    $bancoC["idCuentaBancaria"]=$datos["idCuentaBancaria"];
    $bancoC["idEmpresa"]=$datos["idEmpresa"];
    $bancoC["idEmpresaCuenta"]=$datos["idCuentaContable"];
    $bancoC["nombre"]=$datos["nombre"];
     $oItem=new Data("banco_cuenta_contable","idBancoCuentaContable"); 
    foreach($bancoC  as $keyEC => $valueEC){
        $oItem->$keyEC=$valueEC; 
    }
    $oItem->guardar(); 
    unset($oItem);
    

       $msg=true; 


    echo json_encode(array("msg"=>$msg));

 ?>