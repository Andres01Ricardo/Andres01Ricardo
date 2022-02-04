<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );
// $item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );
// $banco  = (isset($_REQUEST['banco'] ) ? $_REQUEST['banco'] : "" );


if(!isset($_SESSION)){ session_start(); }

    
    $oLista=new Lista("nomina_cuenta_contable");
    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
    $oLista->setFiltro("idConcepto","=",$datos['idConcepto']);
    $oLista->setFiltro("idEmpresaCuenta","=",$datos["idCuentaContable"]);
    // $oLista->setFiltro("tipoFactura","=",$datos["tipoFactura"]);
    $nominaparametrizada=$oLista->getlista();
    unset($oLista);

    if (empty($nominaparametrizada)) {



        if ($datos["idConcepto"]=="1") {
            
            $nominap["concepto"]="Salario base";
            $nominap["tipo"]="1";
        }

        if ($datos["idConcepto"]=="2") {
            
            $nominap["concepto"]="Auxilio transporte";
            $nominap["tipo"]="1";
        }

        if ($datos["idConcepto"]=="3") {
            
            $nominap["concepto"]="Salud empleado";
            $nominap["tipo"]="1";
        }

        if ($datos["idConcepto"]=="4") {
            
            $nominap["concepto"]="Pensión empleado";
            $nominap["tipo"]="1";
        }

        if ($datos["idConcepto"]=="5") {
            
            $nominap["concepto"]="Salario por pagar";
            $nominap["tipo"]="1";
        }

        if ($datos["idConcepto"]=="6") {
           $nominap["concepto"]="ARL";
           $nominap["tipo"]="2";
        }

        if ($datos["idConcepto"]=="7") {
           $nominap["concepto"]="Caja compensación";
           $nominap["tipo"]="2";
        }
        if ($datos["idConcepto"]=="8") {
           $nominap["concepto"]="Pensión empleador";
           $nominap["tipo"]="2";
        }
        if ($datos["idConcepto"]=="9") {
           $nominap["concepto"]="Salud empleador";
           $nominap["tipo"]="2";
        }
        if ($datos["idConcepto"]=="10") {
           $nominap["concepto"]="Cesantias";
           $nominap["tipo"]="3";
        }
        if ($datos["idConcepto"]=="11") {
           $nominap["concepto"]="Intereses cesantias";
           $nominap["tipo"]="3";
        }
        if ($datos["idConcepto"]=="12") {
           $nominap["concepto"]="Prima";
           $nominap["tipo"]="3";
        }
        if ($datos["idConcepto"]=="13") {
           $nominap["concepto"]="Vacaciones";
           $nominap["tipo"]="3";
        }

           


        $nominap["idConcepto"]=$datos["idConcepto"];
        // $nominap["concepto"]=$datos['concepto'];
        
        $nominap["idEmpresa"]=$datos["idEmpresa"];
        $nominap["idEmpresaCuenta"]=$datos["idCuentaContable"];
        


        $oItem=new Data("nomina_cuenta_contable","idNominaCuentaContable");  
            foreach($nominap  as $keya => $valuea){
                $oItem->$keya=$valuea; 
            }
            $oItem->guardar(); 
            unset($oItem);


       $msg=true; 

    }


    if (!empty($nominaparametrizada)) {
        $msg=false;         
    }

    echo json_encode(array("msg"=>$msg));

 ?>