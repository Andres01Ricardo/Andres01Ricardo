<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");


date_default_timezone_set("America/Bogota"); 



$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );
$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );



if(!isset($_SESSION)){ session_start(); }

$fallos=[];
$control=true;

foreach ($item as $key => $value) {
        
        $oLista=new Lista("linea_inventario");
        $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
        $oLista->setFiltro("codigo","=",$value["codigoLinea"]);
        $lineaI=$oLista->getLista();
        unset($oLista);

        if (empty($lineaI)) {
            $control=false;
            

        }

        if (!empty($lineaI)) {
            $idLinea=$lineaI[0]["idLineaInventario"];


            $oLista=new Lista("grupo_inventario");
            $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
            $oLista->setFiltro("codigo","=",$value["codigoGrupo"]);
            $grupoI=$oLista->getLista();
            unset($oLista);
            if (!empty($grupoI)) {
                $idGrupo=$grupoI[0]["idGrupoInventario"];
                $control=true;
            }

            if (empty($grupoI)) {
                $control=false;
            }

        }
       
        if ($control===false) {
            // $fallos
            array_push($fallos,$value["referencia"]);
        }

        if ($control===true) {

            

        }


        $oLista=new Lista("producto_servicio");
        $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
        $oLista->setFiltro("codigo","=",$value["referencia"]);
        $productoI=$oLista->getLista();
        unset($oLista);   

        if (empty($productoI)) {
            
            $aItem["codigo"]=$value["referencia"]; 
            $aItem["nombre"]=$value["descripcion"];
            $aItem["idGrupo"]=$idGrupo;
            $aItem["idEmpresa"]=$datos["idEmpresa"];
            $aItem["idUsuario"]=$_SESSION["idUsuario"];
            $aItem["fechaRegistro"]=date('Y-m-d H:i:s');
            $aItem["descripcion"]=$value["descripcion"];
            $aItem["tipo"]=1;  
            $aItem["inventario"]=1;


            $oItem=new Data("producto_servicio","idProductoServicio"); 
            foreach($aItem  as $key => $valueP){
                $oItem->$key=$valueP; 
            }
            $oItem->guardar(); 
            $idProducto=$oItem->ultimoId();
            unset($oItem);
        }

        if (!empty($productoI)) {
            $idProducto=$productoI[0]["idProductoServicio"];
        }


        $oLista = new Lista('bodega');
        $oLista->setFiltro("idEmpresa","=",$datos['idEmpresa']);
        $bodegaI=$oLista->getLista();
        unset($oLista);

        if (empty($bodegaI)) {
            
            $aItemB["codigo"]=1;
            $aItemB["nombre"]="PRINCIPAL";
            $aItemB["idEmpresa"]=$datos['idEmpresa'];
            $aItemB["idUsuarioRegistra"]=$_SESSION["idUsuario"];
            $aItemB["fechaRegistro"]= date("Y-m-d H:i:s");

            $oItem=new Data("bodega","idBodega"); 
            foreach($aItemB  as $key => $valueB){
                $oItem->$key=$valueB; 
            }
                $oItem->guardar();
                $bodega=$oItem->ultimoId();
                unset($oItem);
        }
        if (!empty($bodegaI)) {
            $bodega=$bodegaI[0]["idBodega"];
        }


        $oLista = new Lista('inventario_inicial');
        $oLista->setFiltro("idEmpresa","=",$datos['idEmpresa']);
        $oLista->setFiltro("idProducto","=",$idProducto);
        $oLista->setFiltro("idBodega","=",$bodega);
        $aInventario=$oLista->getLista();
        unset($oLista);

    if (empty($aInventario)) {

        $aItem["idProducto"]=$idProducto;
        $aItem["idUnidad"]=1;
        $aItem["idCategoria"]=0;
        $aItem["existencia"]=$value["saldo"];
        $aItem["fecha"]= date("Y-m-d");
        $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"];
        $aItem["idEmpresa"]=$datos['idEmpresa'];
        $aItem["stockMinimo"]=$value['stockMinimo'];
        $aItem["idBodega"]=$bodega;

        $oItem=new Data("inventario_inicial","idInventarioInicial"); 
        foreach($aItem  as $key => $value){
            // print_r($value);
            $oItem->$key=$value; 
        }
            $oItem->guardar(); 
           unset($oItem);
    }  
}

$msg=true; 

echo json_encode(array("msg"=>$msg,"fallos"=>$fallos));

?>



