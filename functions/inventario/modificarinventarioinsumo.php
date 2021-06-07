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

if ($_SESSION['idRol']==1) {
    $empresa=$datos['idEmpresa'];
}else if ($_SESSION['idRol']==3 || $_SESSION['idRol']==4) {
    $empresa=$_SESSION['idEmpresa'];
}

    if ($datos["tipoOperacion"]==1) {
        
        if ($datos["idProducto"]!='') {
        
            $oItem=new Data("inventario","idProducto",$datos["idProducto"]); 

            $aDatos=$oItem->getDatos(); 

            unset($oItem);
           
            $cantidadActual = $aDatos["cantidad"];
            $cantidadNueva = $cantidadActual + $datos["cantidadSumar"];

            $aItem["cantidad"]= $cantidadNueva; 


            $oItem=new Data("inventario","idProducto",$datos["idProducto"]); 

            foreach($aItem  as $key => $value){

                $oItem->$key=$value; 

            }

            $oItem->guardar(); 

            unset($oItem);



            $aMovimiento['tipoMovimiento']=1;
            $aMovimiento['tipoInventario']=1;
            $aMovimiento['fechaRegistro']=date("Y-m-d H:i:s");
            $aMovimiento['cantidadAnterior']=$cantidadActual;
            $aMovimiento['cantidadActual']=$cantidadNueva;
            $aMovimiento['idUsuarioRegistra']=$_SESSION["idUsuario"];
            $aMovimiento['idProducto']=$datos["idProducto"];
            $aMovimiento['idEmpresa']=$empresa;

            $oItem=new Data("inventario_movimientos","idInventario_movimientos"); 

            foreach($aMovimiento  as $keym => $valuem){

                $oItem->$keym=$valuem; 

            }

            $oItem->guardar();             

            unset($oItem);



        }
    }
    if ($datos["tipoOperacion"]==2) {
        
        if ($datos["idProductoRestar"]!='') {
        
            $oItem=new Data("inventario","idProducto",$datos["idProductoRestar"]); 

            $aDatos=$oItem->getDatos(); 

            unset($oItem);
           
            $cantidadActual = $aDatos["cantidad"];
            $cantidadNueva = $cantidadActual - $datos["cantidadRestar"];

            $aItem["cantidad"]= $cantidadNueva; 


            $oItem=new Data("inventario","idProducto",$datos["idProductoRestar"]); 

            foreach($aItem  as $key => $value){

                $oItem->$key=$value; 

            }

            $oItem->guardar(); 

            unset($oItem);


            $aMovimiento['tipoMovimiento']=2;
            $aMovimiento['tipoInventario']=1;
            $aMovimiento['fechaRegistro']=date("Y-m-d H:i:s");
            $aMovimiento['cantidadAnterior']=$cantidadActual;
            $aMovimiento['cantidadActual']=$cantidadNueva;
            $aMovimiento['idUsuarioRegistra']=$_SESSION["idUsuario"];
            $aMovimiento['idProducto']=$datos["idProductoRestar"];
            $aMovimiento['idEmpresa']=$empresa;
            $oItem=new Data("inventario_movimientos","idInventario_movimientos"); 

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