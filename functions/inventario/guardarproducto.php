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

$itemR  = (isset($_REQUEST['itemR'] ) ? $_REQUEST['itemR'] : "" );


if(!isset($_SESSION)){ session_start(); }

if ($_SESSION['idRol']==1) {
    $empresa=$datos['idEmpresa'];
}else if ($_SESSION['idRol']==3 || $_SESSION['idRol']==4) {
    $empresa=$_SESSION['idEmpresa'];
}



foreach ($item as $key => $value) {

    if ($value["idProducto"]=='') {
        

        $aItem["producto"]=$value["producto"]; 

        $aItem["unidad"]=1; 

        $aItem["cantidad"]=$value["cantidad"]; 

        $aItem["valorUnitario"]=str_replace("$", "", str_replace(",", "", $value["valorUnitario"])); 

        $aItem["tipoInventario"]=2; 

        $aItem["idEmpresa"]=$empresa;

        $oItem=new Data("inventario","idProducto"); 

        foreach($aItem  as $key => $value){

            $oItem->$key=$value; 

        }


        $oItem->guardar(); 

        $idProductoInventarioNuevo=$oItem->ultimoId();

        unset($oItem);



            $aMovimiento['tipoMovimiento']=1;
            $aMovimiento['tipoInventario']=2;
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
        
            $oItem=new Data("inventario","idProducto",$value["idProducto"]); 

            $aDatos=$oItem->getDatos(); 

            unset($oItem);

            $cantidadActual = $aDatos["cantidad"];
            $cantidadNueva = $cantidadActual + $value["cantidad"];

            $aItem["cantidad"]= $cantidadNueva; 

            $idProductoGuardar=$value["idProducto"];
            $oItem=new Data("inventario","idProducto",$value["idProducto"]); 

            foreach($aItem  as $key => $value){

                $oItem->$key=$value; 

            }

            $oItem->guardar(); 

            unset($oItem);


            $aMovimiento['tipoMovimiento']=1;
            $aMovimiento['tipoInventario']=2;
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



if ($datos["descargarInsumo"]==1) {
    
        foreach ($itemR as $keyd => $value2) {

            if ($value2["idProductoInsumo"]!='') {
            
                $idProductoGuardari=$value2["idProductoInsumo"];
                $oItem=new Data("inventario","idProducto",$value2["idProductoInsumo"]); 

                $aDatos=$oItem->getDatos(); 

                unset($oItem);
               
                $cantidadActuali = $aDatos["cantidad"];
                $cantidadNuevai = $cantidadActuali - $value2["cantidadInsumo"];

                $aItem2["cantidad"]= $cantidadNuevai; 


                $oItem=new Data("inventario","idProducto",$value2["idProductoInsumo"]); 

                foreach($aItem2  as $key2 => $value3){

                    $oItem->$key2=$value3; 

                }

                $oItem->guardar(); 

                unset($oItem);


                $aMovimientoi['tipoMovimiento']=2;
                $aMovimientoi['tipoInventario']=1;
                $aMovimientoi['fechaRegistro']=date("Y-m-d H:i:s");
                $aMovimientoi['cantidadAnterior']=$cantidadActuali;
                $aMovimientoi['cantidadActual']=$cantidadNuevai;
                $aMovimientoi['idUsuarioRegistra']=$_SESSION["idUsuario"];
                $aMovimientoi['idProducto']=$idProductoGuardari;
                $aMovimientoi['idEmpresa']=$empresa;

                $oItem=new Data("inventario_movimientos","idInventario_movimientos"); 

                foreach($aMovimientoi  as $keymi => $valuemi){

                    $oItem->$keymi=$valuemi; 

                }

                $oItem->guardar();             
                
                unset($oItem);
                

            }

        }

}

$msg=true; 

echo json_encode(array("msg"=>$msg));

?>