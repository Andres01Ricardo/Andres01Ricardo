<?php

require_once("php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 



if(!isset($_SESSION)){ session_start(); }

$oLista = new Lista();

if(!empty($_SESSION["idEmpresa"])){
    $condicion.=" AND p.idEmpresa=".$_SESSION["idEmpresa"]; 
}


$sql="SELECT p.idProductoServicio, p.nombre, p.codigo, e.razonSocial

    FROM producto_servicio as p 


    INNER JOIN empresa as e ON(e.idEmpresa=p.idEmpresa)

    WHERE 0=0  ".$condicion." AND p.tipo=2"; 



    $aProductos=$oLista->ejecutarSql($sql); 



return $aProductos; 

?>