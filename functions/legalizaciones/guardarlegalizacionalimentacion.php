<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );


if( isset($_FILES['file']) && $_FILES['file'] != 'undefined')

    {

               

        $sNombre = $_FILES['file']['name'];                

        $sExtension = substr(strrchr($sNombre, '.'), 1);

        $sTemporal = $_FILES['file']['tmp_name'];

        

        $nombreEncript = uniqid(); 

        

        $nombre_archivo = "{$nombreEncript}.{$sExtension}"; 

        

        $directorioTmp = 'LEGALIZACIONES/';

        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  



        if(move_uploaded_file($sTemporal, "../../".$directorioTmp.$nombre_archivo))

        {                                                 

            $sFoto = 'LEGALIZACIONES/'.$nombre_archivo;

        }

        else

        {

            $sFoto = "";

        }

    

} 






    if(!isset($_SESSION)){ session_start(); }



    $aDatos["concepto"]=$datos["concepto"]; 

    $aDatos["valor"]=$datos["valor"]; 

    $aDatos["tipoFactura"]=$datos["legalizarcon"]; 

    $aDatos["emiteFactura"]=$datos["emiteFactura"]; 

    $aDatos["numeroFactura"]=$datos["numeroFacura"]; 
    
    $aDatos["fechaFactura"]=$datos["fechaFactura"]; 

    $aDatos["idDepartamento"]=$datos["idDepartamento"]; 

    $aDatos["idCiudad"]=$datos["idCiudad"]; 


    $aDatos["archivo"]=$sFoto;

    $aDatos["fechaRegistro"]=date("Y-m-d");

    $aDatos["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 

    $aDatos["tipoLegalizacion"]=$datos["tipoLegalizacion"]; 
    $aDatos["estado"]=1;

    $aDatos["idProyectoLegalizacion"]=$datos["idProyectoLegalizacion"];

    $aDatos["idEmpresa"]=$_SESSION["idEmpresa"];

    $oItem=new Data("legalizaciones","idLegalizacion"); 

    foreach($aDatos  as $key => $value){

        $oItem->$key=$value; 

    }

    $oItem->guardar(); 

    $idProveedor=$oItem->ultimoId(); 

    unset($oItem);



    $msg=true; 



echo json_encode(array("msg"=>$msg));

?>