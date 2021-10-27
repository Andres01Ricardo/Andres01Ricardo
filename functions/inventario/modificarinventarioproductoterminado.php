<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );



if(!isset($_SESSION)){ session_start(); }

    $empresa=$_SESSION['idEmpresa'];


    if ($datos["tipoOperacion"]==1) {
        
        if ($datos["idProducto"]!='') {


            $aMovimiento['tipoMovimiento']=1;
            
            $aMovimiento['fechaRegistro']=date("Y-m-d H:i:s");
            $aMovimiento['ingreso']=$datos["cantidadSumar"];
            $aMovimiento['egreso']=0;
            $aMovimiento['idUsuarioRegistra']=$_SESSION["idUsuario"];
            $aMovimiento['idProducto']=$datos["idProducto"];
            $aMovimiento['idEmpresa']=$empresa;
            $aMovimiento['observaciones']=$datos["observacionesSumar"];
            $aMovimiento['idBodega']=$datos["idBodega"];

            $oItem=new Data("inventario_productos_movimientos","idInventarioProductosMovimientos"); 
            foreach($aMovimiento  as $keym => $valuem){
                $oItem->$keym=$valuem; 
            }
            $oItem->guardar();             
            unset($oItem);

        }
    }
    if ($datos["tipoOperacion"]==2) {
        
        if ($datos["idProductoRestar"]!='') {
        
            $aMovimiento['tipoMovimiento']=2;
            
            $aMovimiento['fechaRegistro']=date("Y-m-d H:i:s");
            $aMovimiento['ingreso']=0;
            $aMovimiento['egreso']=$datos["cantidadRestar"];
            $aMovimiento['idUsuarioRegistra']=$_SESSION["idUsuario"];
            $aMovimiento['idProducto']=$datos["idProductoRestar"];
            $aMovimiento['idEmpresa']=$empresa;
            $aMovimiento['observaciones']=$datos["observacionesRestar"];
            $aMovimiento['idBodega']=$datos["idBodega"];

            $oItem=new Data("inventario_productos_movimientos","idInventarioProductosMovimientos"); 
            foreach($aMovimiento  as $keym => $valuem){
                $oItem->$keym=$valuem; 
            }
            $oItem->guardar();             
            unset($oItem);


        }
    }
    

$msg=true; 

echo json_encode(array("msg"=>$msg));

?>