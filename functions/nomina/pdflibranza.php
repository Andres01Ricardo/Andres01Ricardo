<?php
ob_start();

header('Content-Type: text/html; charset=UTF-8');
require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");
date_default_timezone_set("America/Bogota"); 
if(!isset($_SESSION)){ session_start(); }

$idEmpleado=$_GET["idEmpleado"];
$valorCuota=$_GET["valorCuota"];
$valorCredito=$_GET["valorCredito"];
$cuotas=$_GET["cuotas"];
$hoy=date("d-m-Y");
$mes=date("m");

 switch ($mes) {
	case 1:
		$mes='Enero';
		break;
	case 2:
		$mes='Febrero';
		break;
	case 3:
		$mes='Marzo';
		break;
	case 4:
		$mes='Abril';
		break;
	case 5:
		$mes='Mayo';
		break;
	case 6:
		$mes='Junio';
		break;
	case 7:
		$mes='Julio';
		break;
	case 8:
		$mes='Agosto';
		break;
	case 9:
		$mes='Septiembre';
		break;
	case 10:
		$mes='Octubre';
		break;
	case 11:
		$mes='Noviembre';
		break;
	case 12:
		$mes='Diciembre';
		break;
	default:
		# code...
		break;
}; 



$oItem=new Data("empresa","idEmpresa",$_SESSION['idEmpresa']); 
$rows=$oItem->getDatos(); 
unset($oItem);

$oItem=new Data("empleado","idEmpleado",$idEmpleado); 
$rowse=$oItem->getDatos(); 
unset($oItem);
?>
<html lang="es-ES">
	<head>
		<meta charset="utf-8">
		 <meta charset="UTF-8">
		 <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
		 <style>
		  body { font-family: DejaVu Sans, sans-serif; }
		</style>
	</head>
	<body>
<div id="cartaAutorizacion">
	<label>Bucaramanga, <?php echo $hoy; ?></label><img width="70" height="70" style="float: right;" alt="image" src="<?php echo $URL.$rows['logo']; ?>" >
	<br><br><br><br>
	<label>Señores</label><br>
	<label><strong><?php echo $rows['razonSocial'];?></strong></label><br>
	<label>Ciudad</label>
	<br><br><br>
	<label>Cordial saludo.</label><br><br>
	<p>Por medio del presento yo, <?php echo $rowse['nombre'].' '.$rowse['apellido'];?>, identificado con cédula de ciudadanía No. <?php echo $rowse['numeroDocumento'];?> autorizo a <?php echo $rows['razonSocial'];?>, para que descuente de mi nómina mensual la suma de <?php echo "$".number_format($valorCuota,0,".",",");?>, por concepto de la libranza, monto total aprobado <?php echo "$".number_format($valorCredito,0,".",","); ?> a mi nombre.</p><br>
	<p>
		la presente libranza es liquidada a <?php echo $cuotas ?> meses y se descontara a partir de la nómina del mes de <?php echo $mes; ?> del año <?php echo substr($hoy,6,9)?>.
	</p><br>
	<p>
		En caso de retiro o por terminación del contrato de trabajo, autorizo a <?php echo $rows['razonSocial'];?>, a girar todos los dineros correspondientes de mi liquidación, sueldo y demás emolumentos que pueda percibir, con el fin de cubrir el saldo de la libranza si lo hubiere.
	</p><br><br>
	<p>Atentamente,</p><br><br><br>

	<p>____________________________</p><br>
	<p>C.C__________________________</p>


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
$filename = "libranza.pdf";

$pdf->stream($filename,array("Attachment"=>0));
?>