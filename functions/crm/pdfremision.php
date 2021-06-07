<?php
ob_start();



require_once("../../php/restrict.php");



include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");

$oControl=new Control(); 

$idRemision=$_GET['id'];
$URL=$_GET['url'];

$oLista = new Lista('remision_item');

$oLista->setFiltro("idRemision","=",$idRemision); 

$aCotizacion=$oLista->getLista();

unset($oLista);


$oLista = new Data('remision','idRemision',$idRemision);

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

	</head>
	<body>
		<div class="card" id="muestra">
			<table >
			  <thead >
			    <tr style="text-align: center; ">
			      <th scope="col"><img width="70" height="70" src="<?php echo $URL.$aEmpresa['logo']; ?>" ></th>
			      <!-- <th scope="col"><span>Razon social: </span></th> -->
			      <th scope="col"><?php echo $aEmpresa['razonSocial'] ?></th>
			      <th></th>
			      <th scope="col" style="font-size: 20px;">Cotizacion</th>
			    </tr>
			  </thead>
			  <tbody>
			    <tr style="text-align: center; ">
			      <th scope="row"></th>
			      <td><span>Telefono: </span></td>
			   	  <td><?php echo $aEmpresa['telefono'] ?></td>
			   	  <td></td>
			   	  <td>Fecha: <?php echo $aCotizacionTotal['fecha'] ?></td>
			    </tr>
			   <tr style="text-align: center; ">
			   	<th></th>
			   	  <td><span>Direccion: </span></td>
			   	  <td><?php echo $aEmpresa['direccion'] ?></td>
			   	  <!-- <td></td>
			   	  <td>Fecha venc.: <?php echo $aCotizacionTotal['fechaVencimientoCotizacion'] ?></td> -->
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
			<table class="table-striped" cellpadding="20" id="muestra" style="width: 100%">
			  <thead style="background-color: #87BFFE; color: white; ">
			    <tr style="height: 50px;">
			      <th scope="col">Detalle producto</th>
			      <th scope="col">descripcion</th>
			      <th scope="col">Cantidad</th>		      
			    </tr>
			  </thead>
			  <tbody>
			  	<?php foreach($aCotizacion as $cotizacion){ ?>
			    <tr style="text-align: center;">
			      <th scope="row"><?php echo $cotizacion['detalleProducto'];?></th>
			      <td ><?php echo $cotizacion['descripcion'];?></td>
			      <td ><?php echo $cotizacion['cantidad'];?></td>      
			    </tr>
			   <?php } ?>
			  </tbody>
		</table>
		<span>Observaciones: <?php echo $aCotizacionTotal['observaciones'] ?></span>
		</div>
	</body>
</html>

<?php
require_once "dompdf/autoload.inc.php";
use Dompdf\Dompdf;

$pdf = new Dompdf(array('enable_remote' => true));

$pdf->load_html(utf8_decode(ob_get_clean()));
$pdf->render();
$filename = "ejemplo.pdf";

$pdf->stream($filename,array("Attachment"=>0));
?>