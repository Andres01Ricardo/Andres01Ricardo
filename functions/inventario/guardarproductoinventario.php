<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");


date_default_timezone_set("America/Bogota"); 


$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );




if(!isset($_SESSION)){ session_start(); }


    $empresa=$datos['idEmpresa'];
    $fecha=date("Y-m-d H:i:s");


    $oLista=new Lista("producto_servicio");
    $oLista->setFiltro("idEmpresa","=",$empresa);
    $oLista->setFiltro("codigo","=",$datos["codigoProducto"]);
    $productoExiste=$oLista->getlista();
    unset($oLista);

    if (empty($productoExiste)) {
        // code...

        $aItem["idUsuario"]=$_SESSION["idUsuario"];
        $aItem["fechaRegistro"]= date("Y-m-d");
        
        $aItem["codigo"]=$datos["codigoProducto"];
        $aItem["nombre"]=$datos["producto"];
        $aItem["tipo"]='1';
        $aItem["idEmpresa"]=$empresa;
        $aItem["manejaInventario"]="1";

        
        $oItem=new Data("producto_servicio","idProductoServicio"); 
        foreach($aItem  as $key => $value){
            // print_r($value);
            $oItem->$key=$value; 
            
        }
            $oItem->guardar(); 
        
           unset($oItem);

        $msg=true; 

    }else{
        $msg=false;
    }

echo json_encode(array("msg"=>$msg));

?>



