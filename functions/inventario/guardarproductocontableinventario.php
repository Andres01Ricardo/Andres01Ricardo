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

$idEmpresa=$datos["idEmpresa"];


$oLista=new Lista('producto_contable');
$oLista->setFiltro('codigo',"=",$datos["codigo"]);
$oLista->setFiltro('idEmpresa',"=",$idEmpresa);
$oProducto=$oLista->getLista();
unset($oLista);


    if (empty($oProducto)) {
        


        $aItem["idEmpresa"]=$idEmpresa;
        $aItem["idGrupo"]=$datos["grupo"];
        $aItem["codigo"]=$datos["codigo"]; 
        $aItem["descripcion"]=$datos["nombre"];
        $aItem["iva"]=str_replace(",", ".", $datos["iva"]);
        $aItem["costoPromedio"]=str_replace(",",".",str_replace("$", "", str_replace(".", "", $datos["costoPromedio"]))); 
        $aItem["tarifa"]=$datos["tarifa"]; 
        $aItem["tipo"]=$datos["bienServicio"]; 
        $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"];
        $aItem["fechaRegistro"]=date('Y-m-d H:i:s');

        $oItem=new Data("producto_contable","idProductoContable"); 
        foreach($aItem  as $key => $value){
            $oItem->$key=$value; 
        }
        $oItem->guardar(); 
        $idProductoInventarioNuevo=$oItem->ultimoId();
        unset($oItem);



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

        $msg=true; 
    }else{
        $msg=false;
    }



echo json_encode(array("msg"=>$msg));

?>