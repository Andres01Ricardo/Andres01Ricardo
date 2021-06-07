<?php
ob_start();

header('Content-Type: text/html; charset=UTF-8');
require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");
date_default_timezone_set("America/Bogota"); 


$idLibranza=$_GET["idLibranza"];;

if(!isset($_SESSION)){ session_start(); }

$oLista = new Lista('libranza_item');

$oLista->setFiltro("idLibranza","=",$idLibranza);

$aLibranza=$oLista->getLista();

unset($oLista);


$oItem = new Data("libranza","idLibranza",$idLibranza);

$aLibranzaOriginal=$oItem->getDatos();

unset($oItem);

$oItem = new Data("empresa","idEmpresa",$aLibranzaOriginal["idEmpresa"]);

$aEmpresa=$oItem->getDatos();

unset($oItem);


$idEmpleado=$aLibranzaOriginal["idEmpleado"];
$cuotas = $aLibranzaOriginal["plazo"];
$valorCredito=$aLibranzaOriginal["valorSolicitado"];
$tasaInteres=$aLibranzaOriginal["tasaInteres"];
$tasaInteresAnual=$tasaInteres *12;

$oItem=new Data("empleado","idEmpleado",$idEmpleado); 
$rows=$oItem->getDatos(); 
unset($oItem);

$porcentajeTasaInteres= $tasaInteres/100;
$valorCuota = ($valorCredito*(($porcentajeTasaInteres)*(pow(1+$porcentajeTasaInteres,$cuotas))))/((pow(1+$porcentajeTasaInteres,$cuotas))-1);

$montoTotalPagar=$valorCuota*$cuotas;
$totalInteresesPagar = $montoTotalPagar - $valorCredito;

$totalInteresesPagar=round($totalInteresesPagar);
$montoTotalPagar=round($montoTotalPagar);
?>
<html lang="es-ES">
	<head>
		<meta charset="utf-8">
		<meta charset="UTF-8">
		<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
		<style>
		  body { font-family: DejaVu Sans, sans-serif; }
		</style>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	</head>
	<body>

		<div style="background-color: #9A9999; color: white"><h4>Información del prestamista</h4></div>
		<table class="table">
		  <thead>
		    <tr>
		      <td scope="col">Nombre:</td>
		      <th scope="col"><?php echo $aEmpresa['razonSocial']; ?></th> 
		      <th scope="col"></th>
		      <th scope="col"><img width="60" height="60" style="float: right;" alt="image" src="<?php echo $URL.$aEmpresa['logo']; ?>" ></th>  
		    </tr>
		    
		  </thead>
		  <tbody>
		  	<tr>
		    	<td></td>
		    	<td></td>

		    </tr>
		    <tr>
		      <td>NIT:</td>
		      <th><?php echo $aEmpresa['nit']; ?></th>
		      <td>Dirección:</td>
		      <th><?php echo $aEmpresa['direccion']; ?></th>
		    </tr>
		    <tr>
		      <td>Correo:</td>
		      <th><?php echo $aEmpresa['email']; ?></th>
		      <td>Telefono:</td>
		      <th><?php echo $aEmpresa['telefono']; ?></th>
		    </tr>
		  </tbody>
		</table>
		<hr>
		  <div style="background-color: #9A9999; color: white"><h4>Caracteristicas originales del credito</h4></div>
		<table class="table-striped">
		  <thead>
		    <tr>
		      <th></th>
		      <th></th>
		      <th>Numero de solicitud:</th>
		      <th>100</th>
		    </tr>
		  </thead>
		  <tbody>
		    <tr>
		      <th scope="row">Plazo en meses:</th>
		      <td><?php echo $cuotas ?></td>
		      <th>Valor solicitado:</th>
		      <td><?php echo "$".number_format($valorCredito,0,".",",") ?></td>
		    </tr>
		    <tr>
		      <th scope="row">Tasa de interes:</th>
		      <td><?php echo $tasaInteres; ?>%</td>
		      <th>Tasa de interes anual calculada:</th>
		      <td><?php echo $tasaInteresAnual; ?>%</td>
		    </tr>
		    <tr>
		      <th scope="row">Estado de la solicitud:</th>
		      <td>Pendiente</td>
		      <th>Nombre/Cedula:</th>
		      <td><?php echo $rows['nombre'].' '.$rows['apellido'];?> / <?php echo $rows['numeroDocumento']; ?></td>
		    </tr>
		    <tr>
		      <th scope="row">Monto a pagar mensualmente:</th>
		      <td><?php echo "$".number_format($valorCuota,0,".",","); ?></td>
		      <th>Monto total a pagar:</th>
		      <td><?php echo "$".number_format($montoTotalPagar,0,".",",") ?></td>
		    </tr>
		    <tr>
		      <th scope="row">Total de intereses a pagar:</th>
		      <td><?php echo "$".number_format($totalInteresesPagar,0,".",",") ?></td>
		      <th>Valor desembolso:</th>
		      <td><?php echo "$".number_format($valorCredito,0,".",",") ?></td>
		    </tr>
		  </tbody>
		</table>
<hr>
		<div style="background-color: #9A9999; color: white"><h4>Detalles del credito</h4></div>

		<div class="card card-body">
		  <table class="table-striped table-bordered">
		    <thead>
		      <tr style="font-size: 10px;">
		        <th scope="col">#Cuota numero</th>
		        <th scope="col">Deuda inicial</th>
		        <th scope="col">Pago intereses</th>
		        <th scope="col">Pago capital</th>
		        <th scope="col">Valor cuota</th>
		        <th scope="col">Valor pagado cuota</th>
		        <th scope="col">Fecha vencimiento cuota</th>
		        <th scope="col">Estado cuota</th>
		        <th scope="col">Comprobante pago</th>
		      </tr>
		    </thead>
		    <tbody style="font-size: 13px;">
		      <?php  $numeroLibranza = 1;
		      foreach($aLibranza as $libranzaFinal){ ?>
		      <tr>
		        <th scope="row"><?php echo $numeroLibranza; ?></th>
		        <td><?php echo $libranzaFinal['deudaInicial']; ?></td>
		        <td><?php echo $libranzaFinal['pagoIntereses']; ?></td>
		        <td><?php echo $libranzaFinal['pagoCapital']; ?></td>
		        <td><?php echo $libranzaFinal['valorCuota']; ?></td>
		        <td><?php echo $libranzaFinal['valorPagadoCuota']; ?></td>
		        <td><?php echo $libranzaFinal['fechaVencimientoCuota']; ?></td>
		        <td><?php echo $libranzaFinal['estadoCuota']; ?></td>
		        <td><?php echo $libranzaFinal['comprobantePago']; ?></td>
		      </tr>
		      <?php $numeroLibranza++;
		    } ?>
		    </tbody>
		  </table>
		</div>
	</body>
</html>

<?php
require_once "../../assets/bundles/dompdf/autoload.inc.php";
use Dompdf\Dompdf;

$pdf = new Dompdf(array('enable_remote' => true));

// $pdf->load_html(utf8_decode(ob_get_clean()));
$pdf->load_html(ob_get_clean(), 'UTF-8');
$pdf->render();
$filename = "libranzaFinal.pdf";

$pdf->stream($filename,array("Attachment"=>0));
?>