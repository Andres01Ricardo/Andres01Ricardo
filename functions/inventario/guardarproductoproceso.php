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


$valorTotalInsumos=0;
    
        foreach ($itemR as $keyd => $value2) {

            if ($value2["idProductoInsumo"]!='') {

                $valorTotalInsumos=$valorTotalInsumos + str_replace("$", "", str_replace(",", "", $value2["totalInsumo"]));;
            
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
                $aMovimientoi['motivo']='Elaboración producto en proceso';

                $oItem=new Data("inventario_movimientos","idInventario_movimientos"); 

                foreach($aMovimientoi  as $keymi => $valuemi){

                    $oItem->$keymi=$valuemi; 

                }

                $oItem->guardar();             
                
                unset($oItem);
                

            }

        }


foreach ($item as $key => $value) {

        if ($value["idProducto"]=='') {

            $aItemI["producto"]=$value["producto"]; 

            $aItemI["unidad"]=1; 

            $aItemI["cantidad"]=0; 

            $aItemI["valorUnitario"]=0; 

            $aItemI["tipoInventario"]=2; 

            $aItemI["idEmpresa"]=$empresa;

            $aItemI["fechaRegistro"]= date("Y-m-d H:i:s");

            $oItem=new Data("inventario","idProducto"); 

            foreach($aItemI  as $keyI => $valueI){

                $oItem->$keyI=$valueI; 

            }


            $oItem->guardar(); 

            $idProductoInventarioNuevo=$oItem->ultimoId();

            unset($oItem);

            $aItem["idProductoInventario"]=$idProductoInventarioNuevo;

        }elseif ($value["idProducto"]!='') {
            $aItem["idProductoInventario"]=$value["idProducto"];
        }
        
        $valorUnitarioProductoProceso=$valorTotalInsumos/$value["cantidad"];
        $cantidadNueva=$value["cantidad"];
        $valorUnitarioProductoProcesof=round($valorUnitarioProductoProceso,8);
        $aItem["producto"]=$value["producto"]; 

        $aItem["unidad"]=1; 

        $aItem["cantidad"]=$value["cantidad"]; 

        $aItem["valorUnitario"]=$valorUnitarioProductoProcesof; 

        $aItem["tipoInventario"]=3; 

        $aItem["idEmpresa"]=$empresa;

        $aItem["fechaRegistro"]= date("Y-m-d H:i:s");

        

        $oItem=new Data("producto_proceso","idProducto"); 

        foreach($aItem  as $keyp => $valuep){

            $oItem->$keyp=$valuep;

        }

        
        $oItem->guardar(); 

        $idProductoInventarioNuevoProceso=$oItem->ultimoId();

        unset($oItem);

        

            $aMovimiento['tipoMovimiento']=1;
            $aMovimiento['tipoInventario']=3;
            $aMovimiento['fechaRegistro']=date("Y-m-d H:i:s");
            $aMovimiento['cantidadAnterior']=0;
            $aMovimiento['cantidadActual']=$cantidadNueva;
            $aMovimiento['idUsuarioRegistra']=$_SESSION["idUsuario"];
            $aMovimiento['idProducto']=$idProductoInventarioNuevoProceso;
            $aMovimiento['idEmpresa']=$empresa;
            $aMovimiento['motivo']='Producto en proceso';

            $oItem=new Data("producto_proceso_movimientos","idInventario_movimientos"); 

            foreach($aMovimiento  as $keym => $valuem){

                $oItem->$keym=$valuem; 

            }

            $oItem->guardar();    
         

            unset($oItem);


    }


$msg=true; 

echo json_encode(array("msg"=>$msg));

?>