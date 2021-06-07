<?php
ob_start();

require_once("../../php/restrict.php");


$idLegalizacion=$_GET['id'];
$URL=$_GET['url'];

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");

require_once ("../../class/legalizaciones.php");


$oControl=new Control(); 


$oLegalizacion=new Legalizaciones();
   

$aLegalizacionItem=$oLegalizacion->getItemsLegalizacionesPDF($idLegalizacion);
unset($oLegalizacion);

$oLegalizacion=new Legalizaciones();

$aLegalizacionItemOtros=$oLegalizacion->getItemsLegalizaciones($idLegalizacion);
unset($oLegalizacion);


$oLista = new Lista('legalizaciones');

$oLista->setFiltro("idProyectoLegalizacion","=",$idLegalizacion); 

$aLegalizaciones=$oLista->getLista();

unset($oLista);


$oLista = new Data('proyecto_legalizacion','idProyectoLegalizacion',$idLegalizacion);

$aLegalizacion=$oLista->getDatos();

unset($oLista);

$oLista = new Data('ciudad','idCiudad',$aLegalizacion['ciudadDesde']);

$ciudadDesde=$oLista->getDatos();

unset($oLista);

$oLista = new Data('ciudad','idCiudad',$aLegalizacion['ciudadHasta']);

$ciudadHasta=$oLista->getDatos();

unset($oLista);

$oLista = new Data('departamento','idDepartamento',$aLegalizacion['departamentoDesde']);

$departamentoDesde=$oLista->getDatos();

unset($oLista);

$oLista = new Data('departamento','idDepartamento',$aLegalizacion['departamentoHasta']);

$departamentoHasta=$oLista->getDatos();

unset($oLista);

$oLista = new Data('empleado','idEmpleado',$aLegalizacion['persona']);

$persona=$oLista->getDatos();

unset($oLista);

$oLista = new Data('empresa','idEmpresa',$aLegalizacion['idEmpresa']);

$aEmpresa=$oLista->getDatos();

unset($oLista);





?>

