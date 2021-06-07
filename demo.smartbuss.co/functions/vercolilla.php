<?php
header('Content-type', 'application/pdf');
require_once("../php/restrict.php");

include_once($CLASS . "data.php");
include_once($CLASS . "lista.php");
include_once($CLASS . "control.php");

require_once("../class/empleados.php"); 
require_once('../libraries/dompdf/dompdf_config.inc.php');
require_once('../libraries/dompdf/Options.php');
require $ROOT.'vendor/autoload.php';


$oControl=new Control();
$oEmpleado=new Empleados();  
date_default_timezone_set("America/Bogota"); 

$id  = (isset($_REQUEST['colilla'] ) ? $_REQUEST['colilla'] : "" );
$decrip["cadena"]=$id; 
$id=$oControl->desencriptar($decrip); 


$oItem=new Data("nomina_empleado","idNominaEmpleado", $id); 
$aIdNominaEmpleado=$oItem->getDatos(); 
unset($oItem); 

$oItem=new Data("nomina","idNomina", $aIdNominaEmpleado["idNomina"]); 
$aNomina=$oItem->getDatos(); 
unset($oItem); 
$periodInicio=$aNomina["periodoAnio"].str_pad($aNomina["periodoMes"], 2, "0", STR_PAD_LEFT); 
$periodFin=$aNomina["periodoAnio"].str_pad($aNomina["periodoMes"], 2, "0", STR_PAD_LEFT); 
if($aNomina["periodoPago"]==0){
	$periodInicio=$periodInicio."01"; 
	$periodFin=$periodFin."30"; 
}else if($aNomina["periodoPago"]==1){
	$periodInicio=$periodInicio."01"; 
	$periodFin=$periodFin."15"; 
}else{
	$periodInicio=$periodInicio."15"; 
	$periodFin=$periodFin."30"; 	
}


$oItem=new Data("empresa","idEmpresa", $aNomina["idEmpresa"]); 
$aEmpresa=$oItem->getDatos(); 
unset($oItem); 

$nit=$aEmpresa["nit"];
if($aEmpresa["tipoPersona"]!=1){
	$nit=$nit."-".$aEmpresa["digitoVerificador"]; 
}

$oItem=new Data("empleado","idEmpleado", $aIdNominaEmpleado["idEmpleado"]); 
$aEmpleado=$oItem->getDatos(); 
unset($oItem);

$oLista=new Lista("empleado_informacion_laboral"); 
$oLista->setFiltro("estado","=",1); 
$oLista->setFiltro("idEmpleado","=",$aIdNominaEmpleado["idEmpleado"]); 
$oLista->setFiltro("idEmpresa","=",$aNomina["idEmpresa"]); 
$aCargo=$oLista->getLista()[0]; 
unset($oItem);


$oLista=new Lista("nomina_empleado_adiciones"); 
$oLista->setFiltro("idNominaEmpleado","=",$id); 
$aAdiciones=$oLista->getLista(); 
unset($oItem);

$oLista=new Lista("nomina_empleado_parafiscales"); 
$oLista->setFiltro("idNominaEmpleado","=",$id); 
$oLista->setFiltro("tipoDeduccion","=",1); 
$aLeyes=$oLista->getLista(); 
unset($oItem);

$oLista=new Lista("nomina_empleado_deducciones"); 
$oLista->setFiltro("idNominaEmpleado","=",$id); 
$aDeducciones=$oLista->getLista(); 
unset($oItem);

