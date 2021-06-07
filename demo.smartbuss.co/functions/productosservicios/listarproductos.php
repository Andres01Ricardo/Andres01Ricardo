<?php
require_once("php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 


$oLista = new Lista();
$sql="SELECT p.idProductoServicio, p.nombre, p.codigo, b.nombre as bienes, c.nombre as clase, f.nombre as familia, s.nombre as segmento, g.nombre as grupo, e.razonSocial
    FROM producto_servicio as p 
    INNER JOIN bienes as b ON(b.idBienes=p.idBienes)
    INNER JOIN clase as c ON(c.idClase=b.idClase)
    INNER JOIN familia as f ON(f.idFamilia=c.idFamilia)
    INNER JOIN segmento as s on(s.idSegmento=f.idSegmento)
    INNER JOIN grupo as g ON(s.idGrupo=g.idGrupo)
    INNER JOIN empresa as e ON(e.idEmpresa=p.idEmpresa)
    WHERE 0=0 AND p.tipo=1"; 

    $aProductos=$oLista->ejecutarSql($sql); 

return $aProductos; 
?>