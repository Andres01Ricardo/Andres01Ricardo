<?php

require_once("../../php/restrict.php");


include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");




include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");


date_default_timezone_set("America/Bogota"); 

$id  = (isset($_REQUEST['idEmpresa'] ) ? $_REQUEST['idEmpresa'] : "" );

$tipoDetalle  = (isset($_REQUEST['tipoDetalle'] ) ? $_REQUEST['tipoDetalle'] : "" );




// include_once("../../class/proveedores.php"); 
// include_once("../../class/clientes.php"); 

include_once("../../class/terceros.php"); 


// $oControl=new Control(); 
// $oProveedor=new Proveedores();


  
  // $aProveedores=$oProveedor->getProveedoresEmpresa(array("ingresoPerfilEmpresa"=>$validarIngreso));


//   $aProveedores=$oProveedor->getProveedoresEmpresa(array("idEmpresa"=>$id));






// if ($tipoDetalle=='1') {

// 	$oClientes=new Clientes(); 
// 	$aClientes=$oClientes->getClientesE(array("idEmpresa"=>$id));

// 	$oProveedor=new Terceros();
//   	$aProveedores=$oProveedor->getProveedoresEmpresa(array("idEmpresa"=>$id));

//   	$oEmpleado=new Terceros();
// 	$aEmpleado=$oEmpleado->getEmpleadosEmpresaTercero(array("idEmpresa"=>$id));

// 	$aLista=array_merge($aClientes,$aProveedores,$aEmpleado);
	
// 	// $oCliente=new Lista("cliente_empresa");  
// 	// $oLista->setFiltro("idEmpresa","=",$id);
// 	// $aCliente=$oCliente->getLista();
// 	// foreach ($aCliente as $key => $value) {
		
// 	// }
// }
// if ($tipoDetalle=='2') {

// 	$oClientes=new Clientes(); 
// 	$aLista=$oClientes->getClientesE(array("idEmpresa"=>$id));
	
// 	// $oCliente=new Lista("cliente_empresa");  
// 	// $oLista->setFiltro("idEmpresa","=",$id);
// 	// $aCliente=$oCliente->getLista();
// 	// foreach ($aCliente as $key => $value) {
		
// 	// }
// }
// if ($tipoDetalle=='3') {

// 	// $oClientes=new Clientes(); 
// 	// $aClientes=$oClientes->getClientesE(array("idEmpresa"=>$id));
	
// 	$oProveedor=new Terceros();
//   	$aLista=$oProveedor->getProveedoresEmpresa(array("idEmpresa"=>$id));
// }

$oClientes=new Terceros(); 
$aLista=$oClientes->getTercerosEmpresa(array("idEmpresa"=>$id));



// $oProveedor=new Lista("proveedor");  
// $oLista->setFiltro("")
// $aProveedor=$oProveedor->getLista(); 
// setFiltro();
// unset($oItem);

// $aLista=$aClientes;









echo json_encode($aLista); 

?>
