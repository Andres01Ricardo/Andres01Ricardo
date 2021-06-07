<?php
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota");
if(!isset($_SESSION)){ session_start(); 

	$_SESSION["idEmpresa"]=$_POST["selectIdEmpresa"]; 
}
 



  header('location: ../../pipeline');

 ?>