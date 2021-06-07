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




	function informacionCliente($codigocliente,$conn){


		$query="SELECT c.codigoCliente,c.idCliente,c.nombre,c.apellidos,c.email,c.telefono,p.nombreProcedencia,c.direccion,concat(e.nombreEmpleado,' ' ,e.apellidosEmpleado) as encargado, et.nombreEtapa as etapa, c.fechaUltimoContacto,c.fechaCreacion FROM t_clientes as c
                  inner join t_empleados as e on c.encargado=e.idEmpleado
                  inner join t_procedencia as p on c.procedencia=p.idProcedencia
                  inner join t_etapas as et on c.etapa=et.codigo
                  where c.codigoCliente=$codigocliente ";
                                    
                  $aCliente=$oLista->ejecutarSql($query);
                  return $aCliente;
	}
	function clienteEtapas($etapa,$conn){

		$query="SELECT c.codigoCliente,c.idCliente,c.nombre,c.apellidos,c.email,c.telefono,p.nombreProcedencia,c.direccion,concat(e.nombreEmpleado,' ' ,e.apellidosEmpleado) as encargado, et.nombreEtapa as etapa, c.fechaUltimoContacto,c.fechaCreacion FROM t_clientes as c
            inner join t_empleados as e on c.encargado=e.idEmpleado
            inner join t_procedencia as p on c.procedencia=p.idProcedencia
            inner join t_etapas as et on c.etapa=et.codigo
            where c.etapa=$etapa
            ORDER BY c.codigoCliente";
 			$result=mysqli_query($conn,$query);
 			return $result;
	}

      function clientesEmpleados($empleado,$conn){
            $query="SELECT c.nombre,c.apellidos,c.fechaUltimoContacto, e.nombreEtapa from t_clientes as c
            inner join t_etapas as e on c.etapa = e.codigo
            where encargado= $empleado
            order by etapa";
            $result=mysqli_query($conn,$query);
            return $result;
      }
      function procedencia($conn){
            $query="SELECT c.procedencia,p.nombreProcedencia as nombre, count(procedencia) as total from t_clientes as c
            inner join t_procedencia as p on c.procedencia = p.idProcedencia
            group by procedencia";
            $result=mysqli_query($conn,$query);
            return $result;
      }


?>