if(count($aAdiciones)+1<count($aLeyes)+count($aDeducciones)){
$rows=count($aLeyes)+count($aDeducciones); 
}else{
$rows=count($aAdiciones)+1; 
}                   
$html='
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Colilla De Pago</title>
</head>
<body>
<div style="width:100%;text-align:center"><h4>Comprobante de Nómina</h4></div>
<table style="width: 100%">
    <tbody>
      <tr>
        <td style="font-size: 13px;font-weight:bold;">
        <img style="width:130px; height:130px" src="http://localhost/juriscon/assets/img/SmartBusslogo-04.png"/>
          <br>NIT:'.$nit.'</td>
        <td style="text-align: right; font-size: 13px;">
          <p>Periodo de pago: <span style="font-weight:bold;">'.$periodInicio.' - '.$periodFin.'</span><br>
          Comprobante N°: <span style="font-weight:bold;"></span></p>
          <br><br>
          <p>Nombre: <span style="font-weight:bold;">'.$aEmpleado["nombre"]." ".$aEmpleado["apellido"].'</span><br>
            Identificación: <span style="font-weight:bold;">'.$aEmpleado["numeroDocumento"].'</span><br>
            Cargo: <span style="font-weight:bold;">'.$aCargo["cargo"].'</span><br>
            Salario Basico: <span style="font-weight:bold;">$'.number_format($aIdNominaEmpleado["salarioEmpleado"],0,",",".").'</span></p>
        </td>
      </tr>
    </tbody>
  </table>
  <br>
  <table style="width: 100%">
    <tbody>
      <tr style="color: #000;background-color: #a6aba6;font-weight: bold;margin:0px">
        <td style="width: 50%; text-align: center;font-size: 14px; border:1px solid" colspan="2">INGRESOS</td>
        <td style="width: 50%; text-align: center;font-size: 14px; border:1px solid" colspan="2">DEDUCCIONES</td>
      </tr>
      <tr style="margin:0">
        <td style="font-weight:bold;width: 40%; text-align: center;font-size: 14px;border:1px solid;margin:0">Concepto</td>
        <td style="font-weight:bold;width: 10%; text-align: center;font-size: 14px; border:1px solid;margin:0">Valor</td>
        <td style="font-weight:bold;width: 40%; text-align: center; font-size: 14px;border:1px solid;margin:0">Concepto</td>
        <td style="font-weight:bold;width: 10%; text-align: center;font-size: 14px;border:1px solid;margin:0">Valor</td>
      </tr>';
      $j=0;
      $totalIngresos=0; 
      $totalDeducciones=0; 
      for($i=0; $i<$rows;$i++){
      $html.='<tr style="margin:0"> '; 
      	if($j==0&&$i==0){
		$html.='<td style="width: 40%; ;font-size: 14px;border:1px solid;margin:0">Sueldo</td>
        <td style="width: 10%; text-align: center;font-size: 14px; border:1px solid;margin:0">$'.number_format($aIdNominaEmpleado["salarioEmpleado"],0,",",".").'</td>';
        $totalIngresos+=$aIdNominaEmpleado["salarioEmpleado"];  
    	}else{
    		$html.='<td style="width: 40%; ;font-size: 14px;border:1px solid;margin:0">'.$aAdiciones[$i-1]["concepto"].'</td>
        	<td style="width: 10%; text-align: center;font-size: 14px; border:1px solid;margin:0">$'.number_format($aAdiciones[$i-1]["valor"],0,",",".").'</td>';
        $totalIngresos+=$aAdiciones[$i-1]["valor"];  
    	}
    	if(!empty($aLeyes[$j])){
    		$concepto=$aLeyes[$j]["concepto"]; 
    		$valor=$aLeyes[$j]["valor"]; 
    	}else{
    		$j=0; 
    		$concepto=$aDeducciones[$j]["concepto"]; 
    		$valor=$aDeducciones[$j]["valor"]; 
    	}
    	$totalDeducciones+=$valor; 
        $html.='<td style="width: 40%;font-size: 14px;border:1px solid;margin:0">'.$concepto.'</td>
        <td style="width: 10%; text-align: center;font-size: 14px;border:1px solid;margin:0">$'.number_format($valor,0,",",".").'</td>
      </tr>';
      	$j++;
  		}
      $html.='<tr style="color: #000;background-color: #a6aba6;">
        <td style="font-weight:bold;font-size: 14px;width: 40%; text-align: right;border:1px solid">Total Ingresos</td>
        <td style="font-weight:bold;font-size: 14px;width: 10%; text-align: center;border:1px solid">$'.number_format($totalIngresos,0,",",".").'</td>
        <td style="font-weight:bold;font-size: 14px;width: 40%; text-align: right;border:1px solid">Total Deducciones</td>
        <td style="font-weight:bold;font-size: 14px;width: 10%; text-align: center;border:1px solid">$'.number_format($totalDeducciones,0,",",".").'</td>
      </tr>
    </tbody>
  </table>
  <br>
  <div style="width:100%;text-align:right; font-weight:bold;">Neto a Pagar: $'.number_format($aIdNominaEmpleado["valorPagar"],0,",",".").'</div>
</body>
</html>';

ob_start();
//$options = new Options();

# Instanciamos un objeto de la clase DOMPDF.
$mipdf = new DOMPDF();
//$mipdf->setOption('isPhpEnabled', true);
//$options = $mipdf->getOptions(); 
// $options->set(array('isRemoteEnabled' => true));
// $mipdf->setOptions($options);
# Definimos el tamaño y orientación del papel que queremos.
# O por defecto cogerá el que está en el fichero de configuración.
$mipdf->set_paper("A4", "portrait");
//$mipdf->set_option('isRemoteEnabled', TRUE);
# Cargamos el contenido HTML.
$mipdf->load_html($html);

# Renderizamos el documento PDF.
$mipdf->render();

# Enviamos el fichero PDF al navegador.
$mipdf->stream('FicheroEjemplo.pdf', array('Attachment' => 0));
?>