#!/usr/bin/php

<?php


require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");

require_once("../../class/facturaventa.php"); 


date_default_timezone_set("America/Bogota"); 






$hoy = date("Y-m-d");



$eLista10 = new FacturaVenta();
$eolista10=$eLista10->getFacturaPendienteDiasMenosTreinta();

foreach ($eolista10 as $key => $factura10) {


	$dteStartV = new DateTime($factura10['fechaVencimiento']);
                $dteEndV   = new DateTime($hoy);
                $dteDiffV  = $dteStartV->diff($dteEndV);
             	$diasMoraV=$dteDiffV->format("%a");



    $cliente10 = new data("tercero","idTercero",$factura10["idCliente"]);
    $vDatos10=$cliente10->getDatos();

    $empresa10 = new data("empresa","idEmpresa",$factura10["idEmpresa"]);
    $emDatos10=$empresa10->getDatos(); 

    $mensajeRecurrente10 = "
<p>Estimados señores: ".$vDatos10["razonSocial"]."<br>

Asunto: PRIMER AVISO - NOTIFICACION DE MORA <br>

Nos ponemos en contacto con ustedes, dado que según nuestros datos, a la fecha de hoy, está pendiente el pago de la factura emitida por la empresa ".$emDatos10['razonSocial'].", la cual responde a la siguiente información:
<br>

Factura N°:             ".$factura10['nroFactura']."<br>
Fecha de emisión:       ".$factura10['fechaFactura']."<br>
Fecha de vencimiento:   ".$factura10['fechaVencimiento']."<br>
Valor a pagar:          $".$factura10['saldo']." <br>
Días de mora:           ".$diasMoraV."<br>


Solicitamos verificar con su departamento de contabilidad o con quien corresponda, el pago de dicha factura y el envío del soporte al correo electrónico registrado.  <br>

Si ya efectuó el pago favor ignorar el presente mensaje.<br><br><br>

Atte:<br><br>


Auxiliar Administrativo</p>

";
    $oControl=new Control();   
    $aEmail10["correo"]=$vDatos10['email']; 
    
    $aEmail10["asunto"]="Cobro de factura"; 

    $aEmail10["mensaje"]=$mensajeRecurrente10;

    $oControl->enviarCorreo($aEmail10);

    unset($oControl);

    $oControl=new Control();
    $bEmail10["correo"]="D.ARDILA@JURISCON.COM.CO"; 
    
    $bEmail10["asunto"]="Cobro de factura copia"; 

    $bEmail10["mensaje"]=$mensajeRecurrente10;

    $oControl->enviarCorreo($bEmail10);

    unset($oControl);

    $oControl=new Control();
    // $cEmail10["correo"]="J.PINTO@JURISCON.COM.CO"; 
    $cEmail10["correo"]="SISTEMAS@JURISCON.COM.CO"; 
    
    $cEmail10["asunto"]="Cobro de factura copia"; 

    $cEmail10["mensaje"]=$mensajeRecurrente10;

    $oControl->enviarCorreo($cEmail10);

    unset($oControl);


    $oControl=new Control();
    $dEmail10["correo"]=$emDatos10['email']; 
    
    $dEmail10["asunto"]="Cobro de factura copia"; 

    $dEmail10["mensaje"]=$mensajeRecurrente10;

    // $oControl->enviarCorreo($dEmail10);

    unset($oControl);

}




// $eLista11 = new Lista('factura_venta');

// $eLista11->setFiltro("estado","!=",3);
// $eLista11->setFiltro("datediff(curdate(),fechaVencimiento)","=",30);

// $eolista11=$eLista11->getLista();


$eLista11 = new FacturaVenta();
// $dias='30';
// $eolista11=$eLista11->getFacturaPendienteDias(30);
$eolista11=$eLista11->getFacturaPendienteDiasTreinta();






