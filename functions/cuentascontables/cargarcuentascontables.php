<?php

require_once("../../php/restrict.php");


include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

require_once("../../class/cuentascontables.php");




date_default_timezone_set("America/Bogota"); 

$idEmpresa  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );


$oCuentasContables=new CuentasContables(); 
$aCuentasContables=$oCuentasContables->getCuentasContables(array("idEmpresa"=>$idEmpresa));

// $ultimaCuenta=[];
// // $ultimaCuenta = array('' => , );
// foreach ($aCuentasContables as $key => $value) {
//   $oCuentaContable=new CuentasContables(); 
//   $aCuentaContable=$oCuentaContable->getCuentaContable(array("idEmpresa"=>$idEmpresa,"cuenta"=>$value["codigoCuentaContable"]));
  
//   // print_r($aCuentaContable[-1]);
//   $ultimaCuenta[$key]=end($aCuentaContable);
// }

// print_r($ultimaCuenta);
echo json_encode($aCuentasContables); 

?>
