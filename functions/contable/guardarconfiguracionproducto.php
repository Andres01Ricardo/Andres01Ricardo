<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 



$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

// $banco  = (isset($_REQUEST['banco'] ) ? $_REQUEST['banco'] : "" );

// print_r($item);

if(!isset($_SESSION)){ session_start(); }


// print_r($item);
// print_r('---');
// print_r($datos);

foreach ($item as $key => $value) {
    if ($value["cuentaContableProductoCompra"]!="" and $value["idCuentaContableProductoCompra"]!=""  ) {
    

    $oLista = new Lista('producto_cuenta_contable');

    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
    $oLista->setFiltro("idProducto","=",$value["idProductoCompra"]);
    $oLista->setFiltro("tipoFactura","=",$value["naturalezaNuevaProducto"]);
    $lista=$oLista->getLista();
    unset($oLista); 
    if (!empty($lista)) {
        foreach ($lista as $keyB => $valueB) {
            $oItem=new Data("producto_cuenta_contable","idProductoCuentaContable",$valueB["idProductoCuentaContable"]); 
            $oItem->eliminar();
            unset($oItem);
        }
    }

    $aItemAuxiliar["idProducto"]=$value["idProductoCompra"];
    $aItemAuxiliar["idEmpresa"]=$datos["idEmpresa"];
    $aItemAuxiliar["idEmpresaCuenta"]=$value["idCuentaContableProductoCompra"];
    // $aItemAuxiliar["naturaleza"]=1;
    $aItemAuxiliar["tipoDocumento"]=$value["tipoDocumentoProductoCompra"];
    $aItemAuxiliar["tipoFactura"]=$value["naturalezaNuevaProducto"];  

    $oItem=new Data("producto_cuenta_contable","idProductoCuentaContable"); 

        foreach($aItemAuxiliar  as $keya => $valuea){

            $oItem->$keya=$valuea; 

        }
        $oItem->guardar(); 
        // $idAuxiliar=$oItem->ultimoId();
        unset($oItem);
        }
}

   $msg=true; 


    echo json_encode(array("msg"=>$msg));


?>