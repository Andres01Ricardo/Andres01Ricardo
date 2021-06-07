<?php
ob_start();

require_once("../../php/restrict.php");

include_once("../../class/nomina.php"); 

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");




$id=$_GET['id'];
$URL=$_GET['url'];


$oNomina=new Nomina();



$aData["idNomina"]=$id;  

$aNomina=$oNomina->getNomina($aData)[0];

$meses[1]="Enero"; 

$meses[2]="Febrero"; 

$meses[3]="Marzo"; 

$meses[4]="Abril"; 

$meses[5]="Mayo"; 

$meses[6]="Junio"; 

$meses[7]="Julio"; 

$meses[8]="Agosto"; 

$meses[9]="Septiembre"; 

$meses[10]="Octubre"; 

$meses[11]="Noviembre"; 

$meses[12]="Diciembre"; 

$oLista=new Lista("nomina_empleado"); 

$oLista->setFiltro("idNomina","=",$id); 

$aLista=$oLista->getLista(); 

unset($oItem);


$oEmpresa=new Data("empresa","idEmpresa",$aNomina['idEmpresa']);
$aEmpresa=$oEmpresa->getDatos();
unset($oEmpresa);

?>

<html>
	<head>
		<meta charset="utf-8">
		 <meta charset="UTF-8">
		 <link rel="stylesheet" href="<?php echo $URL ?>assets/css/app.min.css" media="all">

  <!-- Template CSS -->

  <link rel="stylesheet" href="<?php echo $URL ?>assets/css/style.css" media="all">

  <link rel="stylesheet" href="<?php echo $URL ?>assets/css/estilo2.css" media="all">

  <link rel="stylesheet" href="<?php echo $URL ?>assets/css/components.css" media="all">

  <link rel="stylesheet" href="<?php echo $URL ?>assets/bundles/jqvmap/dist/jqvmap.min.css" media="all">

  <!-- Custom style CSS -->

  <link rel="stylesheet" href="<?php echo $URL ?>assets/css/custom.css" media="all">

  <link rel="stylesheet" href="<?php echo $URL ?>assets/css/estilo.css?<?php echo uniqid(); ?>" media="all">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap">

  <link rel="stylesheet" href="<?php echo $URL ?>assets/bundles/datatables/datatables.min.css" media="all">

  <link rel="stylesheet" href="<?php echo $URL ?>assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css" media="all">

  

  <link rel="stylesheet" href="<?php echo $URL; ?>assets/bundles/select2/dist/css/select2.min.css" media="all">

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" media="all">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->

	</head>
	<body>
		<div class="section-body" id="nominaEmpresa">
          
       		<?php foreach($aLista as $index=> $iLista){ 

                        $oItem=new Data("empleado","idEmpleado", $iLista["idEmpleado"]); 

                        $aEmpleado=$oItem->getDatos(); 

                        unset($oItem); 

                        $oItem=new Data("empleado_informacion_laboral","idEmpleado", $iLista["idEmpleado"]); 

                        $aEmpleadoInfo=$oItem->getDatos(); 

                        unset($oItem); 

                        $oLista=new Lista("nomina_empleado_adiciones"); 

                        $oLista->setFiltro("idNominaEmpleado","=",$iLista["idNominaEmpleado"]); 

                        $aAdiciones=$oLista->getLista(); 

                        unset($oItem);

                        $oLista=new Lista("nomina_empleado_parafiscales"); 

                        $oLista->setFiltro("idNominaEmpleado","=",$iLista["idNominaEmpleado"]); 

                        $oLista->setFiltro("tipoDeduccion","=",1); 

                        $aLeyes=$oLista->getLista(); 

                        unset($oItem);

                        $oLista=new Lista("nomina_empleado_deducciones"); 

                        $oLista->setFiltro("idNominaEmpleado","=",$iLista["idNominaEmpleado"]); 

                        $aDeducciones=$oLista->getLista(); 

                        unset($oItem);
                        $totalAdiciones=0;
                        foreach ($aAdiciones as $key => $valueA) {
                        	$totalAdiciones+=$valueA["valor"];
                        }
                        $totalDeducciones=0;
                        foreach ($aDeducciones as $key => $valueD) {
                        	$totalDeducciones+=$valueD["valor"];
                        }
                        $diasTrabajados=((100*$aLeyes[0]["valor"])/(4*$iLista["salarioEmpleado"]))*30;
                        $diasTrabajados=ceil($diasTrabajados);
                        ?>
            <div  style="height: 50%">
	            <!-- <div class="col-md-12 col-lg-12"> -->
	              <div class="card border border-primary">
			                <div class="card-body" >
			                  <table class=" mayusculas" style="width: 100%;text-align: center;border-color: #81BCFF;border-style: 4px solid;" cellpadding="8" >
			                  	<thead><tr>
			                  			<th rowspan="2" style="width: 20%;"><img class="logo" width="100" src="<?php echo $URL.$aEmpresa['logo'];?>" ></th>
			                  			<th colspan="4"><?php echo $aEmpresa["razonSocial"];?></th>
			                  			<th>comprobante No.</th></tr>
			                  		<tr>	<th colspan="4"><?php echo $aEmpresa["nit"];?></th>
			                  			<th># nomina</th></tr>
			                  	</thead>
			                  	<tbody class="table-bordered">
			                  		<tr class="negrita">
			                  			<td>Identificación</td>
			                  			<td colspan="3">Nombres y apellidos</td>
			                  			<td>Sueldo basico</td>
			                  			<td>Auxilio transporte</td>
			                  		</tr>
			                  		<tr>
			                  			<td><?php echo $aEmpleado["numeroDocumento"]; ?></td>
			                  			<td colspan="3"><?php echo $aEmpleado["nombre"]." ".$aEmpleado["apellido"]; ?></td>
			                  			<td><?php echo "$".number_format(($iLista["salarioEmpleado"]),2,",","."); ?></td>
			                  			<td><?php echo "$".number_format($iLista["auxilioTransporte"],2,",","."); ?></td>
			                  		</tr>
			                  		<tr>
			                  			<td colspan="3">Desprendible de pago: </td>
			                  			<td colspan="3"><?php echo $meses[$aNomina["periodoMes"]]." de ".$aNomina["periodoAnio"]; ?></td>
			                  		</tr>
			                  		<tr>     <td colspan="6"></td> </tr>
			                  		<tr class="negrita">
			                  			<td colspan="2">DESCRIPCIÓN CONCEPTO</td>
			                  			<td >CANTIDAD</td>
			                  			<td>DEVENGADO</td>
			                  			<td>DEDUCIDO </td>
			                  			<td>SALDO</td>
			                  		</tr><?php $saldo=0;
			                  		$devengados=0;
			                  		$deducidos=0; ?>
			                  		<tr>
			                  			<td colspan="2">SUELDO BASICO</td>
			                  			<td ><?php echo $diasTrabajados; ?></td><?php $salarioDevengado=($iLista["salarioEmpleado"]/30)*$diasTrabajados; ?>
			                  			<td><?php echo "$".number_format($salarioDevengado,2,",","."); ?></td>
			                  			<td>-</td>
			                  			<td><?php echo "$".number_format($salarioDevengado,2,",","."); ?></td>
			                  		</tr><?php $saldo=$saldo+$salarioDevengado;
			                  		$devengados+=$salarioDevengado;	?>
			                  		<tr>
			                  			<td colspan="2">AUXILIO TRANSPORTE</td>
			                  			<td ><?php echo $diasTrabajados; ?></td><?php $auxilioDevengado=($iLista["auxilioTransporte"]/30)*$diasTrabajados; ?>
			                  			<td><?php echo "$".number_format($auxilioDevengado,2,",","."); ?></td>
			                  			<td>-</td><?php $saldo=$saldo+$auxilioDevengado;
			                  			$devengados+=$auxilioDevengado;
			                  			?>
			                  			<td><?php echo "$".number_format($saldo,2,",","."); ?></td>
			                  		</tr>
			                  		<?php foreach($aAdiciones as $index=> $iAdicion){?>

			                  			<tr>
			                  			<td colspan="2"><?php echo $iAdicion["concepto"]; ?></td>
			                  			<td ><?php echo $diasTrabajados; ?></td>
			                  			<td><?php echo "$".number_format($iAdicion["valor"],2,",","."); ?></td>
			                  			<td>-</td><?php $saldo=$saldo+$iAdicion["valor"];
			                  			$devengados+=$iAdicion["valor"]; ?>
			                  			<td><?php echo "$".number_format($saldo,2,",","."); ?></td>
			                  		</tr>
			                  		<?php }?>
			                  		<?php foreach($aDeducciones as $index=> $iDeduccion){?>

			                  			<tr>
			                  			<td colspan="2"><?php echo $iDeduccion["concepto"]; ?></td>
			                  			<td ><?php echo $diasTrabajados; ?></td>
			                  			<td>-</td><?php $saldo=$saldo-$iDeduccion["valor"];
			                  			$deducidos+=$iDeduccion["valor"]; ?>
			                  			<td><?php echo "$".number_format($iDeduccion["valor"],2,",","."); ?></td>
			                  			<td><?php echo "$".number_format($saldo,2,",","."); ?></td>
			                  		</tr>
			                  		<?php }?>
			                  		<?php foreach($aLeyes as $index=> $Ley){?>
			                  			<tr>
			                  			<td colspan="2"><?php echo $Ley["concepto"]; ?></td>
			                  			<td><?php echo $diasTrabajados; ?></td>
			                  			<td>-</td><?php $saldo=$saldo-$Ley["valor"];
			                  			$deducidos+=$Ley["valor"]; ?>
			                  			<td><?php echo "$".number_format($Ley["valor"],2,",","."); ?></td>
			                  			<td><?php echo "$".number_format($saldo,2,",","."); ?></td>
			                  		</tr>
			                  		<?php }?>
			                  		<tr>
			                  			<td colspan="6"></td>
			                  		</tr>
			                  		<tr>
			                  			<td colspan="2" style="text-align: left;">FIRMA</td>
			                  			<td>TOTALES:</td>
			                  			<td><?php echo "$".number_format($devengados,2,",","."); ?></td>
			                  			<td><?php echo "$".number_format($deducidos,2,",","."); ?></td>
			                  			<td></td>
			                  		</tr>
			                  		<tr>
			                  			<td colspan="6"></td>
			                  		</tr>
			                  		<tr>
			                  			<td colspan="2">NETO A PAGAR:</td>
			                  			<td colspan="3"></td>
			                  			<td><?php echo "$".number_format($saldo,2,",","."); ?></td>
			                  		</tr>
			                  	</tbody>
			                  </table>
			              </div>
			          </div>
			      <!-- </div> -->
			  </div>
			<?php } ?>
			</div>
		</section>
	
	</body>
	
</html>

<?php

require_once ("https://smartbuss.co/assets/bundles/dompdf/autoload.inc.php");
// require_once ('https://smartbuss.co/assets/bundles/dompdf/dompdf_config.inc.php');

use Dompdf\Dompdf;

$pdf = new Dompdf(array('enable_remote' => true));

$pdf->load_html(utf8_decode(ob_get_clean()));
$pdf->render();
$filename = "ejemplo.pdf";

$pdf->stream($filename,array("Attachment"=>0));
?>



	

