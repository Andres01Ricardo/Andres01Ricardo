<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$idComprobante  = (isset($_REQUEST['idAnular'] ) ? $_REQUEST['idAnular'] : "" );
// $idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );


if(!isset($_SESSION)){ session_start(); }



// $idComprobante=$idComprobante;
// $idEmpresa=$idEmpresa;



$oLista=new Lista("comprobante_items");
$oLista->setFiltro("idComprobante","=",$idComprobante);
$itemsEliminar=$oLista->getLista();
unset($oLista);

foreach ($itemsEliminar as $keyEL => $valueEL) {

        $oItem=new Data("comprobante_items","idComprobanteItem",$valueEL["idComprobanteItem"]);
        $oItem->eliminar();
        unset($oItem);

}


    $aComprobante["observaciones"]="ANULADO";
    $aComprobante["estado"]=0;

    $oItem=new Data("comprobante","idComprobante",$idComprobante); 
    foreach($aComprobante  as $keyC => $valueC){
        $oItem->$keyC=$valueC; 
    }
    $oItem->guardar(); 
    unset($oItem);

                        
    $aImpuestoN["idComprobante"]=$idComprobante; 
    $aImpuestoN["idCuentaContable"]=" ";
    $aImpuestoN["idCentroCosto"]=" ";
    $aImpuestoN["idTercero"]="";
    $aImpuestoN["descripcion"]="ANULADO";
    $aImpuestoN["naturaleza"]='credito';
    $aImpuestoN["tipoTercero"]='p';
    $aImpuestoN["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
    // $aImpuestoN["fecha"]=; 
    $aImpuestoN["saldoDebito"]=0;
    $aImpuestoN["saldoCredito"]=0;
    $aImpuestoN["base"]=0;
    

    $oItem=new Data("comprobante_items","idComprobanteItem"); 
        foreach($aImpuestoN  as $keyImpuestoN => $valueImpuestoN){
            $oItem->$keyImpuestoN=$valueImpuestoN; 
        }
        $oItem->guardar(); 
        unset($oItem);

    

    $msg=true; 

// }

    echo json_encode(array("msg"=>$msg));

?>


