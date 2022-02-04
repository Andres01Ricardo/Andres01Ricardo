<?php

header('Content-type: application/json');

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control();



date_default_timezone_set("America/Bogota"); 

$datos  = (isset($_REQUEST['datos'] ) ? $_REQUEST['datos'] : "" );
$adiciones  = (isset($_REQUEST['adiciones'] ) ? $_REQUEST['adiciones'] : "" );
$ley  = (isset($_REQUEST['ley'] ) ? $_REQUEST['ley'] : "" );
$deducciones  = (isset($_REQUEST['deducciones'] ) ? $_REQUEST['deducciones'] : "" );
$provisiones  = (isset($_REQUEST['provisiones'] ) ? $_REQUEST['provisiones'] : "" );



if(!isset($_SESSION)){ session_start(); }



$periodo=explode("-",$datos["periodo"]);
$datos["tiempoPago"]=$datos["tiempoPago"]==""?0:$datos["tiempoPago"]; 



$oLista = new Lista('nomina');
$oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
$oLista->setFiltro("periodoMes","=",$periodo[0]);
$oLista->setFiltro("periodoAnio","=",$periodo[1]);
$oLista->setFiltro("tiempoPago","=",$datos["tiempoPago"]);
$aNomina=$oLista->getLista();

unset($oLista); 



if(!empty($aNomina)){

	$idNomina=$aNomina[0]["idNomina"]; 

}if(empty($aNomina)){

	$aDatos["fechaRegistro"]=date("Y-m-d H:i:s"); 

	$aDatos["idEmpresa"]=$datos["idEmpresa"]; 

	$aDatos["periodoMes"]=$periodo[0]; 

	$aDatos["periodoAnio"]=$periodo[1]; 

	$aDatos["tiempoPago"]=$datos["tiempoPago"]; 

	$aDatos["estado"]=1; 

	$oItem=new Data("nomina","idNomina"); 

	foreach ($aDatos as $key => $value) {

	  $oItem->$key=$value; 

	}

	$oItem->guardar(); 

	$idNomina=$oItem->ultimoId();

	unset($oItem);

}



$oLista = new Lista('nomina_empleado');

$oLista->setFiltro("idNomina","=",$idNomina);

$oLista->setFiltro("idEmpleado","=",$datos["idEmpleado"]);

$aEmpleado=$oLista->getLista();

unset($oLista);



if(!empty($aEmpleado)){

	$msg=false; 

}
if(empty($aEmpleado)){

		$aDatosEmpleado["fechaRegistro"]=date("Y-m-d H:i:s"); 

		$aDatosEmpleado["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 

		$aDatosEmpleado["idNomina"]=$idNomina; 

		$aDatosEmpleado["idEmpleado"]=$datos["idEmpleado"]; 

		$aDatosEmpleado["salarioEmpleado"]=str_replace("$", "", str_replace(".", "", $datos["salario"]));

		$aDatosEmpleado["valorPagar"]=str_replace("$", "", str_replace(".", "", $datos["valorPagar"]));

		$aDatosEmpleado["dias"]=$datos["diasTrabajados"];
		
		$aDatosEmpleado["auxilioTransporte"]=str_replace("$", "", str_replace(".", "", $datos["auxilioTransporteInicial"]));

		$oItem=new Data("nomina_empleado","idNominaEmpleado"); 

		foreach ($aDatosEmpleado as $key => $value) {

		  $oItem->$key=$value; 

		}

		$oItem->guardar(); 

		$idNominaEmpleado=$oItem->ultimoId();

		unset($oItem);
		$msg=true;

}	
if ($msg== true ) {
		# code...
	

		foreach($adiciones as $itemAdicion){
			if ($itemAdicion["idProducto"]!=4) {
				$aAdicion["concepto"]=$itemAdicion["producto"]; 

				$aAdicion["idNominaEmpleado"]=$idNominaEmpleado; 

				$aAdicion["valor"]=str_replace("$", "", str_replace(".", "", $itemAdicion["valor"]));

				$oItem=new Data("nomina_empleado_adiciones","idNominaEmpleadoAdiciones"); 

				foreach ($aAdicion as $key => $value) {
				  $oItem->$key=$value; 
				}
				$oItem->guardar(); 
				unset($oItem);
			}

			if ($itemAdicion["idProducto"]==4) {
				$valorVacaciones=str_replace("$", "", str_replace(".", "", $itemAdicion["valor"]));
			}


			$iD["estado"]=2; 

			$oItem=new Data("empresa_novedad","idEmpresaNovedad",$itemAdicion["idNovedad"]); 

			foreach ($iD as $key => $value) {

			  $oItem->$key=$value; 

			}

			$oItem->guardar(); 

			unset($oItem);

		}

}


if ($msg== true ) {

foreach($ley as $itemLey){

	$aDeduccion["concepto"]=$itemLey["producto"]; 

	$aDeduccion["idNominaEmpleado"]=$idNominaEmpleado; 

	$aDeduccion["valor"]=str_replace("$", "", str_replace(".", "", $itemLey["valor"])); 

	$aDeduccion["tipoDeduccion"]=$itemLey["tipoDeduccion"]==1?2:1; 

	$aDeduccion["tipoConcepto"]=$itemLey["tipoConcepto"]; 

	$oItem=new Data("nomina_empleado_parafiscales","idNominaEmpleadoParafiscales"); 

	foreach ($aDeduccion as $key => $value) {

	  $oItem->$key=$value; 

	}

	$oItem->guardar(); 

	unset($oItem);

	}
}
if ($msg==true ) {

	$totalDeducciones=0.0;

	foreach($deducciones as $itemDeduccion){

		$iDeducir["concepto"]=$itemDeduccion["producto"]; 

		$iDeducir["idNominaEmpleado"]=$idNominaEmpleado; 

		$iDeducir["valor"]=str_replace("$", "", str_replace(".", "", $itemDeduccion["valor"]));
		$deduccion=str_replace(",", ".",$iDeducir["valor"]);
		$totalDeducciones+=floatval($deduccion);

		$oItem=new Data("nomina_empleado_deducciones","idNominaEmpleadoDeducciones"); 

		foreach ($iDeducir as $key => $value) {

		  $oItem->$key=$value; 

		}

		$oItem->guardar(); 

		unset($oItem);


		$iD["estado"]=2; 

		$oItem=new Data("empresa_novedad","idEmpresaNovedad",$itemDeduccion["idNovedad"]); 

		foreach ($iD as $key => $value) {

		  $oItem->$key=$value; 

		}

		$oItem->guardar(); 

		unset($oItem);



	}
}


if ($msg==true ) {
	$oItem=new Data("empleado_provisiones","idEmpleado",$datos["idEmpleado"]);
	$aProvisiones=$oItem->getDatos();
	unset($oItem);

	$cesantias=str_replace("$", "", str_replace(".", "", $provisiones["cesantias"]));
	$interesesCesantias=str_replace("$", "", str_replace(".", "", $provisiones["interesesCesantias"]));
	$vacaciones=str_replace("$", "", str_replace(".", "", $provisiones["vacaciones"]));
	$prima=str_replace("$", "", str_replace(".", "", $provisiones["prima"]));

	
	
	

	if (empty($aProvisiones)) {
		$provisionesE["idEmpleado"]=$datos["idEmpleado"];
		$provisionesE["cesantias"]=$cesantias;
		$provisionesE["interesesCesantias"]=$interesesCesantias;
		$provisionesE["vacaciones"]=$vacaciones;
		$provisionesE["prima"]=$prima;
		$oItem=new Data("empleado_provisiones","idEmpleadoProvisiones");

		foreach ($provisionesE as $keyE => $valueE) {

		  $oItem->$keyE=$valueE; 

		}
		$oItem->guardar(); 

		unset($oItem);
	}
	if (!empty($aProvisiones)) {


		$cesantiasActual=$aProvisiones["cesantias"];
		$interesesCesantiasActual=$aProvisiones["interesesCesantias"];
		$vacacionesActual=$aProvisiones["vacaciones"];
		$primaActual=$aProvisiones["prima"];


		$cesantiasFinal=floatval($cesantias)+floatval($cesantiasActual);
		$interesesCesantiasFinal=floatval($interesesCesantias)+floatval($interesesCesantiasActual);
		$vacacionesFinal=floatval($vacaciones)+floatval($vacacionesActual);
		$primaFinal=floatval($prima)+floatval($primaActual);


		$provisionesEF["cesantias"]=$cesantiasFinal;
		$provisionesEF["interesesCesantias"]=$interesesCesantiasFinal;
		$provisionesEF["vacaciones"]=$vacacionesFinal;
		$provisionesEF["prima"]=$primaFinal;


		$oItem=new Data("empleado_provisiones","idEmpleado",$datos["idEmpleado"]);
		foreach ($provisionesEF as $keyEF => $valueEF) {

		  $oItem->$keyEF=$valueEF; 

		}
		$oItem->guardar(); 

		unset($oItem);
	}




		$provisionesNomC["idNominaEmpleado"]=$idNominaEmpleado;
		$provisionesNomC["concepto"]='cesantias';
		$provisionesNomC["valor"]=$cesantias;
		$provisionesNomC["tipoProvision"]=1;


		$oItem=new Data("nomina_empleado_provisiones","idNominaEmpleadoProvisiones");
		foreach ($provisionesNomC as $keyNomC => $valueNomC) {

		  $oItem->$keyNomC=$valueNomC; 

		}
		$oItem->guardar(); 

		unset($oItem);


		$provisionesNomIC["idNominaEmpleado"]=$idNominaEmpleado;
		$provisionesNomIC["concepto"]='intereses cesantias';
		$provisionesNomIC["valor"]=$interesesCesantias;
		$provisionesNomIC["tipoProvision"]=2;

		$oItem=new Data("nomina_empleado_provisiones","idNominaEmpleadoProvisiones");
		foreach ($provisionesNomIC as $keyNomIC => $valueNomIC) {

		  $oItem->$keyNomIC=$valueNomIC; 

		}
		$oItem->guardar(); 

		unset($oItem);


		$provisionesNomV["idNominaEmpleado"]=$idNominaEmpleado;
		$provisionesNomV["concepto"]='vacaciones';
		$provisionesNomV["valor"]=$vacaciones;
		$provisionesNomV["tipoProvision"]=3;

		$oItem=new Data("nomina_empleado_provisiones","idNominaEmpleadoProvisiones");
		foreach ($provisionesNomV as $keyNomV => $valueNomV) {

		  $oItem->$keyNomV=$valueNomV; 

		}
		$oItem->guardar(); 

		unset($oItem);



		$provisionesNom["idNominaEmpleado"]=$idNominaEmpleado;
		$provisionesNom["concepto"]='prima';
		$provisionesNom["valor"]=$prima;
		$provisionesNom["tipoProvision"]=4;

		$oItem=new Data("nomina_empleado_provisiones","idNominaEmpleadoProvisiones");
		foreach ($provisionesNom as $keyNom => $valueNom) {

		  $oItem->$keyNom=$valueNom; 

		}
		$oItem->guardar(); 

		unset($oItem);
	

}



$comp=true;

	    $oLista=new Lista("nomina_cuenta_contable");
	    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);	    
	    $aCC=$oLista->getLista();
	    unset($oLista);

