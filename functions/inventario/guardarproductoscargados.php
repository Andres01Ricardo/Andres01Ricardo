<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();



date_default_timezone_set("America/Bogota"); 



// $datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );
// $precio  = (isset($_REQUEST['precio'] ) ? $_REQUEST['precio'] : "" );


$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );
$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );


$fallos=[];
$control=true;


if(!isset($_SESSION)){ session_start(); }


if (!empty($_SESSION['idEmpresa'])) {
    $empresa=$_SESSION['idEmpresa'];
}

$idEmpresa=$datos["idEmpresa"];



foreach ($item as $key => $valueProducto) {
        $control=true;
        
        $oLista=new Lista("grupo_inventario");
        $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
        $oLista->setFiltro("codigo","=",$valueProducto["grupo"]);
        $grupoI=$oLista->getLista();
        unset($oLista);

        if (empty($grupoI)) {
            $control=false;
        }

        if ($control===false) {
            // $fallos
            array_push($fallos,$valueProducto["codigo"]);
        }

        if (!empty($grupoI)) {
            $idGrupo=$grupoI[0]["idGrupoInventario"];
            $control=true;

            $oLista=new Lista('producto_servicio');
            $oLista->setFiltro('codigo',"=",$valueProducto["codigo"]);
            $oLista->setFiltro('idEmpresa',"=",$idEmpresa);
            $oProducto=$oLista->getLista();
            unset($oLista);

        if (empty($oProducto)) {

            $aItem["codigo"]=$valueProducto["codigo"]; 
            $aItem["nombre"]=$valueProducto["nombre"];
            $aItem["idGrupo"]=$idGrupo;
            $aItem["idEmpresa"]=$idEmpresa;
            $aItem["idUsuario"]=$_SESSION["idUsuario"];
            $aItem["fechaRegistro"]=date('Y-m-d H:i:s');
            $aItem["descripcion"]=$datos["nombre"];
            $aItem["tipo"]=1;

            
            $aItem["iva"]=str_replace(",", ".", $valueProducto["iva"]);
            $aItem["costoPromedio"]=str_replace("$", "", str_replace(",", "", $valueProducto["costoPromedio"]));
            $tarifa=substr($valueProducto["tarifa"], 0,1); 
            $aItem["tarifa"]=$tarifa;

            $aItem["inventario"]=0; 
            $aItem["costo"]=0;
            $aItem["venta"]=0;



            $oItem=new Data("producto_servicio","idProductoContable"); 
            foreach($aItem  as $key => $value){
                $oItem->$key=$value; 
            }
            $oItem->guardar(); 
            $idProductoInventarioNuevo=$oItem->ultimoId();
            unset($oItem);



        // foreach ($precio as $keyPrecio => $valuePrecio) {
            if ($valueProducto["precioUno"]!='') {
                
                $aItemPrecio["precio"]=str_replace("$", "", str_replace(",", "", $valueProducto["precioUno"])); 
                $aItemPrecio["idProducto"]=$idProductoInventarioNuevo; 
                

                $oItem=new Data("producto_precio","idProductoPrecio"); 
                foreach($aItemPrecio  as $keyP => $valueP){
                    $oItem->$keyP=$valueP; 
                }
                $oItem->guardar(); 
                unset($oItem);
            }


            if ($valueProducto["precioDos"]!='') {
                
                $aItemPrecio["precio"]=str_replace("$", "", str_replace(",", "", $valueProducto["precioDos"])); 
                $aItemPrecio["idProducto"]=$idProductoInventarioNuevo; 
                

                $oItem=new Data("producto_precio","idProductoPrecio"); 
                foreach($aItemPrecio  as $keyP => $valueP){
                    $oItem->$keyP=$valueP; 
                }
                $oItem->guardar(); 
                unset($oItem);
            }


            if ($valueProducto["precioTres"]!='') {
                
                $aItemPrecio["precio"]=str_replace("$", "", str_replace(",", "", $valueProducto["precioTres"])); 
                $aItemPrecio["idProducto"]=$idProductoInventarioNuevo; 
                

                $oItem=new Data("producto_precio","idProductoPrecio"); 
                foreach($aItemPrecio  as $keyP => $valueP){
                    $oItem->$keyP=$valueP; 
                }
                $oItem->guardar(); 
                unset($oItem);
            }


            if ($valueProducto["precioCuatro"]!='') {   
                
                $aItemPrecio["precio"]=str_replace("$", "", str_replace(",", "", $valueProducto["precioCuatro"])); 
                $aItemPrecio["idProducto"]=$idProductoInventarioNuevo; 
                

                $oItem=new Data("producto_precio","idProductoPrecio"); 
                foreach($aItemPrecio  as $keyP => $valueP){
                    $oItem->$keyP=$valueP; 
                }
                $oItem->guardar(); 
                unset($oItem);
            }
            // }
        }else{
            $control=false;
        
            // $fallos
            array_push($fallos,$valueProducto["codigo"]);
        
        }

    }
    // else{
    //     $msg=false;
    // }

}

        $msg=true; 

// echo json_encode(array("msg"=>$msg));
echo json_encode(array("msg"=>$msg,"fallos"=>$fallos));

?>