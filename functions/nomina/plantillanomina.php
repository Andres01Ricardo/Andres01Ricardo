


  <?php function getPlatilla($id,$URL){
	$platilla='<?php

require_once("../../php/restrict.php");

require_once("../../class/nomina.php"); 

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");



$oControl=new Control(); 


$id=$id;
$URL=$URL;

$oNomina=new Nomina();



$aData["idNomina"]=$id;  

$aNomina=$oNomina->getNomina($aData)[0];



$oLista=new Lista("nomina_empleado"); 

$oLista->setFiltro("idNomina","=",$id); 

$aLista=$oLista->getLista(); 

unset($oItem);



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



$aFiltroS["idNomina"]=$id; 

$aFiltroS["tipoConcepto"]=1; 

$aSaludEmpresa=$oNomina->getTotalParafiscales($aFiltroS);



$saludEmpleado=0; 

$saludEmpleador=0; 

foreach($aSaludEmpresa as $iSalud){

  if($iSalud["tipoDeduccion"]==1){

    $saludEmpleado+=$iSalud["valor"]; 

  }else{

    $saludEmpleador+=$iSalud["valor"];

  }

}

$aFiltroP["idNomina"]=$id; 

$aFiltroP["tipoConcepto"]=2; 

$aPensionEmpresa=$oNomina->getTotalParafiscales($aFiltroP);



$pensionEmpleado=0; 

$pensionEmpleador=0; 

foreach($aPensionEmpresa as $iPension){

  if($iPension["tipoDeduccion"]==1){

    $pensionEmpleado+=$iPension["valor"]; 

  }else{

    $pensionEmpleador+=$iPension["valor"];

  }

}



$aFiltroA["idNomina"]=$id; 

$aFiltroA["tipoConcepto"]=3; 

$aFiltroA["tipoDeduccion"]=2; 

$aArlEmpresa=$oNomina->getTotalParafiscales($aFiltroA)[0];



$aFiltroC["idNomina"]=$id; 

$aFiltroC["tipoConcepto"]=4; 

$aFiltroC["tipoDeduccion"]=2; 

$aCajaEmpresa=$oNomina->getTotalParafiscales($aFiltroC)[0];



$valorNomina=0; 

foreach($aLista as $index=> $iLista){

  $valorNomina+=$iLista["valorPagar"]; 

}



$oEmpresa=new Data("empresa","idEmpresa",$aNomina["idEmpresa"]);
$aEmpresa=$oEmpresa->getDatos();
unset($oEmpresa);



?><body>


        <div class="section-body" id="nominaEmpresa" style="font-size: 50%;">

          <div class="row">

            <div class="col-md-12 col-lg-12">

              <div class="card table-responsive">

                <div class="card-header">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col"><input type="hidden" class="form-control mayusculas" value="<?php echo $URL.$aEmpresa["logo"]; ?>" required readonly>        
                        <img width="80" height="80" alt="image" src="<?php echo $URL.$aEmpresa["logo"]; ?>" ></th>
                        
                        <th scope="col"><h4><?php echo $aNomina["razonSocial"]; ?></h4></th>
                        
                        <th scope="col">Periodo pago: <?php echo $meses[$aNomina["periodoMes"]]." de ".$aNomina["periodoAnio"]; ?></th>
                      </tr>
                    </thead>
                  </table>
                </div>

                <div class="card-body">

                  <?php if($aNomina["linkPlanilla"]!=""){ ?>

                  <div class="row">

                    <div class="col-md-3">

                      <div class="form-group">

                        <label class="negrita">Ver Link Planilla:</label>

                        <a href="<?php echo $aNomina["linkPlanilla"]; ?>" style="display:block;" target="_blank">LINK</a>

                      </div>

                    </div>

                  </div>

                  <?php } ?>

                  <div class="card-header">

                    <h4>Pago Seguridad Social Empleador</h4>

                  </div>
                  <table class="table table-bordered">
                  	<tbody>
                  		<tr>
                  			<td>Total Pago Salud: <?php echo "$".number_format($saludEmpleador,0,".",","); ?></td>
                  			<td>Total Pago Pensión: <?php echo "$".number_format($pensionEmpleador,0,".",","); ?>:</td><
                  			<td>Total Pago ARL: <?php echo "$".number_format($aCajaEmpresa["valor"],0,".",","); ?></td>
                  			<td>Total Pago Caja Compensación: <?php echo "$".number_format($aCajaEmpresa["valor"],0,".",","); ?></td>
                  		</tr>
                  	</tbody>
                  </table>

                


                  <div class="card-header">

                    <h4>Pago Seguridad Social Empleados</h4>

                  </div>
                  <table class="table table-bordered">
                  	<tbody>
                  		<tr>
                  			<td>Total Pago Salud: <?php echo "$".number_format($saludEmpleado,0,".",","); ?></td>
                  			<td>Total Pago Pensión: <?php echo "$".number_format($pensionEmpleado,0,".",","); ?></td><
                  			
                  		</tr>
                  	</tbody>
                  </table>

                  <div class="card-header">

                    <h4>Nomina General</h4>

                  </div>

                  <?php 

                  $saludGeneral=$saludEmpleador+$saludEmpleado; 

                  $pensionGeneral=$pensionEmpleador+$pensionEmpleado; 



                  $totalNomina=$saludGeneral+$pensionGeneral+$aCajaEmpresa["valor"]+$aArlEmpresa["valor"]+$valorNomina; 

                  ?>
                  <table class="table table-bordered">
                  	<tbody>
                  		<tr>
                  			<td>Total Pago Salud Nomina: <?php echo "$".number_format($saludGeneral,0,".",","); ?></td>
                  			<td>Total Pago Pensión Nomina: <?php echo "$".number_format($pensionGeneral,0,".",","); ?></td>
                  			<td>Total Pago ARL Nomina: <?php echo "$".number_format($aArlEmpresa["valor"],0,".",","); ?> ?></td>
                  			<td>Total Pago Caja Compensación Nomina: <?php echo "$".number_format($aCajaEmpresa["valor"],0,".",","); ?></td>
                  			
                  		</tr>
                  		<tr>
                  			<td></td>
                  			<td></td>
                  			<td></td>
                  			<td>Total Nomina: <?php echo "$".number_format($totalNomina,0,".",","); ?></td>
                  		</tr>
                  	</tbody>
                  </table>
                  


                  </div>

                  <div class="card-header">

                    <h4>Detalles </h4>

                  </div>

                  <div class="card-body">

                   <div id="accordion-header">

                      <?php foreach($aLista as $index=> $iLista){ 

                        $oItem=new Data("empleado","idEmpleado", $iLista["idEmpleado"]); 

                        $aEmpleado=$oItem->getDatos(); 

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

                        ?>

                      <div class="accordion">

                          <h4><?php echo $aEmpleado["numeroDocumento"]." - ".$aEmpleado["nombre"]." ".$aEmpleado["apellido"]; ?></h4>



                        <div class="accordion-body " id="<?php echo $index; ?>" >

                          <table class="table table-striped mayusculas">

                            <tbody>

                              <tr>

                                <td>Salario:</td>

                                <td><?php echo "$".number_format($iLista["salarioEmpleado"],0,".",","); ?></td>

                                <td>Valor a Pagar:</td>

                                <td class="negrita"><?php echo "$".number_format($iLista["valorPagar"],0,".",","); ?></td>

                              </tr>

                            </tbody>

                          </table>

                          <?php if(count($aAdiciones)>0){ ?>

                          <p class="negrita">Devengado</p>

                          <table class="table table-striped mayusculas">

                            <thead>

                              <tr>

                                <th class="tddashboard" style="width: 40%">Concepto</th>

                                <th class="tddashboard" style="width: 10%">Valor</th>

                                <th class="tddashboard" style="width: 40%">Concepto</th>

                                <th class="tddashboard" style="width: 10%">Valor</th>

                              </tr>

                            </thead>

                            <tbody>

                              <?php $i=0;  foreach($aAdiciones as $indexA=>$iAdiciones){ ?>

                                <?php if($i==0){  ?>

                                <tr>

                                <?php } ?>

                                <td class="tddashboard" style="width: 40%"><?php echo $iAdiciones["concepto"]; ?></td>

                                <td class="tddashboard" style="width: 10%"><?php echo "$".number_format($iAdiciones["valor"],0,".",","); ?></td>

                                <?php $i++; if($i==2||count($aAdiciones)==($indexA+1)){ $i=0;  ?>

                                </tr>

                                <?php } ?>

                              <?php } ?>

                            </tbody>

                          </table>

                          <?php } ?>

                          <?php if(count($aLeyes)>0){ ?>

                          <p class="negrita">Deducciones de ley</p>

                          <table class="table table-striped mayusculas">

                            <thead>

                              <tr>

                                <th class="tddashboard" style="width: 40%">Concepto</th>

                                <th class="tddashboard" style="width: 10%">Valor</th>

                                <th class="tddashboard" style="width: 40%">Concepto</th>

                                <th class="tddashboard" style="width: 10%">Valor</th>

                              </tr>

                            </thead>

                            <tbody>

                              <?php $i=0;  foreach($aLeyes as $indexA=>$iDeduccion){ ?>

                                <?php if($i==0){  ?>

                                <tr>

                                <?php } ?>

                                <td class="tddashboard" style="width: 40%"><?php echo $iDeduccion["concepto"]; ?></td>

                                <td class="tddashboard" style="width: 10%"><?php echo "$".number_format($iDeduccion["valor"],0,".",","); ?></td>

                                <?php $i++; if($i==2||count($aLeyes)==($indexA+1)){ $i=0;  ?>

                                </tr>

                                <?php } ?>

                              <?php } ?>

                            </tbody>

                          </table>

                          <?php } ?>

                          <?php if(count($aDeducciones)>0){ ?>

                          <p class="negrita">Otras Deducciones</p>

                          <table class="table table-striped mayusculas">

                            <thead>

                              <tr>

                                <th class="tddashboard" style="width: 40%">Concepto</th>

                                <th class="tddashboard" style="width: 10%">Valor</th>

                                <th class="tddashboard" style="width: 40%">Concepto</th>

                                <th class="tddashboard" style="width: 10%">Valor</th>

                              </tr>

                            </thead>

                            <tbody>

                              <?php $i=0;  foreach($aDeducciones as $indexA=>$iDeduccion){ ?>

                                <?php if($i==0){  ?>

                                <tr>

                                <?php } ?>

                                <td class="tddashboard" style="width: 40%"><?php echo $iDeduccion["concepto"]; ?></td>

                                <td class="tddashboard" style="width: 10%"><?php echo "$".number_format($iDeduccion["valor"],0,".",","); ?></td>

                                <?php $i++; if($i==2||count($iDeduccion)==($indexA+1)){ $i=0;  ?>

                                </tr>

                                <?php } ?>

                              <?php } ?>

                            </tbody>

                          </table>

                          <?php } ?>

                        </div>

                      </div>

                      <?php } ?>

                    </div>

                  </div>

                  

                </div>

            </div>

        </div>

    </div>

	</body>';

  return $platilla;


}