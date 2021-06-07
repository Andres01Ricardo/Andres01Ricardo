<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );



if(!isset($_SESSION)){ session_start(); }

if ($_SESSION['idRol']==1) {
    $empresa=$datos['idEmpresa'];
}else if ($_SESSION['idRol']==3 || $_SESSION['idRol']==4) {
    $empresa=$_SESSION['idEmpresa'];
}

foreach ($item as $key => $value) {

    if ($value["idProducto"]=='') {

        $valorUnitario=str_replace("$", "", str_replace(",", "", $value["valorUnitario"]))/$value["cantidadMinima"];

        $valorUnitario=round($valorUnitario,40);
        $valorUnitario=str_replace(",", ".", $valorUnitario);

        $aItem["producto"]=$value["producto"]; 

        $aItem["unidad"]=$value["idUnidad"]; 

        $aItem["cantidad"]=$value["cantidad"]; 

        $aItem["cantidadMinima"]=$value["cantidadMinima"]; 

        $cantidadNueva= $value["cantidad"];

        $aItem["idProductoInventario"]=0; 

        $aItem["valorUnitario"]=$valorUnitario; 

        $aItem["tipoInventario"]=1; 

        $aItem["idEmpresa"]=$empresa;

        $oItem=new Data("inventario","idProducto"); 

        foreach($aItem  as $key => $value){

            $oItem->$key=$value; 

        }

        $oItem->guardar(); 

        $idProductoInventarioNuevo=$oItem->ultimoId();
        
        unset($oItem);



            $aMovimiento['tipoMovimiento']=1;
            $aMovimiento['tipoInventario']=1;
            $aMovimiento['fechaRegistro']=date("Y-m-d H:i:s");
            $aMovimiento['cantidadAnterior']=0;
            $aMovimiento['cantidadActual']=$cantidadNueva;
            $aMovimiento['idUsuarioRegistra']=$_SESSION["idUsuario"];
            $aMovimiento['idProducto']=$idProductoInventarioNuevo;
            $aMovimiento['idEmpresa']=$empresa;

            $oItem=new Data("inventario_movimientos","idInventario_movimientos"); 

            foreach($aMovimiento  as $keym => $valuem){

                $oItem->$keym=$valuem; 

            }

            $oItem->guardar();    
         

            unset($oItem);


        }




        else if ($value["idProducto"]!='') {

            $idProductoGuardar = $value["idProducto"];
        
            $oItem=new Data("inventario","idProducto",$value["idProducto"]); 

            $aDatos=$oItem->getDatos(); 

            unset($oItem);
           
            $cantidadActual = $aDatos["cantidad"];
            $cantidadNueva = $cantidadActual + $value["cantidad"];

            $aItem["cantidad"]= $cantidadNueva; 


            $oItem=new Data("inventario","idProducto",$value["idProducto"]); 

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
            $aMovimiento['idProducto']=$idProductoGuardar;
            $aMovimiento['idEmpresa']=$empresa;

            $oItem=new Data("inventario_movimientos","idInventario_movimientos"); 

            foreach($aMovimiento  as $keym => $valuem){

                $oItem->$keym=$valuem; 

            }

            $oItem->guardar();             
            
            unset($oItem);


        }

    }

    // print_r($item);

$msg=true; 

echo json_encode(array("msg"=>$msg));

?>