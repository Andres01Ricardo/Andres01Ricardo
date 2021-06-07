<?php

header('Content-type: application/json');
require_once("../../php/restrict.php");

// include_once($CLASS . "data.php");
// include_once($CLASS . "lista.php");
include_once($CLASS . "control.php");

$oControl=new Control();


$aDatos["correo"]="jesusdeleont04@gmail.com"; 
$aDatos["asunto"]="asunto de prueba"; 
$aDatos["mensaje"]="mensaje de prueba"; 

//var_dump($aDatos); 
$error=$oControl->enviarCorreo($aDatos); 
echo json_encode(array("msg"=>true,"error"=>$error));
?>