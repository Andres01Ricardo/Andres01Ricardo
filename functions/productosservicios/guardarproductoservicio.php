<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );
$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );



$oLista = new Lista('producto_servicio');
$oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
$lista=$oLista->getLista();
unset($oLista); 


if (empty($lista)) {
    $codigo='1000000';
}
if (!empty($lista)) {
    $codi=end($lista);
    $codigo=$codi['codigo']+1;
}




if(!isset($_SESSION)){ session_start(); }

$aDatos["idUsuario"]=$_SESSION["idUsuario"]; 

$aDatos["fechaRegistro"]=date("Y-m-d H:i:s"); 

$aDatos["nombre"]=$datos["nombreProducto"]; 

$aDatos["idEmpresa"]=$datos["idEmpresa"]; 

// $aDatos["idBienes"]=$datos["bien"]; 

$aDatos["codigo"]=$codigo; 

$aDatos["tipo"]=$datos["bienServicio"]; 





$oItem=new Data("producto_servicio","idProductoServicio"); 

foreach($aDatos  as $key => $value){

    $oItem->$key=$value; 

}

$oItem->guardar(); 

$idProducto=$oItem->ultimoId(); 

unset($oItem);



$oItem=new Data("producto_servicio","idProductoServicio",$idProducto); 

$aData=$oItem->getDatos(); 

unset($oItem); 



$nombre=$aData["codigo"]." - ".$aData["nombre"]; 
if ($datos["inventario"]==1) {

	

			$aItem["producto"]= $nombre; 
			$aItem["idProductoInventario"]=$idProducto;


            $oItem=new Data("inventario","idProducto",$datos["idInventario"]); 

            foreach($aItem  as $key => $value){

                $oItem->$key=$value; 

            }

            $oItem->guardar(); 

            unset($oItem);
}


foreach ($item as $keyP => $valueP) {
    $aItemP["idProducto"]=$idProducto;
    $aItemP["idEmpresa"]=$datos["idEmpresa"]; 
    $aItemP["idEmpresaCuenta"]=$valueP["idCuentaContable"];
    if ($keyP==0) {
        $aItemP["tipoDocumento"]=$datos["tipoDocumentoProductoCompra"];
        $aItemP["tipoFactura"]="compra";

    }
    if ($keyP==1) {
        $aItemP["tipoDocumento"]=$datos["tipoDocumentoProductoVenta"];
        $aItemP["tipoFactura"]="venta";
    }

    if ($valueP["idCuentaContable"]!='') {
    
    $oItem=new Data("producto_cuenta_contable","idProductoCuentaContable"); 
            foreach($aItemP  as $keyPR => $valuePR){
                $oItem->$keyPR=$valuePR; 
            }
            $oItem->guardar(); 
            unset($oItem);

    }
}


echo json_encode(array("msg"=>true,"id"=>$idProducto,"nombre"=>$nombre));

?>