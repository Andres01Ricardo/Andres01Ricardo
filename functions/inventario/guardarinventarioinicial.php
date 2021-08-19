<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");


date_default_timezone_set("America/Bogota"); 


$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );




if(!isset($_SESSION)){ session_start(); }



$oLista = new Lista('inventario_inicial');
$oLista->setFiltro("idEmpresa","=",$datos['idEmpresa']);
$oLista->setFiltro("idProducto","=",$datos["idProducto"]);
$aInventario=$oLista->getLista();
unset($oLista);

    if (empty($aInventario)) {

        $aItem["idProducto"]=$datos["idProducto"];
        $aItem["idUnidad"]=$datos["idUnidad"];
        $aItem["idCategoria"]=$datos["idCategoria"];
        $aItem["existencia"]=$datos["cantidad"];
        $aItem["fecha"]= date("Y-m-d");
        $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"];
        $aItem["idEmpresa"]=$datos['idEmpresa'];
        $aItem["stockMinimo"]=$datos['minimo'];
        
        $oItem=new Data("inventario_inicial","idInventarioInicial"); 
        foreach($aItem  as $key => $value){
            // print_r($value);
            $oItem->$key=$value; 
        }
            $oItem->guardar(); 
           unset($oItem);

           $msg=true; 
    }

    if (!empty($aInventario)) {
        $msg=false;
    }



echo json_encode(array("msg"=>$msg));

?>



