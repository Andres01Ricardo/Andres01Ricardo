<?php
session_start();
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


$oItem=new Data('usuario',"idUsuario",$_SESSION['idUsuario']);
$usuario=$oItem->getDatos();
unset($oItem);

// $nombreImagen = "../../".$aEmpresa['logo'];
$nombreImagen = "../../".$aEmpresa['logo'];
$imagenBase64 = "data:image/png;base64," . base64_encode(file_get_contents($nombreImagen));


$nombreImagenS = "../../EMPRESA/smartbusssolutions.PNG";
$imagenBase64S = "data:image/png;base64," . base64_encode(file_get_contents($nombreImagenS));

$nombreImagenLink = "../../EMPRESA/linkaccountask.PNG";
$imagenBase64Link = "data:image/png;base64," . base64_encode(file_get_contents($nombreImagenLink));

$nombreImagenLinea = "../../EMPRESA/lineavertical.png";
$imagenBase64Linea = "data:image/png;base64," . base64_encode(file_get_contents($nombreImagenLinea));

?>

<html>
	<head>
		<meta charset="utf-8">
		 <meta charset="UTF-8">
		 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		

	</head>
	<body>
		<div class="card" id="muestra" >
			<div class="card-body">
			<table style="width: 95%;max-width: 95%" cellpadding="0">
			  <thead >
			    <tr >
			      <td style="text-align: center; " scope="col" rowspan="5"><img src="<?php echo $imagenBase64;?>" width="180" height="50" alt="image" > <img src="<?php echo $imagenBase64Linea;?>" height="30" alt="image" > <img src="<?php echo $imagenBase64S;?>" width="140" height="40" alt="image" ></td>
			      <!-- <td style="text-align: center; " scope="col" rowspan="5"></td> -->
			      <td style="text-align: center; " scope="col" rowspan="5"><span>                     </span></td>
			      <td style="text-align: right; "  style="font-size: 8px;text-decoration-color: #F7F7F7;"><?php echo $aCotizacionTotal['numeroCotizacion']; ?></td>
			    </tr>
			    <tr >
			      <td style="text-align: right;" style="font-size: 10px;"><?php echo $aEmpresa['email']; ?></td>
			    </tr>
			    <tr style="font-size: 10px;text-decoration-color:#F7F7F7;">
			      <td style="text-align: right;" ><?php echo $aEmpresa['telefono'].' '.$aEmpresa['direccion']; ?></td>
			    </tr>
			    <tr style="font-size: 10px;text-decoration-color: #F7F7F7;">
			      <td style="text-align: right;" ><?php echo 'Bucaramanga, Colombia'; ?></td>
			    </tr>
			    <tr >
			      <td style="text-align: right;" ><img src="<?php echo $imagenBase64Link;?>" height="20" alt="image" ></td>
			    </tr>
			  </thead>
			  <!-- <tbody> -->
			    


			   <!-- <tr style="text-align: center;"> -->
			      <!-- <th scope="row"></th> -->
			      <!-- <td><span></span></td>
			      <td><span></span></td>
			      <td><span></span></td> -->
			   	  <!-- <td  style="font-size: 12px;"> <?php echo $aEmpresa['email'] ?></td> -->
			   	  <!-- <td>NIT:  <?php echo $aEmpresa['nit'] ?></td> -->
			   	  <!-- <td>Fecha: <?php echo $aCotizacionTotal['fechaRegistro'] ?></td> -->
			    <!-- </tr> -->
			    <!-- <tr style="text-align: center;"> -->
			   	  <!-- <td scope="row" colspan="2"><span>Direccion:  <?php echo $aEmpresa['direccion'] ?> </span></td> -->
			   	  <!-- <td ><?php echo $aEmpresa['direccion'] ?></td> -->
			      <!-- <td></td> -->
			   	  <!-- <td>Fecha venc.: <?php echo $aCotizacionTotal['fechaVencimientoCotizacion'] ?></td> -->
			   	  <!-- <td><span></span></td>
			   	  <td><span></span></td>
			   	  <td><span></span></td>
			   	  <td><span></span></td>

			    </tr> -->
			   <!-- <tr style="text-align: center;">
			   		<td><span></span></td>
			   		<td><span></span></td>
			   		<td><span></span></td> -->
			   		<!-- <td><span></span></td> -->
			      <!-- <td scope="row"><span>Telefono: </span></td> -->
			   	  <!-- <td><?php echo $aEmpresa['telefono']; ?></td> -->
			      <!-- <td><span>Email: </span> <?php echo $aEmpresa['email'] ?></td> -->
			   	  <!-- <td><?php
			   	  	if($aEmpresa['responsableIva']==1){
			   	  		echo 'Responsable de IVA: SI';
			   	  	}

			   	   ?></td> -->
			   <!-- </tr> -->
			  <!-- </tbody> -->
		</table>

		<br><br>
		<hr>
		<table style="width: 90%;max-width: 90%">
			<tbody>
				<tr>
					<td><span>Sr.(es):
					<?php echo $aCliente['nombre'].' '.$aCliente['apellidos'];?></span></td>
					<td><span>Empresa:
					<?php echo $aCliente['empresa'];?></span></td>
					<td></td>
				</tr>
				<tr>
					<td><span>Direccion:
				<?php echo $aCliente['direccion'];?>
				</span></td>
					<td><span>Telefono:
				<?php echo $aCliente['telefono'];?></span></td>
					<td></td>
				</tr>
			</tbody>
		</table>
		<!-- <div class="row">
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
		</div> -->
		<hr>
		<br>
			<table class="table-striped" cellpadding="14" id="muestra" style="width: 95%;max-width: 95%;font-size: 85%">
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
		<br>
		<p style="text-align:justify;">Observaciones: <?php echo $aCotizacionTotal['observaciones'] ?></p>
		</div>
		<br>
		<br><br><br><br>
		<div class="card-footer">
			<!-- <hr color="black" size=1 style="width:30%; float: left;">  -->
			________________________________________<br>
			<?php echo $usuario["nombreUsuario"].' '.$usuario["apellidoUsuario"] ?><br>
			<?php echo $usuario["cargo"] ?><br>
			<?php echo $aEmpresa['razonSocial'] ?><br>
		</div>
		</div>
	</body>
</html>

<?php
use Dompdf\Dompdf;
use Dompdf\Options;
require_once "dompdf/autoload.inc.php";


// $pdf = new Dompdf(array('enable_remote' => true));
// $pdf->set_option('isRemoteEnabled', true);

$pdfOptions = new Options();
$pdfOptions->setIsRemoteEnabled(true);
$pdf = new Dompdf($pdfOptions);
// $options=new Options();
// $options->set('isRemoteEnabled', TRUE);
// $pdf = new Dompdf($options);
// $pdf->setBasePath('http://smartbuss.co');



$pdf->load_html(utf8_decode((utf8_encode(ob_get_clean()))));
$pdf->render();
$filename = "ejemplo.pdf";

$pdf->stream($filename,array("Attachment"=>0));
?>