<html>
	<head>
		<meta charset="utf-8">
		 <meta charset="UTF-8">
		 <meta http-equiv="Content-type" content="text/html; charset=utf-8" />

		 <link rel="stylesheet" href="<?php echo $URL ?>assets/css/custom.css">

  <link rel="stylesheet" href="<?php echo $URL ?>assets/css/estilo.css?<?php echo uniqid(); ?>">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap">

  <link rel="stylesheet" href="../../assets/bundles/datatables/datatables.min.css">

  <link rel="stylesheet" href="../../assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">

  

  <link rel="stylesheet" href="../../assets/bundles/select2/dist/css/select2.min.css">

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <link rel='shortcut icon' type='image/x-icon' href='<?php echo $URL; ?>assets/img/smart.ico' />
  		<style>
	  body { font-family: DejaVu Sans, sans-serif; }
	</style>
	</head>
	<body>
		<div class="card" id="muestra">
			<table class="table-bordered" border="0.5" cellpadding="10" cellspacing="0" style="width: 100%">
			  <thead >
			    <tr style="text-align: center; ">

			      <th rowspan="2"><?php if ($aEmpresa['logo']!="") { ?><img width="40" height="40" alt="image" src="<?php echo $URL.$aEmpresa['logo']; ?>" >
			      	<?php }  ?></th>
			      
			      <th colspan="6" style="font-size: 15px;"><?php echo $aEmpresa['razonSocial'] ?></th>
			      <th  style="font-size: 12px;">LG<?php echo date('Y').date('m').date('d').$idLegalizacion; ?></th>
			    </tr>
			  </thead>
			  <tbody>
			    <tr style="text-align: center; ">
			      
			      <td colspan="6" style="font-size: 12px;"><span>FORMATO DE LEGALIZACIÓN DE GASTOS DE VIAJE Y GASTOS DE PROYECTOS</span></td>
			   	  <td style="font-size: 12px;"><?php echo date('Y-m-d'); ?></td>
			    </tr>
			   
			  </tbody>
		</table>
			<table class="table table-bordered" border="0.2" cellpadding="2" cellspacing="0" style="width: 100%">
				<thead >
					<tr>
						<th colspan="7" style="font-size: 12px;background-color: #ECECEC">DATOS GENERALES</th>
					</tr>
				</thead>
				<tbody style="font-size: 11px;">
					<tr>
						<td>VIAJE A:</td>
						<td colspan="6"><?php echo $ciudadDesde['nombre'].'('.$departamentoDesde['nombre'].')->'.$ciudadHasta['nombre'].'('.$departamentoHasta['nombre'].')'; ?></td>
					</tr>
					<tr>
						<td>CONTRATO:</td>
						<td colspan="6"><?php echo $aLegalizacion['contrato']?></td>
					</tr>
					<tr>
						<td>MOTIVO DEL VIAJE:</td>
						<td colspan="6"><?php echo $aLegalizacion['motivo']?></td>
					</tr>
					<tr>
						<td>PERSONA:</td>
						<td colspan="6"><?php echo $persona['nombre'].' '.$persona['apellido'];?></td>
					</tr>
					<tr>
						<td>FECHA LEGALIZACION:</td>
						<td colspan="6"><?php echo $aLegalizacion['fechaLegalizacion']?></td>
					</tr>
					<tr>
						<td>INICIO VIAJE:</td>
						<td colspan="6"><?php echo $aLegalizacion['inicioViaje']?></td>
					</tr>
					<tr>
						<td>FIN VIAJE:</td>
						<td colspan="6"><?php echo $aLegalizacion['finViaje']?></td>
					</tr>
					<tr>
						<td>PRIMER VIAJE:</td>
						<td colspan="6"><?php echo $aLegalizacion['primerViaje']?></td>
					</tr>
				</tbody>
			</table>
			<table class="table table-striped"  cellpadding="6" cellspacing="0" style="width: 100%">
				<thead style="border-style: solid;">
					<tr>
						<th colspan="5" style="font-size: 12px;background-color: #ECECEC">DETALLE DE VIÁTICOS</th>
					</tr>
					
				</thead>
				<thead style="border-style: solid;">
					<tr style="font-size: 10px;background-color: #ECECEC;">
						<th>Item</th>
						<th>Concepto</th>
						<th>Valor Unit.</th>
						<th>Cantidad</th>
						<th>Subtotal</th>
					</tr>
				</thead>
				<tbody style="font-size: 11px; background-color: #FAFAFA;">

					<?php $totalA=0;
					foreach ($aLegalizacionItem as $index => $item) {

						if ($item['tipoLegalizacion']!=4) {
							
						$totalA=$totalA+$item['valorItem'];
						?>
						
					
					<tr>
						<td><?php echo $index+1 ?></td>
						<td ><?php 
						if ($item['tipoLegalizacion']==1) {
							$tipo='ALIMENTACIÓN';
						}
						if ($item['tipoLegalizacion']==2) {
							$tipo='HOSPEDAJE';
						}
						if ($item['tipoLegalizacion']==3) {
							$tipo='TRANSPORTE';
						}
						if ($item['tipoLegalizacion']==4) {
							$tipo='OTROS';
						}
						echo $tipo; ?></td>
						<td><?php echo "$".number_format($item['valorItem'],0,".",","); ?></td>
						<td >1</td>
						<td><?php echo "$".number_format($item['valorItem'],0,".",","); ?></td>
						
					</tr>
					<?php }} ?>
					<tr>
						<td>TOTAL (A):</td>
						<td colspan="3"></td>
						<td><?php echo "$".number_format($totalA,0,".",","); ?></td>
					</tr>

				</tbody>
			</table>
			<table class="table table-striped"  cellpadding="6" cellspacing="0" style="width: 100%">
				<thead style="border-style: solid;">
					<tr>
						<th colspan="5" style="font-size: 12px;background-color: #ECECEC">DETALLE DE GASTOS DE PROYECTO</th>
					</tr>
					
				</thead>
				<thead style="border-style: solid;">
					<tr style="font-size: 10px;background-color: #ECECEC;">
						<th>Item</th>
						<th>Costos directos</th>
						<th>Valor Unit.</th>
						<th>Cantidad</th>
						<th>Subtotal</th>
					</tr>
				</thead>
				<tbody style="font-size: 11px; background-color: #FAFAFA;">
					
					<?php $totalB=0;
					foreach ($aLegalizacionItemOtros as $indexO => $itemOtros) {

						if ($itemOtros['tipoLegalizacion']==4) {
							
						$totalB=$totalB+$itemOtros['valor'];
						?>
						
					<tr>
						<td><?php echo $indexO+1; ?></td>
						<td ><?php echo $itemOtros['concepto']; ?></td>
						<td><?php echo "$".number_format($itemOtros['valor'],0,".",","); ?></td>
						<td >1</td>
						<td><?php echo "$".number_format($itemOtros['valor'],0,".",","); ?></td>
						
					</tr>
					<?php }} ?>
					<tr>
						<td>TOTAL COSTOS DIRECTOS (B):</td>
						<td colspan="3"></td>
						<td><?php echo "$".number_format($totalB,0,".",","); ?></td>
					</tr>
				</tbody>
			</table>
			<hr>
			<br>
			<hr>
			<table class="table" style="width: 100%;font-size: 10px;">
				<tbody>
					<!-- <tr>
						<th style="text-align: left;">TOTAL DEL ANTICIPO CONSIGNADO</th>
						<td colspan="3"></td>
						<th>$800.000</th>
					</tr>
					<tr>
						<th style="text-align: left;">FECHA DEL ANTICIPO</th>
						<td colspan="2">2020-12-06</td>
						<th colspan="2"></th>
					</tr> -->
					<tr>
						<th style="text-align: left;">TOTAL GASTADO (A+B)</th>
						<td colspan="3"></td>
						<th><?php $total=$totalA+$totalB;
							echo "$".number_format($total,0,".",",");

						?></th>
					</tr>
					<tr>
						<th style="text-align: left;">TOTAL RETENCIÓN</th>
						<td colspan="3"></td>
						<th>$0</th>
					</tr>
					<tr>
						<th style="text-align: left;">SALDO</th>
						<td colspan="3"></td>
						<th>$0</th>
					</tr>
				</tbody>
			</table>
			<br>
			<span style="font-size: 8px;">Nota: Todo excedente de dinero debe ser consignado directamente a la cuenta N° de Banco a nombre de JURISCON OUTSOURCING SAS El área de tesorería y contabilidad no están autorizados </span>
			<br>
			<div style="background-color: #ECECEC;font-size: 10px;width: 100%">FIRMAS</div>
			<br>
			<br>
			<table style="width: 100%;" cellspacing="0" cellpadding="0">
				<tbody style="font-size: 10px; text-align: center;">
					<tr>
						<td colspan="3"></td>
					</tr>
					<tr style="text-align: center;">
						<!-- <td>INGRESADA:</td> -->
						<td>ACEPTADA CONTABILIDAD</td>
						<td>ACEPTADA PROYECTO/ADMINISTRACIÓN</td>
					</tr>
					<!--<tr style="text-align: center;"> 
						<td>Prueba Prueba</td>
						<td>Super Administrador</td>
						<td>Super Administrador</td>
					</tr> -->
				</tbody>
			</table>
		</div>
	</body>
</html>

<?php
require_once "../../assets/bundles/dompdf/autoload.inc.php";

use Dompdf\Dompdf;

$pdf = new Dompdf(array('enable_remote' => true));

$pdf->load_html(utf8_decode(utf8_encode(ob_get_clean())));
$pdf->render();
$filename = "ejemplo.pdf";

$pdf->stream($filename,array("Attachment"=>0));
?>