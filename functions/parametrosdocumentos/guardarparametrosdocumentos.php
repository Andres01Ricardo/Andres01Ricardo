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

if ($_SESSION['idRol']==1 || $_SESSION['idRol']==2 || $_SESSION['idRol']==5) {
    $empresa=$datos['idEmpresa'];
}
if ($_SESSION['idRol']==3 || $_SESSION['idRol']==4) {
    $empresa=$_SESSION['idEmpresa'];
}


        $aItem["idEmpresa"]=$empresa;

        $aItem["comprobante"]=$datos["comprobante"];

        $aItem["tipo"]=$datos["tipoDocumento"]; 

        $aItem["descripcion"]=$datos["descripcion"]; 
 
        $aItem["numeracionInicial"]=$datos["numeracionInicial"]; 

        $aItem["numeracionActual"]=$datos["numeracionInicial"]; 

        $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"];


        $oItem=new Data("parametros_documentos","idParametrosDocumentos"); 

        foreach($aItem  as $key => $value){

            $oItem->$key=$value; 

        }

        $oItem->guardar(); 

       
        
        unset($oItem);


$msg=true; 

echo json_encode(array("msg"=>$msg));

?>