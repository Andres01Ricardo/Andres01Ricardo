<?php

require_once("../../php/restrict.php");
// require_once("../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

date_default_timezone_set("America/Bogota"); 


$fecha_actual = date("Y-m-d");


$fechaUnAnio= date("Y-m-d",strtotime($fecha_actual."- 1 year"));

$fechaAnioMes=date("Y-m-d",strtotime($fechaUnAnio."- 1 month"));

print_r($fecha_actual);
print_r('****');
print_r($fechaUnAnio);
print_r('****');
print_r($fechaAnioMes);

$hoy = date("Y-m-d");

$oEmpleado=new Lista("empleado_informacion_laboral");
$oEmpleado->setFiltro("fechaIngreso","=",$fechaAnioMes);
$oEmpleado->setFiltro("estado","=",'1');
$empleados=$oEmpleado->getLista();




?>

  <div class="card card-body">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>ingreso</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach($empleados as $key => $value){
            $oItem=new Data("empleado","idEmpleado",$value["idEmpleado"]);
            $emp=$oItem->getDatos();
            unset($oItem);


           ?>
          <tr>
            <td><?php echo $emp["nombre"].' '.$emp["apellido"]; ?></td>
            <td><?php echo $value["fechaIngreso"]; ?></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
  </div>