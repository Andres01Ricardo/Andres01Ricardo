<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");


date_default_timezone_set("America/Bogota"); 


$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );




if(!isset($_SESSION)){ session_start(); }

        $aItem["nombre"]=$datos["categoria"];
        $aItem["idEmpresa"]=$datos['idEmpresa'];
        $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"];
        $aItem["fechaRegistro"]= date("Y-m-d H:i:s");

        
        $oItem=new Data("categoria_inventario","idCategoriaInventario"); 
        foreach($aItem  as $key => $value){
            // print_r($value);
            $oItem->$key=$value; 
            
        }
            $oItem->guardar(); 
        
           unset($oItem);

$msg=true; 

echo json_encode(array("msg"=>$msg));

?>