$comprobanteEmpleado=0;
$comprobanteEmpleador=0;
$comprobanteProvisiones=0;


if (!empty($aCC)) {

	$oLista=new Lista("nomina_comprobante");
    $oLista->setFiltro("idNomina","=",$idNomina);
    $oLista->setFiltro("tipo","=",'1');
    $aNominaComprobante=$oLista->getLista();
    unset($oLista);



	    $fechaComprobante=$periodo[1].'-'.$periodo[0].'-30';

	if (empty($aNominaComprobante)) {
		
		$oLista=new Lista("parametros_documentos");
	    $oLista->setFiltro("idParametrosDocumentos","=",$datos['tipoDocumento']);
	    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
	    $aNumero=$oLista->getLista();
	    unset($oLista);

	    $numeroComprobanteAntiguo=intval($aNumero[0]["numeracionActual"]);

	    $numeroComprobante=intval($datos["numeroComprobante"]);

	    $oItem=new Data("tipos_documento_contable","idTiposDocumento",$aNumero[0]["tipo"]);
    	$letraTipo=$oItem->getDatos();
    	unset($oItem);	

		$comprobanteEmpleado=$letraTipo["letra"].'-'.$aNumero[0]["comprobante"].'-'.$numeroComprobante;

	        $aDatos["idTipo"]=$aNumero[0]["tipo"]; 
	        $aDatos["comprobante"]=$aNumero[0]["comprobante"]; 
	        $aDatos["fecha"]=$fechaComprobante; 
	        $aDatos["fechaRegistro"]=date('Y-m-d'); 
	        $aDatos["usuarioRegistra"]=$_SESSION["idUsuario"]; 
	        $aDatos["archivo"]=$sFoto; 
	        $aDatos["observaciones"]='Nómina '.$datos["periodo"]; 
	        $aDatos["idEmpresa"]=$datos["idEmpresa"]; 
	        $aDatos["numero"]=$numeroComprobante; 
	        $aDatos["estado"]=NULL; 
	        
	        $oItem=new Data("comprobante","idComprobante"); 
	        foreach($aDatos  as $key => $value){
	            $oItem->$key=$value; 
	        }
	        $oItem->guardar(); 
	        $idComprobante=$oItem->ultimoId(); 
	        unset($oItem);

	        $nCom["numeracionActual"]=$numeroComprobante+1;
	        $oItem=new Data("parametros_documentos","idParametrosDocumentos",$aNumero[0]["idParametrosDocumentos"]); 
	        foreach($nCom  as $keyC => $valueC){
	            $oItem->$keyC=$valueC; 
	        }

	        $oItem->guardar(); 
	        unset($oItem);

	}
	if (!empty($aNominaComprobante)) {

		$oLista=new Lista("parametros_documentos");
	    $oLista->setFiltro("idParametrosDocumentos","=",$datos['tipoDocumento']);
	    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
	    $aNumero=$oLista->getLista();
	    unset($oLista);

	    $numeroComprobanteAntiguo=intval($aNumero[0]["numeracionActual"]);

		
		$idComprobante=$aNominaComprobante[0]["idComprobante"];


		$oItem=new Data("comprobante","idComprobante",$idComprobante);
    	$comprobante=$oItem->getDatos();
    	unset($oItem); 

			

		$oItem=new Data("tipos_documento_contable","idTiposDocumento",$comprobante["idTipo"]);
    	$letraTipo=$oItem->getDatos();
    	unset($oItem); 

		$comprobanteEmpleado=$letraTipo["letra"].'-'.$comprobante["comprobante"].'-'.$comprobante["numero"];
		

	}
    

      
            $oLista=new Lista("nomina_cuenta_contable");
            $oLista->setFiltro("idConcepto","=",1);
            $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
            $aSueldoCuenta=$oLista->getLista();

            if (empty($aSueldoCuenta)) {
                $comp=false;
            }
            if ($comp==true) {

            	$oItem=new Data("empleado","idEmpleado",$datos["idEmpleado"]);
                $aEmpleadoC=$oItem->getDatos();
                unset($oItem);

            	
                
                $oItem=new Data("tercero","nit",$aEmpleadoC["numeroDocumento"]);
                $aTercero=$oItem->getDatos();
                unset($oItem);
                
                $aItem["idComprobante"]=$idComprobante; 
                $aItem["idCuentaContable"]=$aSueldoCuenta[0]["idEmpresaCuenta"];
                $aItem["idCentroCosto"]=" ";
                $aItem["idSubcentroCosto"]=" ";
                $aItem["idTercero"]=$aTercero["idTercero"];
                $aItem["descripcion"]='Nómina mes '.$aDatos["periodoMes"];
                $aItem["naturaleza"]='debito';
                $aItem["tipoTercero"]='e';
                $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
                $aItem["fecha"]=$fechaComprobante; 

                if ($datos["diasTrabajados"]==30) {

                	$aItem["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$datos["salario"])));
                }

                if ($datos["diasTrabajados"]!=30) {

                	$saldoSalario=((floatval(str_replace(",", ".",str_replace("$", "", str_replace(".", "",$datos["salario"])))))/30)*$datos["diasTrabajados"];

                	$aItem["saldoDebito"]=$saldoSalario;
                }
                

                $aItem["saldoCredito"]=0;
                $aItem["base"]=0;
            
                $oItem=new Data("comprobante_items","idComprobanteItem"); 
                foreach($aItem  as $keycc => $valuecc){
                    $oItem->$keycc=$valuecc; 
                }
                $oItem->guardar(); 
                unset($oItem);
            }

      
            $oLista=new Lista("nomina_cuenta_contable");
            $oLista->setFiltro("idConcepto","=",2);
            $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
            $aAuxilioCuenta=$oLista->getLista();

            if (empty($aAuxilioCuenta)) {
                $comp=false;
            }
            if ($comp==true) {

            	
                
                $aItem["idComprobante"]=$idComprobante; 
                $aItem["idCuentaContable"]=$aAuxilioCuenta[0]["idEmpresaCuenta"];
                $aItem["idCentroCosto"]=" ";
                $aItem["idSubcentroCosto"]=" ";
                $aItem["idTercero"]=$aTercero["idTercero"];
                $aItem["descripcion"]='Nómina mes '.$aDatos["periodoMes"];
                $aItem["naturaleza"]='debito';
                $aItem["tipoTercero"]='e';
                $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
                $aItem["fecha"]=$fechaComprobante; 
                $aItem["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$datos["auxilioTransporte"])));
                $aItem["saldoCredito"]=0;
                $aItem["base"]=0;
            
                $oItem=new Data("comprobante_items","idComprobanteItem"); 
                foreach($aItem  as $keycc => $valuecc){
                    $oItem->$keycc=$valuecc; 
                }
                $oItem->guardar(); 
                unset($oItem);
            }



            $oLista=new Lista("nomina_cuenta_contable");
            $oLista->setFiltro("idConcepto","=",3);
            $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
            $aEPSCuenta=$oLista->getLista();

            if (empty($aEPSCuenta)) {
                $comp=false;
            }

            if ($comp==true) {

                
                $aItem["idComprobante"]=$idComprobante; 
                $aItem["idCuentaContable"]=$aEPSCuenta[0]["idEmpresaCuenta"];
                $aItem["idCentroCosto"]=" ";
                $aItem["idSubcentroCosto"]=" ";
                $aItem["idTercero"]=$ley[0]["tercero"];
                $aItem["descripcion"]='DCTOS SALUD ';
                $aItem["naturaleza"]='credito';
                $aItem["tipoTercero"]='e';
                $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
                $aItem["fecha"]=$fechaComprobante; 
                $aItem["saldoDebito"]=0;
                $aItem["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$ley[0]["valor"])));
                $aItem["base"]=0;
            
                $oItem=new Data("comprobante_items","idComprobanteItem"); 
                foreach($aItem  as $keycc => $valuecc){
                    $oItem->$keycc=$valuecc; 
                }
                $oItem->guardar(); 
                unset($oItem);
            }


            $oLista=new Lista("nomina_cuenta_contable");
            $oLista->setFiltro("idConcepto","=",4);
            $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
            $aPensionCuenta=$oLista->getLista();

            if (empty($aPensionCuenta)) {
                $comp=false;
            }

            if ($comp==true) {

            	$oItem=new Data("tercero","nit",$aEmpleadoC["numeroDocumento"]);
                $aTercero=$oItem->getDatos();
                unset($oItem);
                
                $aItem["idComprobante"]=$idComprobante; 
                $aItem["idCuentaContable"]=$aPensionCuenta[0]["idEmpresaCuenta"];
                $aItem["idCentroCosto"]=" ";
                $aItem["idSubcentroCosto"]=" ";
                $aItem["idTercero"]=$ley[1]["tercero"];
                $aItem["descripcion"]='DCTOS PENSIÓN ';
                $aItem["naturaleza"]='credito';
                $aItem["tipoTercero"]='e';
                $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
                $aItem["fecha"]=$fechaComprobante; 
                $aItem["saldoDebito"]=0;
                $aItem["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$ley[1]["valor"])));
                $aItem["base"]=0;
            
                $oItem=new Data("comprobante_items","idComprobanteItem"); 
                foreach($aItem  as $keycc => $valuecc){
                    $oItem->$keycc=$valuecc; 
                }
                $oItem->guardar(); 
                unset($oItem);
            }

            $oLista=new Lista("nomina_cuenta_contable");
            $oLista->setFiltro("idConcepto","=",5);
            $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
            $aSalarioPagarCuenta=$oLista->getLista();

            if (empty($aSalarioPagarCuenta)) {
                $comp=false;
            }

            if ($comp==true) {
                
                $aItem["idComprobante"]=$idComprobante; 
                $aItem["idCuentaContable"]=$aSalarioPagarCuenta[0]["idEmpresaCuenta"];
                $aItem["idCentroCosto"]=" ";
                $aItem["idSubcentroCosto"]=" ";
                $aItem["idTercero"]=$aTercero["idTercero"];
                $aItem["descripcion"]='SALARIOS POR PAGAR ';
                $aItem["naturaleza"]='credito';
                $aItem["tipoTercero"]='e';
                $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
                $aItem["fecha"]=$fechaComprobante; 
                $aItem["saldoDebito"]=0;
                if ($totalDeducciones!=0.0) {
                	$valorPagar=$totalDeducciones+floatval(str_replace(",", ".",str_replace("$", "", str_replace(".", "",$datos["valorPagar"]))));
                }
                if ($totalDeducciones==0.0) {
                	$valorPagar=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$datos["valorPagar"])));
                }
                $aItem["saldoCredito"]=$valorPagar;
                $aItem["base"]=0;
            
                $oItem=new Data("comprobante_items","idComprobanteItem"); 
                foreach($aItem  as $keycc => $valuecc){
                    $oItem->$keycc=$valuecc; 
                }
                $oItem->guardar(); 
                unset($oItem);
            }



            foreach($adiciones as $itemAdicion){

				if ($itemAdicion["cuentaContable"]!='no aplica') {
					// code...
					$aItem["idComprobante"]=$idComprobante; 
	                $aItem["idCuentaContable"]=$itemAdicion["cuentaContable"];
	                $aItem["idCentroCosto"]=" ";
	                $aItem["idSubcentroCosto"]=" ";
	                $aItem["idTercero"]=$aTercero["idTercero"];
	                $aItem["descripcion"]=$itemAdicion["producto"];
	                $aItem["naturaleza"]='debito';
	                $aItem["tipoTercero"]='e';
	                $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
	                $aItem["fecha"]=$fechaComprobante; 
	                $aItem["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$itemAdicion["valor"])));
	                $aItem["saldoCredito"]=0;
	                $aItem["base"]=0;
	            
	                $oItem=new Data("comprobante_items","idComprobanteItem"); 
	                foreach($aItem  as $keycc => $valuecc){
	                    $oItem->$keycc=$valuecc; 
	                }
	                $oItem->guardar(); 
	                unset($oItem);
				}
				
			}


        	// ----------------------------------------------------------------------------------


		$oLista=new Lista("nomina_comprobante");
	    $oLista->setFiltro("idNomina","=",$idNomina);
	    $oLista->setFiltro("tipo","=",'2');
	    $aNominaComprobanteE=$oLista->getLista();
	    unset($oLista);

	    // $fechaComprobante=$aDatos["periodoAnio"].'-'.$aDatos["periodoMes"].'-30';

	    // $oItem=new Data("tipos_documento_contable","idTiposDocumento",$aNumero[0]["tipo"]);
    	// $letraTipo=$oItem->getDatos();
    	// unset($oItem);


	if (empty($aNominaComprobanteE)) {
		
		$numeroComprobante+=1;
		
		$comprobanteEmpleador=$letraTipo["letra"].'-'.$aNumero[0]["comprobante"].'-'.$numeroComprobante;

	        $aDatos["idTipo"]=$aNumero[0]["tipo"]; 
	        $aDatos["comprobante"]=$aNumero[0]["comprobante"]; 
	        $aDatos["fecha"]=$fechaComprobante; 
	        $aDatos["fechaRegistro"]=date('Y-m-d'); 
	        $aDatos["usuarioRegistra"]=$_SESSION["idUsuario"]; 
	        $aDatos["archivo"]=$sFoto; 
	        $aDatos["observaciones"]='Nómina '.$datos["periodo"]; 
	        $aDatos["idEmpresa"]=$datos["idEmpresa"]; 
	        $aDatos["numero"]=$numeroComprobante; 
	        $aDatos["estado"]=NULL; 
	        
	        $oItem=new Data("comprobante","idComprobante"); 
	        foreach($aDatos  as $key => $value){
	            $oItem->$key=$value; 
	        }
	        $oItem->guardar(); 
	        $idComprobanteE=$oItem->ultimoId(); 
	        unset($oItem);

	        $nCom["numeracionActual"]=$numeroComprobante+1;
	        $oItem=new Data("parametros_documentos","idParametrosDocumentos",$aNumero[0]["idParametrosDocumentos"]); 
	        foreach($nCom  as $keyC => $valueC){
	            $oItem->$keyC=$valueC; 
	        }
	        $oItem->guardar(); 
	        unset($oItem);
	}
	if (!empty($aNominaComprobanteE)) {
		$idComprobanteE=$aNominaComprobanteE[0]["idComprobante"];


		$oItem=new Data("comprobante","idComprobante",$idComprobanteE);
    	$comprobanteE=$oItem->getDatos();
    	unset($oItem); 

			

		$oItem=new Data("tipos_documento_contable","idTiposDocumento",$comprobanteE["idTipo"]);
    	$letraTipo=$oItem->getDatos();
    	unset($oItem); 

		$comprobanteEmpleador=$letraTipo["letra"].'-'.$comprobanteE["comprobante"].'-'.$comprobanteE["numero"];


	}



    $oLista=new Lista("nomina_cuenta_contable");
    $oLista->setFiltro("idConcepto","=",6);
    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
    $ARLCuenta=$oLista->getLista();

    if (empty($ARLCuenta)) {
        $comp=false;
    }

    if ($comp==true) {
    	if (count($ARLCuenta)<2) {
    		$comp=false;
    	}
        if (count($ARLCuenta)==2) {
        	
        $aItem["idComprobante"]=$idComprobanteE; 
        $aItem["idCuentaContable"]=$ARLCuenta[0]["idEmpresaCuenta"];
        $aItem["idCentroCosto"]=" ";
        $aItem["idSubcentroCosto"]=" ";
        $aItem["idTercero"]=$ley[2]["tercero"];
        $aItem["descripcion"]='ARL';
        $aItem["tipoTercero"]='e';
        $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aItem["fecha"]=$fechaComprobante; 
        $aItem["base"]=0;


        $oLista=new Data("cuenta_contable","idCuentaContable",$ARLCuenta[0]["idEmpresaCuenta"]);
        $aCuentaARL=$oLista->getDatos();  
        unset($oLista);

        $aItem["naturaleza"]=$aCuentaARL["naturaleza"];

		if ($aCuentaARL["naturaleza"]=='debito') {
	        $aItem["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$ley[2]["valor"])));
	        $aItem["saldoCredito"]=0;
	    }
	    if ($aCuentaARL["naturaleza"]=='credito') {
	        $aItem["saldoDebito"]=0;
	        $aItem["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$ley[2]["valor"])));
	    }
    
        $oItem=new Data("comprobante_items","idComprobanteItem"); 
        foreach($aItem  as $keycc => $valuecc){
            $oItem->$keycc=$valuecc; 
        }
        $oItem->guardar(); 
        unset($oItem);



        $aItem["idComprobante"]=$idComprobanteE; 
        $aItem["idCuentaContable"]=$ARLCuenta[1]["idEmpresaCuenta"];
        $aItem["idCentroCosto"]=" ";
        $aItem["idSubcentroCosto"]=" ";
        $aItem["idTercero"]=$ley[2]["tercero"];
        $aItem["descripcion"]='ARL';
        $aItem["tipoTercero"]='e';
        $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aItem["fecha"]=$fechaComprobante; 
        $aItem["base"]=0;


        $oLista=new Data("cuenta_contable","idCuentaContable",$ARLCuenta[1]["idEmpresaCuenta"]);
        $aCuentaARL=$oLista->getDatos();  
        unset($oLista);

        $aItem["naturaleza"]=$aCuentaARL["naturaleza"];

		if ($aCuentaARL["naturaleza"]=='debito') {
	        $aItem["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$ley[2]["valor"])));
	        $aItem["saldoCredito"]=0;
	    }
	    if ($aCuentaARL["naturaleza"]=='credito') {
	        $aItem["saldoDebito"]=0;
	        $aItem["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$ley[2]["valor"])));
	    }
    
        $oItem=new Data("comprobante_items","idComprobanteItem"); 
        foreach($aItem  as $keycc => $valuecc){
            $oItem->$keycc=$valuecc; 
        }
        $oItem->guardar(); 
        unset($oItem);
        }
    }




    $oLista=new Lista("nomina_cuenta_contable");
    $oLista->setFiltro("idConcepto","=",7);
    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
    $cajaCuenta=$oLista->getLista();

    if (empty($cajaCuenta)) {
        $comp=false;
    }

    if ($comp==true) {
    	if (count($cajaCuenta)<2) {
    		$comp=false;
    	}
        if (count($cajaCuenta)==2) {
        	
        $aItem["idComprobante"]=$idComprobanteE; 
        $aItem["idCuentaContable"]=$cajaCuenta[0]["idEmpresaCuenta"];
        $aItem["idCentroCosto"]=" ";
        $aItem["idSubcentroCosto"]=" ";
        $aItem["idTercero"]=$ley[3]["tercero"];
        $aItem["descripcion"]='CAJA COMPENSACION';
        $aItem["tipoTercero"]='p';
        $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aItem["fecha"]=$fechaComprobante; 
        $aItem["base"]=0;


        $oLista=new Data("cuenta_contable","idCuentaContable",$cajaCuenta[0]["idEmpresaCuenta"]);
        $aCuentaCaja=$oLista->getDatos();  
        unset($oLista);

        $aItem["naturaleza"]=$aCuentaCaja["naturaleza"];

		if ($aCuentaCaja["naturaleza"]=='debito') {
	        $aItem["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$ley[3]["valor"])));
	        $aItem["saldoCredito"]=0;
	    }
	    if ($aCuentaCaja["naturaleza"]=='credito') {
	        $aItem["saldoDebito"]=0;
	        $aItem["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$ley[3]["valor"])));
	    }
    
        $oItem=new Data("comprobante_items","idComprobanteItem"); 
        foreach($aItem  as $keycc => $valuecc){
            $oItem->$keycc=$valuecc; 
        }
        $oItem->guardar(); 
        unset($oItem);



        $aItem["idComprobante"]=$idComprobanteE; 
        $aItem["idCuentaContable"]=$cajaCuenta[1]["idEmpresaCuenta"];
        $aItem["idCentroCosto"]=" ";
        $aItem["idSubcentroCosto"]=" ";
        $aItem["idTercero"]=$ley[3]["tercero"];
        $aItem["descripcion"]='CAJA COMPENSACION';
        $aItem["tipoTercero"]='p';
        $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aItem["fecha"]=$fechaComprobante; 
        $aItem["base"]=0;


        $oLista=new Data("cuenta_contable","idCuentaContable",$cajaCuenta[1]["idEmpresaCuenta"]);
        $aCuentaCaja=$oLista->getDatos();  
        unset($oLista);

        $aItem["naturaleza"]=$aCuentaCaja["naturaleza"];

		if ($aCuentaCaja["naturaleza"]=='debito') {
	        $aItem["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$ley[3]["valor"])));
	        $aItem["saldoCredito"]=0;
	    }
	    if ($aCuentaCaja["naturaleza"]=='credito') {
	        $aItem["saldoDebito"]=0;
	        $aItem["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$ley[3]["valor"])));
	    }
    
        $oItem=new Data("comprobante_items","idComprobanteItem"); 
        foreach($aItem  as $keycc => $valuecc){
            $oItem->$keycc=$valuecc; 
        }
        $oItem->guardar(); 
        unset($oItem);
        }
    }


    $oLista=new Lista("nomina_cuenta_contable");
    $oLista->setFiltro("idConcepto","=",8);
    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
    $pensionCuentaE=$oLista->getLista();

    if (empty($pensionCuentaE)) {
        $comp=false;
    }

    if ($comp==true) {
    	if (count($pensionCuentaE)<2) {
    		$comp=false;
    	}
        if (count($pensionCuentaE)==2) {
        	
        $aItem["idComprobante"]=$idComprobanteE; 
        $aItem["idCuentaContable"]=$pensionCuentaE[0]["idEmpresaCuenta"];
        $aItem["idCentroCosto"]=" ";
        $aItem["idSubcentroCosto"]=" ";
        $aItem["idTercero"]=$ley[5]["tercero"];
        $aItem["descripcion"]='APORTES A FONDO DE PENSIONES';
        $aItem["tipoTercero"]='p';
        $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aItem["fecha"]=$fechaComprobante; 
        $aItem["base"]=0;


        $oLista=new Data("cuenta_contable","idCuentaContable",$pensionCuentaE[0]["idEmpresaCuenta"]);
        $aCuentaPensionE=$oLista->getDatos();  
        unset($oLista);

        $aItem["naturaleza"]=$aCuentaPensionE["naturaleza"];

		if ($aCuentaPensionE["naturaleza"]=='debito') {
	        $aItem["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$ley[5]["valor"])));
	        $aItem["saldoCredito"]=0;
	    }
	    if ($aCuentaPensionE["naturaleza"]=='credito') {
	        $aItem["saldoDebito"]=0;
	        $aItem["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$ley[5]["valor"])));
	    }
    
        $oItem=new Data("comprobante_items","idComprobanteItem"); 
        foreach($aItem  as $keycc => $valuecc){
            $oItem->$keycc=$valuecc; 
        }
        $oItem->guardar(); 
        unset($oItem);



        $aItem["idComprobante"]=$idComprobanteE; 
        $aItem["idCuentaContable"]=$pensionCuentaE[1]["idEmpresaCuenta"];
        $aItem["idCentroCosto"]=" ";
        $aItem["idSubcentroCosto"]=" ";
        $aItem["idTercero"]=$ley[5]["tercero"];
        $aItem["descripcion"]='APORTES A FONDO DE PENSIONES';
        $aItem["tipoTercero"]='p';
        $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aItem["fecha"]=$fechaComprobante; 
        $aItem["base"]=0;


        $oLista=new Data("cuenta_contable","idCuentaContable",$pensionCuentaE[1]["idEmpresaCuenta"]);
        $aCuentaPensionE=$oLista->getDatos();  
        unset($oLista);

        $aItem["naturaleza"]=$aCuentaPensionE["naturaleza"];

		if ($aCuentaPensionE["naturaleza"]=='debito') {
	        $aItem["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$ley[5]["valor"])));
	        $aItem["saldoCredito"]=0;
	    }
	    if ($aCuentaPensionE["naturaleza"]=='credito') {
	        $aItem["saldoDebito"]=0;
	        $aItem["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$ley[5]["valor"])));
	    }
    
        $oItem=new Data("comprobante_items","idComprobanteItem"); 
        foreach($aItem  as $keycc => $valuecc){
            $oItem->$keycc=$valuecc; 
        }
        $oItem->guardar(); 
        unset($oItem);
        }
    }

 			//Comprobante provisiones   
    // ------------------------------------------------------------------------------------------------------------------
    	// se crea el comprobante

    	$oLista=new Lista("nomina_comprobante");
	    $oLista->setFiltro("idNomina","=",$idNomina);
	    $oLista->setFiltro("tipo","=",'3');
	    $aNominaComprobanteP=$oLista->getLista();
	    unset($oLista);

	    // $fechaComprobante=$aDatos["periodoAnio"].'-'.$aDatos["periodoMes"].'-30';

	if (empty($aNominaComprobanteP)) {
		
		$numeroComprobante+=1;


		$comprobanteProvisiones=$letraTipo["letra"].'-'.$aNumero[0]["comprobante"].'-'.$numeroComprobante;

	        $aDatos["idTipo"]=$aNumero[0]["tipo"]; 
	        $aDatos["comprobante"]=$aNumero[0]["comprobante"]; 
	        $aDatos["fecha"]=$fechaComprobante; 
	        $aDatos["fechaRegistro"]=date('Y-m-d'); 
	        $aDatos["usuarioRegistra"]=$_SESSION["idUsuario"]; 
	        $aDatos["archivo"]=$sFoto; 
	        $aDatos["observaciones"]='Nómina '.$datos["periodo"]; 
	        $aDatos["idEmpresa"]=$datos["idEmpresa"]; 
	        $aDatos["numero"]=$numeroComprobante; 
	        $aDatos["estado"]=NULL; 
	        
	        $oItem=new Data("comprobante","idComprobante"); 
	        foreach($aDatos  as $key => $value){
	            $oItem->$key=$value; 
	        }
	        $oItem->guardar(); 
	        $idComprobanteP=$oItem->ultimoId(); 
	        unset($oItem);

	        $nCom["numeracionActual"]=$numeroComprobante+1;
	        $oItem=new Data("parametros_documentos","idParametrosDocumentos",$aNumero[0]["idParametrosDocumentos"]); 
	        foreach($nCom  as $keyC => $valueC){
	            $oItem->$keyC=$valueC; 
	        }
	        $oItem->guardar(); 
	        unset($oItem);
	}
	if (!empty($aNominaComprobanteP)) {
		$idComprobanteP=$aNominaComprobanteP[0]["idComprobante"];




		$oItem=new Data("comprobante","idComprobante",$idComprobanteP);
    	$comprobanteE=$oItem->getDatos();
    	unset($oItem); 

			

		$oItem=new Data("tipos_documento_contable","idTiposDocumento",$comprobanteE["idTipo"]);
    	$letraTipo=$oItem->getDatos();
    	unset($oItem); 

		$comprobanteProvisiones=$letraTipo["letra"].'-'.$comprobanteE["comprobante"].'-'.$comprobanteE["numero"];
	}




    // ------------------------------------------------------------------------------------------------------------------
			// Se agregan los items al comprobante

    $oLista=new Lista("nomina_cuenta_contable");
    $oLista->setFiltro("idConcepto","=",10);
    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
    $cesantiasCuenta=$oLista->getLista();

    if (empty($cesantiasCuenta)) {
        $comp=false;
    }

    if ($comp==true) {
    	if (count($cesantiasCuenta)<2) {
    		$comp=false;
    	}
        if (count($cesantiasCuenta)==2) {
        	
        $aItem["idComprobante"]=$idComprobanteP; 
        $aItem["idCuentaContable"]=$cesantiasCuenta[0]["idEmpresaCuenta"];
        $aItem["idCentroCosto"]=" ";
        $aItem["idSubcentroCosto"]=" ";
        $aItem["idTercero"]=$aTercero["idTercero"];
        $aItem["descripcion"]='CESANTIAS';
        $aItem["tipoTercero"]='p';
        $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aItem["fecha"]=$fechaComprobante; 
        $aItem["base"]=0;


        $oLista=new Data("cuenta_contable","idCuentaContable",$cesantiasCuenta[0]["idEmpresaCuenta"]);
        $aCuentaCesantias=$oLista->getDatos();  
        unset($oLista);

        $aItem["naturaleza"]=$aCuentaCesantias["naturaleza"];

		if ($aCuentaCesantias["naturaleza"]=='debito') {
	        $aItem["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$provisiones["cesantias"])));
	        $aItem["saldoCredito"]=0;
	    }
	    if ($aCuentaCesantias["naturaleza"]=='credito') {
	        $aItem["saldoDebito"]=0;
	        $aItem["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$provisiones["cesantias"])));
	    }
    
        $oItem=new Data("comprobante_items","idComprobanteItem"); 
        foreach($aItem  as $keycc => $valuecc){
            $oItem->$keycc=$valuecc; 
        }
        $oItem->guardar(); 
        unset($oItem);



        $aItem["idComprobante"]=$idComprobanteP; 
        $aItem["idCuentaContable"]=$cesantiasCuenta[1]["idEmpresaCuenta"];
        $aItem["idCentroCosto"]=" ";
        $aItem["idSubcentroCosto"]=" ";
        $aItem["idTercero"]=$aTercero["idTercero"];
        $aItem["descripcion"]='CESANTIAS';
        $aItem["tipoTercero"]='p';
        $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aItem["fecha"]=$fechaComprobante; 
        $aItem["base"]=0;


        $oLista=new Data("cuenta_contable","idCuentaContable",$cesantiasCuenta[1]["idEmpresaCuenta"]);
        $aCuentaCesantias=$oLista->getDatos();  
        unset($oLista);

        $aItem["naturaleza"]=$aCuentaCesantias["naturaleza"];

		if ($aCuentaCesantias["naturaleza"]=='debito') {
	        $aItem["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$provisiones["cesantias"])));
	        $aItem["saldoCredito"]=0;
	    }
	    if ($aCuentaCesantias["naturaleza"]=='credito') {
	        $aItem["saldoDebito"]=0;
	        $aItem["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$provisiones["cesantias"])));
	    }
    
        $oItem=new Data("comprobante_items","idComprobanteItem"); 
        foreach($aItem  as $keycc => $valuecc){
            $oItem->$keycc=$valuecc; 
        }
        $oItem->guardar(); 
        unset($oItem);
        }
    }





    $oLista=new Lista("nomina_cuenta_contable");
    $oLista->setFiltro("idConcepto","=",11);
    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
    $interesesCesantias=$oLista->getLista();

    if (empty($interesesCesantias)) {
        $comp=false;
    }

    if ($comp==true) {
    	if (count($interesesCesantias)<2) {
    		$comp=false;
    	}
        if (count($interesesCesantias)==2) {
        	
        $aItem["idComprobante"]=$idComprobanteP; 
        $aItem["idCuentaContable"]=$interesesCesantias[0]["idEmpresaCuenta"];
        $aItem["idCentroCosto"]=" ";
        $aItem["idSubcentroCosto"]=" ";
        $aItem["idTercero"]=$aTercero["idTercero"];
        $aItem["descripcion"]='CESANTIAS';
        $aItem["tipoTercero"]='p';
        $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aItem["fecha"]=$fechaComprobante; 
        $aItem["base"]=0;


        $oLista=new Data("cuenta_contable","idCuentaContable",$interesesCesantias[0]["idEmpresaCuenta"]);
        $aCuentaInteresesCesantias=$oLista->getDatos();  
        unset($oLista);

        $aItem["naturaleza"]=$aCuentaInteresesCesantias["naturaleza"];

		if ($aCuentaInteresesCesantias["naturaleza"]=='debito') {
	        $aItem["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$provisiones["interesesCesantias"])));
	        $aItem["saldoCredito"]=0;
	    }
	    if ($aCuentaInteresesCesantias["naturaleza"]=='credito') {
	        $aItem["saldoDebito"]=0;
	        $aItem["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$provisiones["interesesCesantias"])));
	    }
    
        $oItem=new Data("comprobante_items","idComprobanteItem"); 
        foreach($aItem  as $keycc => $valuecc){
            $oItem->$keycc=$valuecc; 
        }
        $oItem->guardar(); 
        unset($oItem);



        $aItem["idComprobante"]=$idComprobanteP; 
        $aItem["idCuentaContable"]=$interesesCesantias[1]["idEmpresaCuenta"];
        $aItem["idCentroCosto"]=" ";
        $aItem["idSubcentroCosto"]=" ";
        $aItem["idTercero"]=$aTercero["idTercero"];
        $aItem["descripcion"]='CESANTIAS';
        $aItem["tipoTercero"]='p';
        $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aItem["fecha"]=$fechaComprobante; 
        $aItem["base"]=0;


        $oLista=new Data("cuenta_contable","idCuentaContable",$interesesCesantias[1]["idEmpresaCuenta"]);
        $aCuentaInteresesCesantias=$oLista->getDatos();  
        unset($oLista);

        $aItem["naturaleza"]=$aCuentaInteresesCesantias["naturaleza"];

		if ($aCuentaInteresesCesantias["naturaleza"]=='debito') {
	        $aItem["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$provisiones["interesesCesantias"])));
	        $aItem["saldoCredito"]=0;
	    }
	    if ($aCuentaInteresesCesantias["naturaleza"]=='credito') {
	        $aItem["saldoDebito"]=0;
	        $aItem["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$provisiones["interesesCesantias"])));
	    }
    
        $oItem=new Data("comprobante_items","idComprobanteItem"); 
        foreach($aItem  as $keycc => $valuecc){
            $oItem->$keycc=$valuecc; 
        }
        $oItem->guardar(); 
        unset($oItem);
        }
    }


   	// ------------------------------------------------------------------------------------------------------------------
    $oLista=new Lista("nomina_cuenta_contable");
    $oLista->setFiltro("idConcepto","=",12);
    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
    $prima=$oLista->getLista();

    if (empty($prima)) {
        $comp=false;
    }

    if ($comp==true) {
    	if (count($prima)<2) {
    		$comp=false;
    	}
        if (count($prima)==2) {
        	
        $aItem["idComprobante"]=$idComprobanteP; 
        $aItem["idCuentaContable"]=$prima[0]["idEmpresaCuenta"];
        $aItem["idCentroCosto"]=" ";
        $aItem["idSubcentroCosto"]=" ";
        $aItem["idTercero"]=$aTercero["idTercero"];
        $aItem["descripcion"]='PRIMA';
        $aItem["tipoTercero"]='p';
        $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aItem["fecha"]=$fechaComprobante; 
        $aItem["base"]=0;


        $oLista=new Data("cuenta_contable","idCuentaContable",$prima[0]["idEmpresaCuenta"]);
        $aCuentaPrima=$oLista->getDatos();  
        unset($oLista);

        $aItem["naturaleza"]=$aCuentaPrima["naturaleza"];

		if ($aCuentaPrima["naturaleza"]=='debito') {
	        $aItem["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$provisiones["prima"])));
	        $aItem["saldoCredito"]=0;
	    }
	    if ($aCuentaPrima["naturaleza"]=='credito') {
	        $aItem["saldoDebito"]=0;
	        $aItem["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$provisiones["prima"])));
	    }
    
        $oItem=new Data("comprobante_items","idComprobanteItem"); 
        foreach($aItem  as $keycc => $valuecc){
            $oItem->$keycc=$valuecc; 
        }
        $oItem->guardar(); 
        unset($oItem);



        $aItem["idComprobante"]=$idComprobanteP; 
        $aItem["idCuentaContable"]=$prima[1]["idEmpresaCuenta"];
        $aItem["idCentroCosto"]=" ";
        $aItem["idSubcentroCosto"]=" ";
        $aItem["idTercero"]=$aTercero["idTercero"];
        $aItem["descripcion"]='PRIMA';
        $aItem["tipoTercero"]='p';
        $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aItem["fecha"]=$fechaComprobante; 
        $aItem["base"]=0;


        $oLista=new Data("cuenta_contable","idCuentaContable",$prima[1]["idEmpresaCuenta"]);
        $aCuentaPrima=$oLista->getDatos();  
        unset($oLista);

        $aItem["naturaleza"]=$aCuentaPrima["naturaleza"];

		if ($aCuentaPrima["naturaleza"]=='debito') {
	        $aItem["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$provisiones["prima"])));
	        $aItem["saldoCredito"]=0;
	    }
	    if ($aCuentaPrima["naturaleza"]=='credito') {
	        $aItem["saldoDebito"]=0;
	        $aItem["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$provisiones["prima"])));
	    }
    
        $oItem=new Data("comprobante_items","idComprobanteItem"); 
        foreach($aItem  as $keycc => $valuecc){
            $oItem->$keycc=$valuecc; 
        }
        $oItem->guardar(); 
        unset($oItem);
        }
    }
    // ------------------------------------------------------------------------------------------------------------------

    // ------------------------------------------------------------------------------------------------------------------
    $oLista=new Lista("nomina_cuenta_contable");
    $oLista->setFiltro("idConcepto","=",13);
    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
    $vacaciones=$oLista->getLista();

    if (empty($vacaciones)) {
        $comp=false;
    }

    if ($comp==true) {
    	if (count($vacaciones)<2) {
    		$comp=false;
    	}
        if (count($vacaciones)==2) {
        	
        $aItem["idComprobante"]=$idComprobanteP; 
        $aItem["idCuentaContable"]=$vacaciones[0]["idEmpresaCuenta"];
        $aItem["idCentroCosto"]=" ";
        $aItem["idSubcentroCosto"]=" ";
        $aItem["idTercero"]=$aTercero["idTercero"];
        $aItem["descripcion"]='VACACIONES';
        $aItem["tipoTercero"]='p';
        $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aItem["fecha"]=$fechaComprobante; 
        $aItem["base"]=0;


        $oLista=new Data("cuenta_contable","idCuentaContable",$vacaciones[0]["idEmpresaCuenta"]);
        $aCuentavacaciones=$oLista->getDatos();  
        unset($oLista);

        $aItem["naturaleza"]=$aCuentavacaciones["naturaleza"];

		if ($aCuentavacaciones["naturaleza"]=='debito') {
	        $aItem["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$provisiones["vacaciones"])));
	        $aItem["saldoCredito"]=0;
	    }
	    if ($aCuentavacaciones["naturaleza"]=='credito') {
	        $aItem["saldoDebito"]=0;
	        $aItem["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$provisiones["vacaciones"])));
	    }
    
        $oItem=new Data("comprobante_items","idComprobanteItem"); 
        foreach($aItem  as $keycc => $valuecc){
            $oItem->$keycc=$valuecc; 
        }
        $oItem->guardar(); 
        unset($oItem);



        $aItem["idComprobante"]=$idComprobanteP; 
        $aItem["idCuentaContable"]=$vacaciones[1]["idEmpresaCuenta"];
        $aItem["idCentroCosto"]=" ";
        $aItem["idSubcentroCosto"]=" ";
        $aItem["idTercero"]=$aTercero["idTercero"];
        $aItem["descripcion"]='VACACIONES';
        $aItem["tipoTercero"]='p';
        $aItem["idUsuarioRegistra"]=$_SESSION["idUsuario"]; 
        $aItem["fecha"]=$fechaComprobante; 
        $aItem["base"]=0;


        $oLista=new Data("cuenta_contable","idCuentaContable",$vacaciones[1]["idEmpresaCuenta"]);
        $aCuentavacaciones=$oLista->getDatos();  
        unset($oLista);

        $aItem["naturaleza"]=$aCuentavacaciones["naturaleza"];

		if ($aCuentavacaciones["naturaleza"]=='debito') {
	        $aItem["saldoDebito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$provisiones["vacaciones"])));
	        $aItem["saldoCredito"]=0;
	    }
	    if ($aCuentavacaciones["naturaleza"]=='credito') {
	        $aItem["saldoDebito"]=0;
	        $aItem["saldoCredito"]=str_replace(",", ".",str_replace("$", "", str_replace(".", "",$provisiones["vacaciones"])));
	    }
    
        $oItem=new Data("comprobante_items","idComprobanteItem"); 
        foreach($aItem  as $keycc => $valuecc){
            $oItem->$keycc=$valuecc; 
        }
        $oItem->guardar(); 
        unset($oItem);
        }
    }
    // ------------------------------------------------------------------------------------------------------------------
 	

                if ($comp==true) {

                	$oLista=new Lista("nomina_comprobante");
                	$oLista->setFiltro("idNomina","=",$idNomina);
                	$nominaComp=$oLista->getLista();
                	unset($oLista);

                	if (empty($nominaComp)) {
                		
	                	$aItemC["idNomina"]=$idNomina;
	                	$aItemC["idComprobante"]=$idComprobante;
	                	$aItemC["idUsuarioRegistra"]=$_SESSION["idUsuario"];
	                	$aItemC["fechaRegistro"]=date('Y-m-d');
	                	$aItemC["tipo"]=1;


	                	$oItem=new Data("nomina_comprobante","idNominaComprobante"); 
				        foreach($aItemC  as $keycc => $valuecc){
				            $oItem->$keycc=$valuecc; 
				        }
				        $oItem->guardar(); 
				        unset($oItem);

				        $aItemC["idNomina"]=$idNomina;
	                	$aItemC["idComprobante"]=$idComprobanteE;
	                	$aItemC["idUsuarioRegistra"]=$_SESSION["idUsuario"];
	                	$aItemC["fechaRegistro"]=date('Y-m-d');
	                	$aItemC["tipo"]=2;


	                	$oItem=new Data("nomina_comprobante","idNominaComprobante"); 
				        foreach($aItemC  as $keycc => $valuecc){
				            $oItem->$keycc=$valuecc; 
				        }
				        $oItem->guardar(); 
				        unset($oItem);

				        $aItemC["idNomina"]=$idNomina;
	                	$aItemC["idComprobante"]=$idComprobanteP;
	                	$aItemC["idUsuarioRegistra"]=$_SESSION["idUsuario"];
	                	$aItemC["fechaRegistro"]=date('Y-m-d');
	                	$aItemC["tipo"]=3;


	                	$oItem=new Data("nomina_comprobante","idNominaComprobante"); 
				        foreach($aItemC  as $keycc => $valuecc){
				            $oItem->$keycc=$valuecc; 
				        }
				        $oItem->guardar(); 
				        unset($oItem);
	                	
                	}
                	
                	// if (!empty($nominaComp)) {

                	// }
					 
					 
                }



                if ($comp==false) {

                    $oLista=new Lista("comprobante");
                    $oLista->setFiltro("idComprobante","=",$idComprobante);
                    $comEliminar=$oLista->getlista();
                    unset($oLista);
                    foreach ($comEliminar as $keym => $valuem) {
                        $oItem=new Data("comprobante","idComprobante",$valuem["idComprobante"]);
                        $oItem->eliminar();
                        unset($oItem);
                    }

                    $oLista=new Lista("comprobante_items");
                    $oLista->setFiltro("idComprobante","=",$idComprobante);
                    $comprobanteItemsEliminar=$oLista->getlista();
                    unset($oLista);
                    foreach ($comprobanteItemsEliminar as $keym => $valuem) {
                        $oItem=new Data("comprobante_items","idComprobanteItem",$valuem["idComprobanteItem"]);
                        $oItem->eliminar();
                        unset($oItem);
                    }


                    $oLista=new Lista("comprobante");
                    $oLista->setFiltro("idComprobante","=",$idComprobanteE);
                    $comEliminarE=$oLista->getlista();
                    unset($oLista);
                    foreach ($comEliminarE as $keyE => $valueE) {
                        $oItem=new Data("comprobante","idComprobante",$valueE["idComprobante"]);
                        $oItem->eliminar();
                        unset($oItem);
                    }

                    $oLista=new Lista("comprobante_items");
                    $oLista->setFiltro("idComprobante","=",$idComprobante);
                    $comprobanteItemsEliminar=$oLista->getlista();
                    unset($oLista);
                    foreach ($comprobanteItemsEliminar as $keyE => $valueE) {
                        $oItem=new Data("comprobante_items","idComprobanteItem",$valueE["idComprobanteItem"]);
                        $oItem->eliminar();
                        unset($oItem);
                    }
                    
                    $oLista=new Lista("comprobante");
                    $oLista->setFiltro("idComprobante","=",$idComprobanteP);
                    $comEliminarP=$oLista->getlista();
                    unset($oLista);
                    foreach ($comEliminarP as $keyP => $valueP) {
                        $oItem=new Data("comprobante","idComprobante",$valueP["idComprobante"]);
                        $oItem->eliminar();
                        unset($oItem);
                    }

                    $oLista=new Lista("comprobante_items");
                    $oLista->setFiltro("idComprobante","=",$idComprobante);
                    $comprobanteItemsEliminar=$oLista->getlista();
                    unset($oLista);
                    foreach ($comprobanteItemsEliminar as $keyP => $valueP) {
                        $oItem=new Data("comprobante_items","idComprobanteItem",$valueP["idComprobanteItem"]);
                        $oItem->eliminar();
                        unset($oItem);
                    }


                    $comprobanteEmpleado=0;
					$comprobanteEmpleador=0;
					$comprobanteProvisiones=0;



					$oLista=new Lista("parametros_documentos");
				    $oLista->setFiltro("idParametrosDocumentos","=",$datos['tipoDocumento']);
				    $oLista->setFiltro("idEmpresa","=",$datos["idEmpresa"]);
				    $aNumero=$oLista->getLista();
				    unset($oLista);


					$nCom["numeracionActual"]=$numeroComprobanteAntiguo;
			        $oItem=new Data("parametros_documentos","idParametrosDocumentos",$aNumero[0]["idParametrosDocumentos"]); 
			        foreach($nCom  as $keyC => $valueC){
			            $oItem->$keyC=$valueC; 
			        }

			        $oItem->guardar(); 
			        unset($oItem);

                }

}


// $msg=true;
 
echo json_encode(array("msg"=>$msg,"empleado"=>$comprobanteEmpleado,"empleador"=>$comprobanteEmpleador,"provisiones"=>$comprobanteProvisiones));

?>