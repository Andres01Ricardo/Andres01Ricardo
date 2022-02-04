<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );


if(!isset($_SESSION)){ session_start(); }



        // $aItem["idEmpresa"]=$empresa;

        // $aItem["comprobante"]=$datos["comprobante"];

        // $aItem["tipo"]=$datos["tipoDocumento"]; 

        // $aItem["descripcion"]=$datos["descripcion"]; 
 
        // $aItem["numeracionInicial"]=$datos["numeracionInicial"]; 

        $aItem["numeracionActual"]=$datos["numeracionActual"]; 

        // $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"];


        $oItem=new Data("parametros_documentos","idParametrosDocumentos",$datos["idParametrosDocumentos"]); 

        foreach($aItem  as $key => $value){

            $oItem->$key=$value; 

        }

        $oItem->guardar(); 

       
        
        unset($oItem);


$msg=true; 

echo json_encode(array("msg"=>$msg));

?>