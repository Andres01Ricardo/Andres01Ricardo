<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );



if(!isset($_SESSION)){ session_start(); }

    
    $oLista=new Lista("exogena");
    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
    $oLista->setFiltro("idCuentaContable","=",$datos['tipoDeduccion']);
    // $oLista->setFiltro("idEmpresaCuenta","=",$datos["idCuentaContable"]);
    // $oLista->setFiltro("tipoFactura","=",$datos["tipoFactura"]);
    $exogenaConfigurada=$oLista->getlista();
    unset($oLista);

    if (empty($exogenaConfigurada)) {
        

        $exogena["idCuentaContable"]=$datos['idCuentaContable'];

        $oItem=new Data("cuenta_contable","idCuentaContable",$datos["idCuentaContable"]);
        $cuentaC=$oItem->getDatos();
        unset($oItem);

        $exogena["codigoCuenta"]=$cuentaC["codigoCuenta"];
        
        $exogena["idConcepto"]=$datos["concepto"];
        $exogena["idFormato"]=$datos["idFormato"];
        $exogena["idCategoria"]=$datos["categoria"];

        $exogena["idTipoSuma"]=$datos["tipoSuma"];

        $exogena["idUsuarioRegistra"]=$_SESSION['idUsuario'];

        $exogena["anio"]=date('Y');
        $exogena["idEmpresa"]=$_SESSION["idEmpresa"];
        

        

        $oItem=new Data("exogena","idExogena");  
            foreach($exogena  as $keya => $valuea){
                $oItem->$keya=$valuea; 
            }
            $oItem->guardar(); 
            unset($oItem);


       $msg=true; 

    }


    if (!empty($exogenaConfigurada)) {

        $exogena["idCuentaContable"]=$datos['idCuentaContable'];

        $oItem=new Data("cuenta_contable","idCuentaContable",$datos["idCuentaContable"]);
        $cuentaC=$oItem->getDatos();
        unset($oItem);

        $exogena["codigoCuenta"]=$cuentaC["codigoCuenta"];
        
        $exogena["idConcepto"]=$datos["concepto"];
        $exogena["idFormato"]=$datos["idFormato"];
        $exogena["idCategoria"]=$datos["categoria"];

        $exogena["idTipoSuma"]=$datos["tipoSuma"];

        $exogena["idUsuarioRegistra"]=$_SESSION['idUsuario'];

        $exogena["anio"]=date('Y');
        // $exogena["idEmpresa"]=$_SESSION["idEmpresa"];
        

        

        $oItem=new Data("exogena","idExogena",$exogenaConfigurada[0]["idExogena"]);  
            foreach($exogena  as $keya => $valuea){
                $oItem->$keya=$valuea; 
            }
            $oItem->guardar(); 
            unset($oItem);

        $msg=false;         
    }

    echo json_encode(array("msg"=>$msg));

 ?>