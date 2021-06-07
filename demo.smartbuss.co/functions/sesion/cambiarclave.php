<?php
header('Content-type: application/json');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");


 $password  = (isset($_REQUEST['clave'] ) ? $_REQUEST['clave'] : "" );
 $newPassword  = (isset($_REQUEST['nuevaClave'] ) ? $_REQUEST['nuevaClave'] : "" );

if($password!=$newPassword){
  $error=false;
  $msg=="Las claves deben coincidir"; 
}else{
  session_start();

  $_SESSION["cambiarClave"]=0; 

  $oItem = new Data('usuario',"idUsuario", $_SESSION["idUsuario"]);
  $oItem->clave=md5($password); 
  $oItem->cambiarClave=0; 
  $oItem->guardar();
  unset($oItem);

  $msg="dashboard"; 
  $error=true;
}

echo json_encode(array("msg"=>$msg,"error"=>$error));
?>