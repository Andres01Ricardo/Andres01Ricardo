<?php 

header('Content-type: application/json');

require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();



date_default_timezone_set("America/Bogota"); 



$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

$item  = (isset($_REQUEST['item'] ) ? $_REQUEST['item'] : "" );



if( isset($_FILES['excel']) && $_FILES['excel'] != 'undefined')

    {

               

        $sNombre = $_FILES['excel']['name'];                

        $sExtension = substr(strrchr($sNombre, '.'), 1);

        $sTemporal = $_FILES['excel']['tmp_name'];

        

        $nombreEncript = uniqid(); 

        

        $nombre_archivo = "{$nombreEncript}.{$sExtension}"; 

        

        $directorioTmp = 'EFINANCIERO/';

        $ubicacionTmp = "{$directorioTmp}{$nombre_archivo}";  



        if(move_uploaded_file($sTemporal, "../../".$directorioTmp.$nombre_archivo))

        {	

            $sFinanciero = 'EFINANCIERO/'.$nombre_archivo;

        }else{

        	echo "vacio"; 

        }

    

} 

if(!isset($_SESSION)){ session_start(); }

$periodo=explode("-",$datos["periodo"]); 

$aDatos["idEmpresa"]=$datos["idEmpresa"]; 

$aDatos["periodoMes"]=$periodo[0]; 

$aDatos["periodoAnio"]=$periodo[1]; 

$aDatos["anexo"]=$sFinanciero; 

$aDatos["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 

$aDatos["titulo"]=$datos["titulo"]; 

$aDatos["subtitulo"]=$datos["subtitulo"]; 

$aDatos["fechaRegistro"]=date("Y-m-d H:i:s"); 



$oItem=new Data("estado_financiero","idEstadoFinanciero"); 

foreach($aDatos  as $key => $value){

    $oItem->$key=$value; 

}

$oItem->guardar(); 

$idEstadoFinanciero=$oItem->ultimoId(); 

unset($oItem);





foreach($item  as $valor){

   $valor["valor"]=$oControl->eliminarMoneda($valor["valor"]); 

   $valor["idEstadoFinanciero"]=$idEstadoFinanciero; 



    $oItem=new Data("estado_financiero_item","idEstadoFinancieroItem"); 

    foreach($valor  as $key => $value){

        $oItem->$key=$value; 

    }

    $oItem->guardar(); 

    unset($oItem);

}

   $oItem=new Data("empresa_acceso","idEmpresa",$datos["idEmpresa"]); 

    $aUser=$oItem->getDatos();

    unset($oItem); 


    $sDatos["fechaNotificacion"]=date("Y-m-d H:m:s");
    $sDatos["idUsuarioRegistra"] = $_SESSION["idUsuario"];
    $sDatos["idUsuarioNotificado"] =$aUser["idUsuario"];
    $sDatos["notificacion"] =  "El usuario ".$_SESSION["nombreUsuario"]." ".$_SESSION["apellidoUsuario"]." ha cargado el estado financiero";
    

    $oItem=new Data("notificacion","idNotificacion"); 
    foreach($sDatos  as $key => $svalue){
    $oItem->$key=$svalue; 
    }
    $oItem->guardar(); 
    unset($oItem);

echo json_encode(array("msg"=>true)); 



?>