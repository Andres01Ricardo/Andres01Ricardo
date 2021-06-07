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



foreach ($item as $key => $value) {
    if ($value["cuentaContableProductoCompra"]!="" and $value["idCuentaContableProductoCompra"]!=""  ) {
    

    $oLista = new Lista('producto_cuenta_contable');

    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
    $oLista->setFiltro("idProducto","=",$value["idProductoCompra"]);
    $oLista->setFiltro("tipoFactura","=","compra");
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
    $aItemAuxiliar["tipoFactura"]='compra';  

    $oItem=new Data("producto_cuenta_contable","idProductoCuentaContable"); 

        foreach($aItemAuxiliar  as $keya => $valuea){

            $oItem->$keya=$valuea; 

        }
        $oItem->guardar(); 
        // $idAuxiliar=$oItem->ultimoId();
        unset($oItem);
        }

 if ($value["cuentaContableProductoVenta"]!="" and $value["idCuentaContableProductoVenta"]!=""   ) {

    $oLista = new Lista('producto_cuenta_contable');

    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
    $oLista->setFiltro("idProducto","=",$value["idProductoVenta"]);
    $oLista->setFiltro("tipoFactura","=","venta");
    $listaV=$oLista->getLista();
    unset($oLista); 
    if (!empty($listaV)) {
        foreach ($listaV as $keyBV => $valueBV) {
            $oItem=new Data("producto_cuenta_contable","idProductoCuentaContable",$valueBV["idProductoCuentaContable"]); 
            $oItem->eliminar();
            unset($oItem);
        }
    }




    $aItemAuxiliarV["idProducto"]=$value["idProductoVenta"];
    $aItemAuxiliarV["idEmpresa"]=$datos["idEmpresa"];
    $aItemAuxiliarV["idEmpresaCuenta"]=$value["idCuentaContableProductoVenta"];
    // $aItemAuxiliarV["naturaleza"]=2;
    $aItemAuxiliarV["tipoDocumento"]=$value["tipoDocumentoProductoVenta"];
    $aItemAuxiliarV["tipoFactura"]='venta';  

    $oItem=new Data("producto_cuenta_contable","idProductoCuentaContable"); 

        foreach($aItemAuxiliarV  as $keyv => $valuev){

            $oItem->$keyv=$valuev; 

        }
        $oItem->guardar(); 
        // $idAuxiliar=$oItem->ultimoId();
        unset($oItem);
    }

}

   $msg=true; 


    echo json_encode(array("msg"=>$msg));


?>