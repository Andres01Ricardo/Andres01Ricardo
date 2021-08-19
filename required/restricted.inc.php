<?php



if(!isset($_SESSION)){ session_start(); }

$mod2 = (isset($_REQUEST['page'] ) ? $_REQUEST['page'] : 'login');



if (!isset($_SESSION["login"])){

	if($mod2!="login"){

		header("location:".$URL."login");	

		

	} 	

}else{

	$oItem = new Data('usuario',"idUsuario",$_SESSION["idUsuario"]);

	$aValidate=$oItem->getDatos(); 

	unset($oItem); 

	

	if($aValidate["acceso"]!=$_SESSION["acceso"]){

	header("Location: ../functions/sesion/cerrarsesion.php");

	}



	$pageIndex="inicio";



	

	if($_SESSION["cambiarClave"]==1){

		//$pageIndex="cambiarclave"; 

	}



	if($mod2=='login'){

		 header("location:".$URL.$pageIndex);

	}

}



?>