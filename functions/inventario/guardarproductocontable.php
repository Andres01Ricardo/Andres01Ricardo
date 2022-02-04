<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );
$precio  = (isset($_REQUEST['precio'] ) ? $_REQUEST['precio'] : "" );

// print_r($datos);
if(!isset($_SESSION)){ session_start(); }


if (!empty($_SESSION['idEmpresa'])) {
    $empresa=$_SESSION['idEmpresa'];
}



        $oLista=new Lista('producto_servicio');
        $oLista->setFiltro('codigo',"=",$datos["codigo"]);
        $oLista->setFiltro('idEmpresa',"=",$idEmpresa);
        $oProducto=$oLista->getLista();
        unset($oLista);

        if (empty($oProducto)) {

            $aItem["codigo"]=$datos["codigo"]; 
            $aItem["nombre"]=$datos["nombre"];
            if (empty($datos["grupo"])) {
                
                $aItem["idGrupo"]=0;
            }
            if (!empty($datos["grupo"])) {
                
                $aItem["idGrupo"]=$datos["grupo"];
            }

            $aItem["idEmpresa"]=$empresa;
            $aItem["idUsuario"]=$_SESSION["idUsuario"];
            $aItem["fechaRegistro"]=date('Y-m-d H:i:s');
            $aItem["descripcion"]=$datos["nombre"];
            $aItem["tipo"]=1;  
            $aItem["inventario"]=0; 

            
            if (empty($datos["idCuentaCosto"])) {            
                $aItem["costo"]=0; 
            }
            if (!empty($datos["idCuentaCosto"])) {
                $aItem["costo"]=$datos["idCuentaCosto"];  
            }
            if (empty($datos["idCuentaVenta"])) {
                $aItem["venta"]=0;  
            }
            if (!empty($datos["idCuentaVenta"])) {
                $aItem["venta"]=$datos["idCuentaVenta"];  
            }


            if (empty($datos["iva"])) {
                $aItem["iva"]=0;
                
            }
            if (!empty($datos["iva"])) {
                $aItem["iva"]=str_replace(",", ".", $datos["iva"]);
            }

            if (empty($datos["costoPromedio"])) {
                $aItem["costoPromedio"]=0;
            }
            if (!empty($datos["costoPromedio"])) {
                $aItem["costoPromedio"]=str_replace(",",".",str_replace("$", "", str_replace(".", "", $datos["costoPromedio"])));
            }

            if (empty($datos["tarifa"])) {
                $aItem["tarifa"]=3;  
            }
            if (!empty($datos["tarifa"])) {
                $aItem["tarifa"]=$datos["tarifa"]; 
            }

            
            $oItem=new Data("producto_servicio","idProductoServicio"); 
            foreach($aItem  as $key => $value){
                $oItem->$key=$value; 
            }
            $oItem->guardar(); 
            $idProductoInventarioNuevo=$oItem->ultimoId();
            unset($oItem);





            if ($precio!="") {
                foreach ($precio as $keyPrecio => $valuePrecio) {
                    if ($valuePrecio["precio"]!='') {
                        
                        $aItemPrecio["precio"]=str_replace(",",".",str_replace("$", "", str_replace(".", "", $valuePrecio["precio"]))); 
                        $aItemPrecio["idProducto"]=$idProductoInventarioNuevo; 
                        

                        $oItem=new Data("producto_precio","idProductoPrecio"); 
                        foreach($aItemPrecio  as $keyP => $valueP){
                            $oItem->$keyP=$valueP; 
                        }
                        $oItem->guardar(); 
                        unset($oItem);
                    }
                }
            }
            
            $msg=true; 

        }else{
            $msg=false;
        }




echo json_encode(array("msg"=>$msg));

?>