<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );



if(!isset($_SESSION)){ session_start(); }

    
    $oLista=new Lista("tope");
    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
    // $oLista->setFiltro("idCuentaContable","=",$datos['tipoDeduccion']);
    // $oLista->setFiltro("idEmpresaCuenta","=",$datos["idCuentaContable"]);
    // $oLista->setFiltro("tipoFactura","=",$datos["tipoFactura"]);
    $topes=$oLista->getlista();
    unset($oLista);

    if (empty($topes)) {
        

        $tope["topeCostos"]=str_replace(",00","",str_replace("$", "", str_replace(".", "", $datos["topeCostos"])));
        
        $tope["topeIngresosBrutos"]=str_replace(",00","",str_replace("$", "", str_replace(".", "", $datos["topeIngresosBrutos"])));

        $tope["topePasivos"]=str_replace(",00","",str_replace("$", "", str_replace(".", "", $datos["topePasivos"])));

        $tope["topeCuentasCobrar"]=str_replace(",00","",str_replace("$", "", str_replace(".", "", $datos["topeCuentasCobrar"])));

        
        $tope["idEmpresa"]=$_SESSION["idEmpresa"];

        $tope["idUsuarioRegistra"]=$_SESSION['idUsuario'];

        $tope["fechaRegistro"]=date('Y-m-d');
        

        

        $oItem=new Data("tope","idTope");  
            foreach($tope  as $keya => $valuea){
                $oItem->$keya=$valuea; 
            }
            $oItem->guardar(); 
            unset($oItem);


       $msg=true; 

    }


    if (!empty($topes)) {

        $tope["topeCostos"]=str_replace(",00","",str_replace("$", "", str_replace(".", "", $datos["topeCostos"])));
        
        $tope["topeIngresosBrutos"]=str_replace(",00","",str_replace("$", "", str_replace(".", "", $datos["topeIngresosBrutos"])));

        $tope["topePasivos"]=str_replace(",00","",str_replace("$", "", str_replace(".", "", $datos["topePasivos"])));

        $tope["topeCuentasCobrar"]=str_replace(",00","",str_replace("$", "", str_replace(".", "", $datos["topeCuentasCobrar"])));

        
        $tope["idEmpresa"]=$_SESSION["idEmpresa"];

        $tope["idUsuarioRegistra"]=$_SESSION['idUsuario'];

        $tope["fechaRegistro"]=date('Y-m-d');
        

        $oItem=new Data("tope","idTope",$topes[0]["idTope"]);  
            foreach($tope  as $keya => $valuea){
                $oItem->$keya=$valuea; 
            }
            $oItem->guardar(); 
            unset($oItem);

        $msg=false;         
    }

    echo json_encode(array("msg"=>$msg));

 ?>