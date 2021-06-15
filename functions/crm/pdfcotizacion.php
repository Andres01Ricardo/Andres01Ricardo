<?php
ob_start();

require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");

$oControl=new Control(); 

$idCotizacion=$_GET['id'];
$URL=$_GET['url'];

$oLista = new Lista('cotizacion_item');

$oLista->setFiltro("idCotizacion","=",$idCotizacion); 

$aCotizacion=$oLista->getLista();

unset($oLista);


$oLista = new Data('cotizacion','idCotizacion',$idCotizacion);

$aCotizacionTotal=$oLista->getDatos();

unset($oLista);

$oLista = new Data('empresa','idEmpresa',$aCotizacionTotal['idEmpresa']);

$aEmpresa=$oLista->getDatos();

unset($oLista);


$oLista = new Data('t_clientes','codigoCliente',$aCotizacionTotal['idCliente']);

$aCliente=$oLista->getDatos();

unset($oLista);


?>

<html>
	<head>
		<meta charset="utf-8">
		 <meta charset="UTF-8">
		 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		

	</head>
	<body>
		<div class="card" id="muestra" >
			<table style="width: 90%;max-width: 90%">
			  <thead >
			    <tr style="text-align: center; ">
			      <th scope="col"><img width="70" height="70" alt="image" src="<?php echo $URL.$aEmpresa['logo']; ?>" ></th>
			      <th scope="col"><span> </span></th>
			      <th scope="col"><?php echo $aEmpresa['razonSocial'] ?></th>
			      <th scope="col" style="font-size: 20px;">Cotizacion</th>
			    </tr>
			  </thead>
			  <tbody>
			    <tr style="text-align: center; ">
			      <th scope="row"></th>
			      <td><span>Telefono: </span></td>
			   	  <td><?php echo $aEmpresa['telefono'] ?></td>
			   	  <td>Fecha: <?php echo $aCotizacionTotal['fechaRegistro'] ?></td>
			    </tr>
			   <tr style="text-align: center; ">
			   	<th></th>
			   	  <td><span>Direccion: </span></td>
			   	  <td><?php echo $aEmpresa['direccion'] ?></td>
			   	  <td>Fecha venc.: <?php echo $aCotizacionTotal['fechaVencimientoCotizacion'] ?></td>
			   </tr>
			  </tbody>
		</table>

		<br><br>
		<hr>
		<div class="row">
			<div class="col-md-2 col-lg-2"></div>
				<div class="col-md-10 col-lg-10"><span>Sr.(es):
		<?php echo $aCliente['nombre'].' '.$aCliente['apellidos'];?></span></div>
			</div>
			<br>
		<div class="row">
			<div class="col-md-2 col-lg-2">
				
			</div>
			<div class="col-md-5 col-lg-5">
				<span>Direccion:
				<?php echo $aCliente['direccion'];?>
				</span>
			</div>
			<div class="col-md-5 col-lg-5">
				<span>Telefono:
				<?php echo $aCliente['telefono'];?></span>
			</div>
		</div>
		<hr>
		<br>
			<table class="table-striped" cellpadding="14" id="muestra" style="width: 90%;max-width: 90%;font-size: 85%">
			  <thead style="background-color: #87BFFE; color: white; ">
			    <tr style="height: 30px;">
			      <th scope="col">Detalle producto</th>
			      <th scope="col">descripcion</th>
			      <th scope="col">Cantidad</th>
			      <th scope="col">Valor unitario</th>
			      <th scope="col">Subtotal</th>
			      <th scope="col">IVA</th>
			      <th scope="col">Total</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php foreach($aCotizacion as $cotizacion){ ?>
			    <tr style="text-align: center;">
			      <th scope="row"><?php echo $cotizacion['detalleProducto'];?></th>
			      <td ><?php echo $cotizacion['descripcion'];?></td>
			      <td ><?php echo $cotizacion['cantidad'];?></td>
			      <td><?php echo "$".number_format($cotizacion['valorUnitario'],2,",","."); ?></td>
			      <td><?php echo "$".number_format($cotizacion['subtotal'],2,",","."); ?></td>
			      <td><?php echo $cotizacion['iva'];?>%</td>
			      <td><?php echo "$".number_format($cotizacion['total'],2,",",".");?></td>
			    </tr>
			   <?php } ?>
			   <tr style="text-align: center; ">
			   	<th>Total cotizacion</th>
			   	<td>-</td>
			   	<td>-</td>
			   	<td>-</td>
			   	<td><?php echo "$".number_format($aCotizacionTotal['subtotal'],2,",","."); ?></td>
			   	<td><?php echo "$".number_format($aCotizacionTotal['iva'],2,",","."); ?></td>
			   	<td><?php echo "$".number_format($aCotizacionTotal['total'],2,",","."); ?></td>
			   </tr>
			  </tbody>
		</table>
		<p style="text-align:justify;">Observaciones: <?php echo $aCotizacionTotal['observaciones'] ?></p>
		</div>
	</body>
</html>

<?php
require_once "dompdf/autoload.inc.php";
use Dompdf\Dompdf;

$pdf = new Dompdf(array('enable_remote' => true));

$pdf->load_html(utf8_decode((utf8_encode(ob_get_clean()))));
$pdf->render();
$filename = "ejemplo.pdf";

$pdf->stream($filename,array("Attachment"=>0));
?>