foreach ($eolista11 as $key => $factura11) {



				$dteStart = new DateTime($factura11['fechaVencimiento']);
                $dteEnd   = new DateTime($hoy);
                $dteDiff  = $dteStart->diff($dteEnd);
             	$diasMora=$dteDiff->format("%a");


    $cliente11 = new data("tercero","idTercero",$factura11["idCliente"]);
    $vDatos11=$cliente11->getDatos();

    $empresa11 = new data("empresa","idEmpresa",$factura11["idEmpresa"]);
    $emDatos11=$empresa11->getDatos(); 

    $mensajeRecurrente11 = "
<p>Estimados señores: ".$vDatos11["razonSocial"]."<br>

Asunto: SEGUNDO AVISO - NOTIFICACION DE MORA <br>

Nos ponemos en contacto con ustedes, dado que según nuestros datos, a la fecha de hoy, está pendiente el pago de la factura emitida por la empresa ".$emDatos11['razonSocial'].", la cual responde a la siguiente información: <br>

Factura N°:             ".$factura11['nroFactura']."<br>
Fecha de emisión:       ".$factura11['fechaFactura']."<br>
Fecha de vencimiento:   ".$factura11['fechaVencimiento']."<br>
Valor a pagar:          $".$factura11['saldo']." <br>
Días de mora:           ".$diasMora."<br>

Solicitamos verificar con su departamento de contabilidad o con quien corresponda, el pago de dicha factura y el envío del soporte al correo electrónico registrado. <br>

Si ya efectuó el pago favor ignorar el presente mensaje.<br><br><br>

Atte:<br><br>


Auxiliar Administrativo</p>

";
    
    $mensaje30 = "probando 30 dias";

    $recurrentep["fecha"]=date('Y-m-d H:i:s');
    $recurrentep["texto"]=$mensajeRecurrente11;


    $oItem=new Data("prueba_cronjob","idPruebaCronjob"); 
    foreach($recurrentep  as $keyr => $valuer){
        $oItem->$keyr=$valuer; 
    }
    $oItem->guardar(); 
    unset($oItem);


    $oControl=new Control();
    $aEmail11["correo"]="sistemas@JURISCON.COM.CO"; 
    // $aEmail11["correo"]=$emDatos11['email']; 
    
    $aEmail11["asunto"]="Cobro de factura"; 

    $aEmail11["mensaje"]=$mensajeRecurrente11;

    $oControl->enviarCorreo($aEmail11);

    unset($oControl);


    $oControl=new Control();
    $bEmail11["correo"]="D.ARDILA@JURISCON.COM.CO"; 
    
    $bEmail11["asunto"]="Cobro de factura copia"; 

    $bEmail11["mensaje"]=$mensajeRecurrente11;

    $oControl->enviarCorreo($bEmail11);

    unset($oControl);


    $oControl=new Control();
    $cEmail11["correo"]="J.PINTO@JURISCON.COM.CO"; 
    
    $cEmail11["asunto"]="Cobro de factura copia"; 

    $cEmail11["mensaje"]=$mensajeRecurrente11;

    // $oControl->enviarCorreo($cEmail11);

    unset($oControl);

    $oControl=new Control();
    $dEmail11["correo"]=$vDatos11['email']; 
    // $dEmail11["correo"]='RHERNANDEZ0123@GMAIL.COM'; 
        
    $dEmail11["asunto"]="Cobro de factura copia"; 

    $dEmail11["mensaje"]=$mensajeRecurrente11;

    $oControl->enviarCorreo($dEmail11);

    unset($oControl);
}



$eLista60 = new FacturaVenta();
$eolista60=$eLista60->getFacturaPendienteDias(60);
// $eolista11=$eLista11->getFacturaPendienteDiasTreinta();


foreach ($eolista60 as $key => $factura60) {


	$dteStart60 = new DateTime($factura60['fechaVencimiento']);
	$dteEnd60   = new DateTime($hoy);
	$dteDiff60  = $dteStart60->diff($dteEnd60);
	$diasMora60=$dteDiff60->format("%a");

    $cliente60 = new data("tercero","idTercero",$factura60["idCliente"]);
    $vDatos60=$cliente60->getDatos();

    $empresa60 = new data("empresa","idEmpresa",$factura60["idEmpresa"]);
    $emDatos60=$empresa60->getDatos(); 

    $mensajeRecurrente60 = "
<p>Estimados señores: ".$vDatos60["razonSocial"]."<br>

Asunto: COBRO PREJURIDICO <br>

Nos vemos obligados a ponernos en contacto con usted, dado el incumplimiento en el pago de la factura emitida por la empresa ".$emDatos60['razonSocial'].", la cual responde a la siguiente información:
<br>

Factura N°:             ".$factura60['nroFactura']."<br>
Fecha de emisión:       ".$factura60['fechaFactura']."<br>
Fecha de vencimiento:   ".$factura60['fechaVencimiento']."<br>
Valor a pagar:          $".$factura60['saldo']." <br>
Días de mora:           ".$diasMora60."<br>


En virtud de lo expuesto, lo requerimos para que, en un término no mayor a 5 días calendario, proceda con la cancelación del valor total de la obligación en mora. En el evento en que se haga caso omiso a la presente comunicación, le notificamos que iniciaremos el cobro correspondiente a través de la vía judicial, caso en el que deberá agregarse el valor que corresponde a costas procesales, agencias en derecho y honorarios jurídicos de abogado. <br><br>

Atte:<br><br>


Auxiliar Administrativo</p>

";
   $oControl=new Control();
    $aEmail60["correo"]=$vDatos60['email']; 
    
    $aEmail60["asunto"]="Cobro de factura"; 

    $aEmail60["mensaje"]=$mensajeRecurrente60;

	// $oControl->enviarCorreo($aEmail60);

    unset($oControl);


    $oControl=new Control();
    $bEmail60["correo"]="D.ARDILA@JURISCON.COM.CO"; 
    
    $bEmail60["asunto"]="Cobro de factura copia"; 

    $bEmail60["mensaje"]=$mensajeRecurrente60;

    // $oControl->enviarCorreo($bEmail60);

    unset($oControl);


    $oControl=new Control();
    // $cEmail60["correo"]="J.PINTO@JURISCON.COM.CO"; 
    $cEmail60["correo"]="SISTEMAS@JURISCON.COM.CO"; 
    
    $cEmail60["asunto"]="Cobro de factura copia"; 

    $cEmail60["mensaje"]=$mensajeRecurrente60;

    // $oControl->enviarCorreo($cEmail60);

    unset($oControl);

    $oControl=new Control();
    $dEmail60["correo"]=$emDatos60['email']; 
    
    
    $dEmail60["asunto"]="Cobro de factura copia"; 

    $dEmail60["mensaje"]=$mensajeRecurrente60;

    // $oControl->enviarCorreo($dEmail60);

    unset($oControl);

}



  ?>