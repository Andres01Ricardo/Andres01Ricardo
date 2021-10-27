<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );
$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );
// $comprobante  = (isset($_REQUEST['comprobante'] ) ? $_REQUEST['comprobante'] : "" );


// print_r($datos);

// print_r($comprobante);

if(!isset($_SESSION)){ session_start(); }


foreach ($item as $key => $value) {
    
        $oItem=new Lista("centro_costo");
        $oItem->setFiltro("codigoCentroCosto","=",$value["codigoCentroCosto"]);
        $oItem->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
        $aCentroCosto=$oItem->getLista();
        unset($oItem);
        
        if (empty($aCentroCosto)) {
            $aDatosCC["codigoCentroCosto"]=$value["codigoCentroCosto"]; 
            $aDatosCC["centroCosto"]=$value["centroCosto"]; 
            $aDatosCC["fechaRegistro"]=date('Y-m-d'); 
            $aDatosCC["usuarioRegistra"]=$_SESSION['idUsuario']; 
            $aDatosCC["idEmpresa"]=$datos["idEmpresa"]; 
            
            $oItem=new Data("centro_costo","idCentroCosto"); 
            foreach($aDatosCC  as $keyCC => $valueCC){
                $oItem->$keyCC=$valueCC; 
            }
            $oItem->guardar(); 
            $idCentroCosto=$oItem->ultimoId(); 
            unset($oItem);
        }
        if (!empty($aCentroCosto)) {
            $idCentroCosto=$aCentroCosto[0]["idCentroCosto"];
        }
        // print_r($idCentroCosto);

        if ($idCentroCosto!="") {
            if ($value["codigoSubcentroCosto"]!="") {
                $oItem=new Lista("subcentro_costo");
                $oItem->setFiltro("codigoSubcentroCosto","=",$value["codigoSubcentroCosto"]);
                $oItem->setFiltro("idCentroCosto","=",$idCentroCosto);
                $aSubcentroCosto=$oItem->getLista();
                unset($oItem);
                
                if (empty($aSubcentroCosto)) {
                    $aDatosSC["codigoSubcentroCosto"]=$value["codigoSubcentroCosto"]; 
                    $aDatosSC["subcentroCosto"]=$value["subcentroCosto"]; 
                    $aDatosSC["idCentroCosto"]=$idCentroCosto; 
                    
                    
                    $oItem=new Data("subcentro_costo","idSubcentroCosto"); 
                    foreach($aDatosSC  as $keySC => $valueSC){
                        $oItem->$keySC=$valueSC; 
                    }
                    $oItem->guardar(); 
                    unset($oItem);
                }
                
            }
        }

        

    
}


    $msg=true; 



    echo json_encode($msg);

?>