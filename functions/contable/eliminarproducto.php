<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 

$idEliminar  = (isset($_REQUEST['idEliminar'] ) ? $_REQUEST['idEliminar'] : "" );
// $item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );
// $banco  = (isset($_REQUEST['banco'] ) ? $_REQUEST['banco'] : "" );


if(!isset($_SESSION)){ session_start(); }





        $oItem=new Data("producto_cuenta_contable","idProductoCuentaContable",$idEliminar);  
        $oItem->eliminar();
        unset($oItem);

        // $oItem=new Data("tercero_empresa","idTerceroEmpresa",$valuem["idTerceroEmpresa"]);
    


       $msg=true; 


    echo json_encode(array("msg"=>$msg));

 ?>