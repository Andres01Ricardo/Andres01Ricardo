<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 



// $item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

// $banco  = (isset($_REQUEST['banco'] ) ? $_REQUEST['banco'] : "" );

// print_r($item);

if(!isset($_SESSION)){ session_start(); }


// print_r($item);
// print_r('---');
// print_r($datos);


    if ($datos["cuentaContableTotalPagarCompra"]!="" and $datos["idCuentaContableTotalPagarCompra"]!=""  ) {
       

    $aItemAuxiliar["concepto"]='1';
    $aItemAuxiliar["idEmpresa"]=$datos["idEmpresa"];
    $aItemAuxiliar["idEmpresaCuenta"]=$datos["idCuentaContableTotalPagarCompra"];
    
    $aItemAuxiliar["tipoDocumento"]=$datos["tipoDocumentoTotalPagarCompra"];
    $aItemAuxiliar["tipoFactura"]=$datos["naturalezaNuevaTotalPagarCompra"];  

    $oItem=new Data("compra_cuenta_contable","idCompraCuentaContable"); 

        foreach($aItemAuxiliar  as $keya => $valuea){

            $oItem->$keya=$valuea; 

        }
        $oItem->guardar(); 
        // $idAuxiliar=$oItem->ultimoId();
        unset($oItem);
    }


   $msg=true; 


    echo json_encode(array("msg"=>$msg));


?>