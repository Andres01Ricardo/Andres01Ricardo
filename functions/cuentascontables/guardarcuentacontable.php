<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 



$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );

// print_r($item);


if(!isset($_SESSION)){ session_start(); }

// print_r($item);

foreach ($item as $key => $value) {
if ($value["cuenta"]!="") {
    $nombre=substr($value["cuenta"], 5);
}
if ($value["subcuenta"]!="") {
    $nombre=substr($value["subcuenta"], 5);
}    
if ($value["checksubcuenta"]!="") {
    
    $aCuenta["codigo"]=$value["subcuenta"];
    $aCuenta["denominacion"]=$value["descripcionSubcuenta"];
    $aCuenta["idCuenta"]=$value["idCuenta"];

    $nombre=$value["descripcionSubcuenta"];

    $oItem=new Data("subcuenta","idSubcuenta"); 

        foreach($aCuenta  as $keya => $valuea){

            $oItem->$keya=$valuea; 

        }

        $oItem->guardar(); 

        $idSubCuentaN=$oItem->ultimoId();

        unset($oItem);
        $value["idSubcuenta"]=$idSubCuentaN;
}
if ($value["checkauxiliar"]!="") {
    
    $aItemAuxiliar["codigo"]=$value["idAuxiliar"];
    $aItemAuxiliar["denominacion"]=$value["auxiliar"];
    $aItemAuxiliar["idSubcuenta"]=$value["idSubcuenta"];

    $nombre=$value["auxiliar"];

    $oItem=new Data("auxiliar","idAuxiliar"); 

        foreach($aItemAuxiliar  as $keya => $valuea){

            $oItem->$keya=$valuea; 

        }

        $oItem->guardar(); 

        $idAuxiliar=$oItem->ultimoId();

        unset($oItem);
        

}
if ($value["checkauxiliar"]=="") {
    $idAuxiliar='';
}
if ($value["checksubauxiliar"]!="") {
    $aItemSubauxiliar["codigo"]=$value["idSubauxiliar"];
    $aItemSubauxiliar["denominacion"]=$value["subauxiliar"];
    $aItemSubauxiliar["idAuxiliar"]=$idAuxiliar;

    $nombre=$value["subauxiliar"];

    $oItem=new Data("subauxiliar","idSubauxiliar"); 

        foreach($aItemSubauxiliar  as $keys => $values){

            $oItem->$keys=$values; 

        }

        $oItem->guardar(); 

        $idSubauxiliar=$oItem->ultimoId();

        unset($oItem);
}


    if ($value["checkcentrocosto"]==1) {
        $centroCosto=1;
    }
    if ($value["checkcentrocosto"]=="") {
        $centroCosto=0;
    }
    

    $aItem["nombre"]=$nombre; 

   

    $aItem["naturaleza"]=$value["naturaleza"];


    $aItem["codigoCuenta"]=substr($value["grupo"], 0, 2).substr($value["cuenta"], 0, 2).substr($value["subcuenta"], 0, 2).substr($value["idAuxiliar"], 0, 2).substr($value["idSubauxiliar"], 0, 2);

    $aItem["centroCosto"]=$centroCosto;
    $aItem["tipoCuenta"]=$value["tipoCuenta"];

    $aItem["idEmpresa"]=$value["idEmpresa"];

    $aItem["detalle"]=$value["detalle"];
    $aItem["tercero"]=$value["tercero"];
    $aItem["porcentajeRetencion"]=$value["porcentajeRetencion"];

     $oItem=new Lista("cuenta_contable");
     $oItem->setFiltro("codigoCuenta","=",$aItem["codigoCuenta"]);
     $oItem->setFiltro("idEmpresa","=",$value["idEmpresa"]);
     $cuentaC=$oItem->getLista();
     unset($oItem);
     

     if (!empty($cuentaC)) {
         $aItemCuenta["centroCosto"]=$centroCosto;
         $aItemCuenta["naturaleza"]=$value["naturaleza"];
         $aItemCuenta["tipoCuenta"]=$value["tipoCuenta"];

        $aItemCuenta["detalle"]=$value["detalle"];
        $aItemCuenta["tercero"]=$value["tercero"];
        $aItemCuenta["porcentajeRetencion"]=$value["porcentajeRetencion"];

         $oItem=new Data("cuenta_contable","idCuentaContable",$cuentaC[0]["idCuentaContable"]);

        foreach($aItemCuenta  as $keycc => $valuecc){

            $oItem->$keycc=$valuecc; 

        }

        $oItem->guardar(); 
        $idCuentaContable=$cuentaC[0]["idCuentaContable"];


        unset($oItem);
     }
 
    
    if (empty($cuentaC) ) {
        $oItem=new Data("cuenta_contable","idCuentaContable"); 

        foreach($aItem  as $keycc => $valuecc){

            $oItem->$keycc=$valuecc; 

        }

        $oItem->guardar(); 
        $idCuentaContable=$oItem->ultimoId(); 


        unset($oItem);

        }

        // $aItemE["saldo"]=0;

        // $aItemE["idEmpresa"]=$value["idEmpresa"];
        // $aItemE["idCuentaContable"]=$idCuentaContable;

        // $oItem=new Data("empresa_cuenta_contable","idEmpresaCuentaContable"); 

        // foreach($aItemE  as $keycc => $valuecc){

        //     $oItem->$keycc=$valuecc; 

        // }

        // $oItem->guardar(); 
        


        // unset($oItem);

    }


    $msg=true; 



    echo json_encode(array("msg"=>$msg));

?>