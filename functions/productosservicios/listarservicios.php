<?php

require_once("php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");



date_default_timezone_set("America/Bogota"); 





$oLista = new Lista();

$sql="SELECT p.idProductoServicio, p.nombre, p.codigo, e.razonSocial

    FROM producto_servicio as p 

    

    INNER JOIN empresa as e ON(e.idEmpresa=p.idEmpresa)

    WHERE 0=0 AND p.tipo=2"; 



    $aProductos=$oLista->ejecutarSql($sql); 



return $aProductos; 

?>