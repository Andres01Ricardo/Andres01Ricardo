<?php



header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

// include_once($CLASS . "control.php");



// $oControl=new Control();



$username  = (isset($_REQUEST['usuario'] ) ? $_REQUEST['usuario'] : "" );

$password  = (isset($_REQUEST['contrasena'] ) ? $_REQUEST['contrasena'] : "" );



$oLista = new Lista('usuario');

$oLista->setFiltro("numeroDocumento","=",$username);

$lista=$oLista->getLista();

$error=true;



if ( (count($lista)==0)){

	$msg='Usuario no registrado';

	$error=false; 

}elseif($lista[0]["clave"]!=md5($password)){

	$msg='Contraseña incorrecta';

	$error=false; 

}elseif($lista[0]["estado"]!=1){

	$msg='Usuario inactivo';

	$error=false; 

}elseif($lista[0]["ingresoPlataforma"]!=1){

	$msg='Acceso bloqueado';

	$error=false; 

}





if($error===true){



$foto="https://via.placeholder.com/250x250/CCC?text=SIN%20FOTO"; 

if($lista[0]["foto"]!=""){

    $foto=$URL.$lista[0]["foto"]; 

}



if(!isset($_SESSION)){ session_start(); }

$id=uniqid();

$oItem = new Data('usuario',"idUsuario", $lista[0]["idUsuario"]);

$oItem->acceso=$id; 

$oItem->guardar(); 

unset($oItem);



if($lista[0]["idRol"]==3){

  $oItem = new Data('empresa_acceso',"idUsuario", $lista[0]["idUsuario"]);

  $aAcceso=$oItem->getDatos();

  unset($oItem);



  $oItem = new Data('empresa',"idEmpresa", $aAcceso["idEmpresa"]);

  $aEmpresa=$oItem->getDatos();

  unset($oItem);

  $_SESSION["idEmpresa"]=$aEmpresa["idEmpresa"];



}



if($lista[0]["idRol"]==4){

  $oItem = new Data('empleado_usuario',"idUsuario", $lista[0]["idUsuario"]);

  $aAcceso=$oItem->getDatos();

  unset($oItem);



  $oLista = new Lista('empleado_informacion_laboral');

  $oLista->setFiltro("idEmpleado","=",$aAcceso["idEmpleado"]);

  $oLista->setFiltro("estado","=",1);

  $iEmpresa=$oLista->getLista()[0];



  $oItem = new Data('empresa',"idEmpresa", $iEmpresa["idEmpresa"]);

  $aEmpresa=$oItem->getDatos();

  unset($oItem);



  $_SESSION["idEmpresa"]=$aEmpresa["idEmpresa"];

}

if($lista[0]["idRol"]==6){
  $_SESSION["idEmpresa"]=6;
}

if($lista[0]["idRol"]==7){
  $oItem = new Data('usuario_empresa',"idUsuario", $lista[0]["idUsuario"]);
  $aAcceso=$oItem->getDatos();
  unset($oItem);


  $oItem = new Data('empresa',"idEmpresa", $aAcceso["idEmpresa"]);
  $aEmpresa=$oItem->getDatos();
  unset($oItem);

  $_SESSION["idEmpresa"]=$aEmpresa["idEmpresa"];
  // $_SESSION["idEmpresa"]=6;
}


$_SESSION["idUsuario"]= $lista[0]["idUsuario"];

$_SESSION["acceso"]= $id;

$_SESSION["nombreUsuario"]= $lista[0]["nombreUsuario"];

$_SESSION["apellidoUsuario"]= $lista[0]["apellidoUsuario"];

$_SESSION["cambiarClave"]= $lista[0]["cambiarClave"];

$_SESSION["foto"]= $foto;

$_SESSION["login"]="Si"; 

$_SESSION["idRol"]=$lista[0]["idRol"];         

$msg="inicio";                                

}

 

echo json_encode(array("msg"=>$msg,"error"=>$error));

?>