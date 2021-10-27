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



    $impuestosFacturaCompra["tipoImpuesto"]=$datos['tipoDeduccion'];
    $impuestosFacturaCompra["idEmpresa"]=$datos["idEmpresa"];
    $impuestosFacturaCompra["idEmpresaCuenta"]=$datos["idCuentaContable"];
    // $impuestosFacturaCompra["tipoDocumento"]=$datos["tipoDocumento"];

    $impuestosFacturaCompra["tipoFactura"]=$datos["tipoFactura"];
    if ($datos['tipoDeduccion']==3) {
        $impuestosFacturaCompra["idImpuesto"]=0;
    }
    if ($datos['tipoDeduccion']!=3) {
        $impuestosFacturaCompra["idImpuesto"]=$datos['conceptoSelect'];
    }

    $oItem=new Data("impuesto_cuenta_contable","idImpuestoCuentaContable");  
        foreach($impuestosFacturaCompra  as $keya => $valuea){
            $oItem->$keya=$valuea; 
        }
        $oItem->guardar(); 
        unset($oItem);


       $msg=true; 


    echo json_encode(array("msg"=>$msg));

 ?>