<?php
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota");

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );

 
 
    if(!isset($_SESSION)){ session_start(); }



$oItem=new Data("t_clientes","idCliente",$datos["documento"]); 
$aCliente=$oItem->getDatos();
unset($oItem);

if (empty($aCliente)) {
   


        $aDatos["tipo_documento"]=$datos["tipoDocumento"]; 
        $aDatos["idCliente"]=$datos["documento"]; 
        $aDatos["nombre"]=$datos["nombre"];
        if ($datos["apellidos"] =='') {
            $aDatos["apellidos"]=' '; 
        }
        if ($datos["apellidos"] !='') {
            $aDatos["apellidos"]=$datos["apellidos"]; 
        }
        
        $aDatos["email"]=$datos["email"]; 
        $aDatos["telefono"]=$datos["telefono"]; 

        if ($datos["procedencia"] == 0) {
            $aDatos["procedencia"]=0;
        }if ($datos["procedencia"] != 0) {

            $aDatos["procedencia"]=$datos["procedencia"]; 
        }
        $aDatos["direccion"]=$datos["direccion"]; 

        if ($datos["empleadoEncargado"] == 0) {

            $aDatos["encargado"]=$_SESSION["idUsuario"]; 
        }if ($datos["empleadoEncargado"] != 0) {

            $aDatos["encargado"]=$datos["empleadoEncargado"];
        }      
            
        $aDatos["etapa"]=$datos["etapa"];
        $aDatos["fechaUltimoContacto"]=date("Y-m-d");
        $aDatos["fechaCreacion"]=date("Y-m-d");
        $aDatos["idUsuarioRegistra"]=$_SESSION["idUsuario"];  
        $aDatos["idEmpresa"]=$_SESSION["idEmpresa"]; 
        $aDatos["empresa"]=$datos["empresa"]; 




        $oItem=new Data("t_clientes","codigoCliente"); 
            foreach($aDatos  as $key => $value){
                $oItem->$key=$value; 
                // echo $value;
                // echo "=>";
            }
            $oItem->guardar(); 
            $codigoCliente=$oItem->ultimoId(); 
            unset($oItem);




            $cDatos["tipo"]='creado';
            $cDatos["fechaCreacion"] = $aDatos["fechaCreacion"];
            $cDatos["horaCreacion"] =date("H:m:s");
            $cDatos["creador"] = $aDatos["idUsuarioRegistra"];
            $cDatos["icono"] = '6';
            $cDatos["idCliente"] = $codigoCliente;

            $oItem=new Data("actividades","idActividad"); 
            foreach($cDatos  as $key => $value){
            $oItem->$key=$value; 
            }
            $oItem->guardar(); 
            unset($oItem);


            $dDatos["fechaNotificacion"]=date("Y-m-d H:m:s");
            $dDatos["idUsuarioRegistra"] = $aDatos["idUsuarioRegistra"];
            $dDatos["idUsuarioNotificado"] =$aDatos["encargado"];
            $dDatos["notificacion"] = 'Le fue asignado el cliente '.$datos["nombre"].' '.$datos["apellidos"];
            

            $oItem=new Data("notificacion","idNotificacion"); 
            foreach($dDatos  as $key => $value){
            $oItem->$key=$value; 
            }
            $oItem->guardar(); 
            unset($oItem);

$msg=true;
}else{
    $msg=false;
}
    
    echo json_encode(array("msg"=>$msg));



 ?>
