#!/usr/bin/php

<?php


require_once("../../php/restrict.php");

include_once($CLASS . "data.php");

include_once($CLASS . "lista.php");

include_once($CLASS . "control.php");


date_default_timezone_set("America/Bogota"); 

$oControl=new Control();




$hoy = date("Y-m-d");

$cLista = new Lista('factura_venta');

$cLista->setFiltro("estado","!=",3);
$cLista->setFiltro("fechaVencimiento","=",$hoy);

$colista=$cLista->getLista();


foreach ($colista as $key => $factura) {
    $oControl=new Control();
    echo $factura["idCliente"];
    $cliente = new data("cliente","idCliente",$factura["idCliente"]);

    $cDatos=$cliente->getDatos(); 

    $empresa = new data("empresa","idEmpresa",$factura["idEmpresa"]);
    $emDatos=$empresa->getDatos(); 

    $mensaje="<p>Estimados señores: ".$cDatos["razonSocial"]."<br>

Hoy vence su factura de compra-venta emitida por la empresa ".$emDatos['razonSocial'].", la cual tiene las siguientes referencias:<br>

Factura N°:             ".$factura['nroFactura']."<br>
Fecha de emisión:       ".$factura['fechaFactura']."<br>
Fecha de vencimiento:   ".$factura['fechaVencimiento']."<br>
Valor a pagar:          $".$factura['total']." <br>
<br>
Agradeceremos enormemente su cumplimiento. Si ya efectuó el pago favor ignorar el presente mensaje.<br><br>
<br>
Atte:<br><br>



Auxiliar Administrativo</p>
";
   

    $aEmail["correo"]=$cDatos['email'];
    

    $aEmail["asunto"]="Factura vencimiento hoy"; 

    $aEmail["mensaje"]=$mensaje;

    $oControl->enviarCorreo($aEmail);

    unset($oControl);

    $bEmail["correo"]="D.ARDILA@JURISCON.COM.CO";
    

    $bEmail["asunto"]="Factura vencimiento hoy copia"; 

    $bEmail["mensaje"]=$mensaje;

    $oControl->enviarCorreo($bEmail);

    unset($oControl);
    

    $cEmail["correo"]="J.PINTO@JURISCON.COM.CO";
    

    $cEmail["asunto"]="Factura vencimiento hoy copia"; 

    $cEmail["mensaje"]=$mensaje;

    $oControl->enviarCorreo($cEmail);

    unset($oControl);

    $dEmail["correo"]=$emDatos['email'];
    

    $dEmail["asunto"]="Factura vencimiento hoy copia"; 

    $dEmail["mensaje"]=$mensaje;

    $oControl->enviarCorreo($dEmail);

    unset($oControl);
}



$eLista = new Lista('factura_venta');

$eLista->setFiltro("estado","!=",3);
$eLista->setFiltro("datediff(curdate(),fechaVencimiento)","=",3);

$eolista=$eLista->getLista();

foreach ($eolista as $key => $facturae) {
    $oControl=new Control();
    $ecliente = new data("cliente","idCliente",$facturae["idCliente"]);
    $eDatos=$ecliente->getDatos();
    

    $empresa2 = new data("empresa","idEmpresa",$facturae["idEmpresa"]);
    $emDatos2=$empresa2->getDatos(); 

    $mensajeRecurrente = "
<p>Estimados señores: ".$eDatos["razonSocial"]."<br>

Nos ponemos en contacto con Ustedes porque según nuestros datos, a fecha de hoy, está pendiente de pago de su factura  de compra-venta emitida por la empresa ".$emDatos2['razonSocial'].", la cual tiene las siguientes referencias:<br>

Factura N°:             ".$facturae['nroFactura']."<br>
Fecha de emisión:       ".$facturae['fechaFactura']."<br>
Fecha de vencimiento:   ".$facturae['fechaVencimiento']."<br>
Valor a pagar:          $".$facturae['total']." <br>

Como es habitual, en su día les remitimos las facturas vía correo electrónico.
Rogamos verifiquen con su departamento de contabilidad el trámite de pago de dicha factura, y procedan de inmediato con la misma <br>

Agradecemos enormemente su cumplimiento. Si ya efectuó el pago favor ignorar el presente mensaje.<br><br><br>

Atte:<br><br>


Auxiliar Administrativo</p>

";
   
    $aEmail2["correo"]=$eDatos['email']; 
    
    
    $aEmail2["asunto"]="Cobro de factura"; 

    $aEmail2["mensaje"]=$mensajeRecurrente;

    $oControl->enviarCorreo($aEmail2);

    unset($oControl);

    $bEmail2["correo"]="D.ARDILA@JURISCON.COM.CO"; 
    
    
    $bEmail2["asunto"]="Cobro de factura copia"; 

    $bEmail2["mensaje"]=$mensajeRecurrente;

    $oControl->enviarCorreo($bEmail2);

    unset($oControl);
    $cEmail2["correo"]="J.PINTO@JURISCON.COM.CO"; 
    
    
    $cEmail2["asunto"]="Cobro de factura copia"; 

    $cEmail2["mensaje"]=$mensajeRecurrente;

    $oControl->enviarCorreo($cEmail2);

    unset($oControl);


    $dEmail2["correo"]=$emDatos2['email']; 
    
    
    $dEmail2["asunto"]="Cobro de factura copia"; 

    $dEmail2["mensaje"]=$mensajeRecurrente;

    $oControl->enviarCorreo($dEmail2);

    unset($oControl);

}


$eLista3 = new Lista('factura_venta');

$eLista3->setFiltro("estado","!=",3);
$eLista3->setFiltro("datediff(curdate(),fechaVencimiento)","=",6);

$eolista3=$eLista3->getLista();

foreach ($eolista3 as $key => $factura3) {
    $clientev = new data("cliente","idCliente",$factura3["idCliente"]);
    $vDatos=$clientev->getDatos();

    $empresa3 = new data("empresa","idEmpresa",$factura3["idEmpresa"]);
    $emDatos3=$empresa3->getDatos(); 

    $mensajeRecurrente3 = "
<p>Estimados señores: ".$vDatos["razonSocial"]."<br>

Nos ponemos en contacto con Ustedes porque según nuestros datos, a fecha de hoy, está pendiente de pago de su factura  de compra-venta emitida por la empresa ".$emDatos3['razonSocial'].", la cual tiene las siguientes referencias:<br>

Factura N°:             ".$factura3['nroFactura']."<br>
Fecha de emisión:       ".$factura3['fechaFactura']."<br>
Fecha de vencimiento:   ".$factura3['fechaVencimiento']."<br>
Valor a pagar:          $".$factura3['total']." <br>

Como es habitual, en su día les remitimos las facturas vía correo electrónico.
Rogamos verifiquen con su departamento de contabilidad el trámite de pago de dicha factura, y procedan de inmediato con la misma <br>

Agradecemos enormemente su cumplimiento. Si ya efectuó el pago favor ignorar el presente mensaje.<br><br><br>

Atte:<br><br>


Auxiliar Administrativo</p>

";
   
    $aEmail3["correo"]=$vDatos['email']; 

    $aEmail3["asunto"]="Cobro de factura"; 

    $aEmail3["mensaje"]=$mensajeRecurrente3;

    $oControl->enviarCorreo($aEmail3);

    unset($oControl);


    $bEmail3["correo"]="D.ARDILA@JURISCON.COM.CO"; 

    $bEmail3["asunto"]="Cobro de factura copia"; 

    $bEmail3["mensaje"]=$mensajeRecurrente3;

    $oControl->enviarCorreo($bEmail3);

    unset($oControl);

    $cEmail3["correo"]="J.PINTO@JURISCON.COM.CO"; 

    $cEmail3["asunto"]="Cobro de factura copia"; 

    $cEmail3["mensaje"]=$mensajeRecurrente3;

    $oControl->enviarCorreo($cEmail3);

    unset($oControl);

    $dEmail3["correo"]=$emDatos3['email']; 
    
    
    $dEmail3["asunto"]="Cobro de factura copia"; 

    $dEmail3["mensaje"]=$mensajeRecurrente3;

    $oControl->enviarCorreo($dEmail3);

    unset($oControl);

}



$eLista4 = new Lista('factura_venta');

$eLista4->setFiltro("estado","!=",3);
$eLista4->setFiltro("datediff(curdate(),fechaVencimiento)","=",9);

$eolista4=$eLista4->getLista();

foreach ($eolista4 as $key => $factura4) {
    $cliente4 = new data("cliente","idCliente",$factura4["idCliente"]);
    $vDatos4=$cliente4->getDatos();
    
    $empresa4 = new data("empresa","idEmpresa",$factura4["idEmpresa"]);
    $emDatos4=$empresa4->getDatos(); 

    $mensajeRecurrente4 = "
<p>Estimados señores: ".$vDato4["razonSocial"]."<br>

Nos ponemos en contacto con Ustedes porque según nuestros datos, a fecha de hoy, está pendiente de pago de su factura  de compra-venta emitida por la empresa ".$emDatos4['razonSocial'].", la cual tiene las siguientes referencias:<br>

Factura N°:             ".$factura4['nroFactura']."<br>
Fecha de emisión:       ".$factura4['fechaFactura']."<br>
Fecha de vencimiento:   ".$factura4['fechaVencimiento']."<br>
Valor a pagar:          $".$factura4['total']." <br>

Como es habitual, en su día les remitimos las facturas vía correo electrónico.
Rogamos verifiquen con su departamento de contabilidad el trámite de pago de dicha factura, y procedan de inmediato con la misma <br>

Agradecemos enormemente su cumplimiento. Si ya efectuó el pago favor ignorar el presente mensaje.<br><br><br>

Atte:<br><br>


Auxiliar Administrativo</p>

";
   
    $aEmail4["correo"]=$vDatos4['email']; 
    
    $aEmail4["asunto"]="Cobro de factura"; 

    $aEmail4["mensaje"]=$mensajeRecurrente4;

    $oControl->enviarCorreo($aEmail4);

    unset($oControl);

    $bEmail4["correo"]="D.ARDILA@JURISCON.COM.CO"; 
    
    $bEmail4["asunto"]="Cobro de factura copia"; 

    $bEmail4["mensaje"]=$mensajeRecurrente4;

    $oControl->enviarCorreo($bEmail4);

    unset($oControl);
    $cEmail4["correo"]="J.PINTO@JURISCON.COM.CO"; 
    
    $cEmail4["asunto"]="Cobro de factura copia"; 

    $cEmail4["mensaje"]=$mensajeRecurrente4;

    $oControl->enviarCorreo($cEmail4);

    unset($oControl);


    $dEmail4["correo"]=$emDatos4['email']; 
    
    
    $dEmail4["asunto"]="Cobro de factura copia"; 

    $dEmail4["mensaje"]=$mensajeRecurrente4;

    $oControl->enviarCorreo($dEmail4);

    unset($oControl);

}


$eLista5 = new Lista('factura_venta');

$eLista5->setFiltro("estado","!=",3);
$eLista5->setFiltro("datediff(curdate(),fechaVencimiento)","=",12);

$eolista5=$eLista5->getLista();

foreach ($eolista5 as $key => $factura5) {
    $cliente5 = new data("cliente","idCliente",$factura5["idCliente"]);
    $vDatos5=$cliente5->getDatos();

    $empresa5 = new data("empresa","idEmpresa",$factura5["idEmpresa"]);
    $emDatos5=$empresa5->getDatos(); 

    $mensajeRecurrente5 = "
<p>Estimados señores: ".$vDato5["razonSocial"]."<br>

Nos ponemos en contacto con Ustedes porque según nuestros datos, a fecha de hoy, está pendiente de pago de su factura  de compra-venta emitida por la empresa ".$emDatos5['razonSocial'].", la cual tiene las siguientes referencias:<br>

Factura N°:             ".$factura5['nroFactura']."<br>
Fecha de emisión:       ".$factura5['fechaFactura']."<br>
Fecha de vencimiento:   ".$factura5['fechaVencimiento']."<br>
Valor a pagar:          $".$factura5['total']." <br>

Como es habitual, en su día les remitimos las facturas vía correo electrónico.
Rogamos verifiquen con su departamento de contabilidad el trámite de pago de dicha factura, y procedan de inmediato con la misma <br>

Agradecemos enormemente su cumplimiento. Si ya efectuó el pago favor ignorar el presente mensaje.<br><br><br>

Atte:<br><br>


Auxiliar Administrativo</p>

";
   
    $aEmail5["correo"]=$vDatos5['email']; 
    
    $aEmail5["asunto"]="Cobro de factura"; 

    $aEmail5["mensaje"]=$mensajeRecurrente5;

    $oControl->enviarCorreo($aEmail5);

    unset($oControl);


    $bEmail5["correo"]="D.ARDILA@JURISCON.COM.CO"; 
    
    $bEmail5["asunto"]="Cobro de factura copia"; 

    $bEmail5["mensaje"]=$mensajeRecurrente5;

    $oControl->enviarCorreo($bEmail5);

    unset($oControl);
    $cEmail5["correo"]="J.PINTO@JURISCON.COM.CO"; 
    
    $cEmail5["asunto"]="Cobro de factura copia"; 

    $cEmail5["mensaje"]=$mensajeRecurrente5;

    $oControl->enviarCorreo($cEmail5);

    unset($oControl);


    $dEmail5["correo"]=$emDatos5['email']; 
    
    
    $dEmail5["asunto"]="Cobro de factura copia"; 

    $dEmail5["mensaje"]=$mensajeRecurrente5;

    $oControl->enviarCorreo($dEmail5);

    unset($oControl);

}


$eLista6 = new Lista('factura_venta');

$eLista6->setFiltro("estado","!=",3);
$eLista6->setFiltro("datediff(curdate(),fechaVencimiento)","=",15);

$eolista6=$eLista6->getLista();

foreach ($eolista6 as $key => $factura6) {
    $cliente6 = new data("cliente","idCliente",$factura6["idCliente"]);
    $vDatos6=$cliente6->getDatos();

    $empresa6 = new data("empresa","idEmpresa",$factura6["idEmpresa"]);
    $emDatos6=$empresa6->getDatos(); 

    $mensajeRecurrente6 = "
<p>Estimados señores: ".$vDato6["razonSocial"]."<br>

Nos ponemos en contacto con Ustedes porque según nuestros datos, a fecha de hoy, está pendiente de pago de su factura  de compra-venta emitida por la empresa ".$emDatos6['razonSocial'].", la cual tiene las siguientes referencias:<br>

Factura N°:             ".$factura6['nroFactura']."<br>
Fecha de emisión:       ".$factura6['fechaFactura']."<br>
Fecha de vencimiento:   ".$factura6['fechaVencimiento']."<br>
Valor a pagar:          $".$factura6['total']." <br>

Como es habitual, en su día les remitimos las facturas vía correo electrónico.
Rogamos verifiquen con su departamento de contabilidad el trámite de pago de dicha factura, y procedan de inmediato con la misma <br>

Agradecemos enormemente su cumplimiento. Si ya efectuó el pago favor ignorar el presente mensaje.<br><br><br>

Atte:<br><br>


Auxiliar Administrativo</p>

";
   
    $aEmail6["correo"]=$vDatos6['email']; 
    
    $aEmail6["asunto"]="Cobro de factura"; 

    $aEmail6["mensaje"]=$mensajeRecurrente6;

    $oControl->enviarCorreo($aEmail6);

    unset($oControl);

    $bEmail6["correo"]="D.ARDILA@JURISCON.COM.CO"; 
    
    $bEmail6["asunto"]="Cobro de factura copia"; 

    $bEmail6["mensaje"]=$mensajeRecurrente6;

    $oControl->enviarCorreo($bEmail6);

    unset($oControl);
    $cEmail6["correo"]="J.PINTO@JURISCON.COM.CO"; 
    
    $cEmail6["asunto"]="Cobro de factura copia"; 

    $cEmail6["mensaje"]=$mensajeRecurrente6;

    $oControl->enviarCorreo($cEmail6);

    unset($oControl);


    $dEmail6["correo"]=$emDatos6['email']; 
    
    
    $dEmail6["asunto"]="Cobro de factura copia"; 

    $dEmail6["mensaje"]=$mensajeRecurrente6;

    $oControl->enviarCorreo($dEmail6);

    unset($oControl);

}


$eLista7 = new Lista('factura_venta');

$eLista7->setFiltro("estado","!=",3);
$eLista7->setFiltro("datediff(curdate(),fechaVencimiento)","=",18);

$eolista7=$eLista7->getLista();

foreach ($eolista7 as $key => $factura7) {
    $cliente7 = new data("cliente","idCliente",$factura7["idCliente"]);
    $vDatos7=$cliente7->getDatos();

    $empresa7 = new data("empresa","idEmpresa",$factura7["idEmpresa"]);
    $emDatos7=$empresa7->getDatos(); 

    $mensajeRecurrente7 = "
<p>Estimados señores: ".$vDato7["razonSocial"]."<br>

Nos ponemos en contacto con Ustedes porque según nuestros datos, a fecha de hoy, está pendiente de pago de su factura  de compra-venta emitida por la empresa ".$emDatos7['razonSocial'].", la cual tiene las siguientes referencias:<br>

Factura N°:             ".$factura7['nroFactura']."<br>
Fecha de emisión:       ".$factura7['fechaFactura']."<br>
Fecha de vencimiento:   ".$factura7['fechaVencimiento']."<br>
Valor a pagar:          $".$factura7['total']." <br>

Como es habitual, en su día les remitimos las facturas vía correo electrónico.
Rogamos verifiquen con su departamento de contabilidad el trámite de pago de dicha factura, y procedan de inmediato con la misma <br>

Agradecemos enormemente su cumplimiento. Si ya efectuó el pago favor ignorar el presente mensaje.<br><br><br>

Atte:<br><br>


Auxiliar Administrativo</p>

";
   
    $aEmail7["correo"]=$vDatos7['email']; 
    
    $aEmail7["asunto"]="Cobro de factura"; 

    $aEmail7["mensaje"]=$mensajeRecurrente7;

    $oControl->enviarCorreo($aEmail7);

    unset($oControl);


    $bEmail7["correo"]="D.ARDILA@JURISCON.COM.CO"; 
    
    $bEmail7["asunto"]="Cobro de factura copia"; 

    $bEmail7["mensaje"]=$mensajeRecurrente7;

    $oControl->enviarCorreo($bEmail7);

    unset($oControl);
    $cEmail7["correo"]="J.PINTO@JURISCON.COM.CO"; 
    
    $cEmail7["asunto"]="Cobro de factura copia"; 

    $cEmail7["mensaje"]=$mensajeRecurrente7;

    $oControl->enviarCorreo($cEmail7);

    unset($oControl);


    $dEmail7["correo"]=$emDatos7['email']; 
    
    
    $dEmail7["asunto"]="Cobro de factura copia"; 

    $dEmail7["mensaje"]=$mensajeRecurrente7;

    $oControl->enviarCorreo($dEmail7);

    unset($oControl);

}



$eLista8 = new Lista('factura_venta');

$eLista8->setFiltro("estado","!=",3);
$eLista8->setFiltro("datediff(curdate(),fechaVencimiento)","=",21);

$eolista8=$eLista8->getLista();

foreach ($eolista8 as $key => $factura8) {
    $cliente8 = new data("cliente","idCliente",$factura8["idCliente"]);
    $vDatos8=$cliente8->getDatos();

    $empresa8 = new data("empresa","idEmpresa",$factura8["idEmpresa"]);
    $emDatos8=$empresa8->getDatos(); 

    $mensajeRecurrente8 = "
<p>Estimados señores: ".$vDato8["razonSocial"]."<br>

Nos ponemos en contacto con Ustedes porque según nuestros datos, a fecha de hoy, está pendiente de pago de su factura  de compra-venta emitida por la empresa ".$emDatos8['razonSocial'].", la cual tiene las siguientes referencias:<br>

Factura N°:             ".$factura8['nroFactura']."<br>
Fecha de emisión:       ".$factura8['fechaFactura']."<br>
Fecha de vencimiento:   ".$factura8['fechaVencimiento']."<br>
Valor a pagar:          $".$factura8['total']." <br>

Como es habitual, en su día les remitimos las facturas vía correo electrónico.
Rogamos verifiquen con su departamento de contabilidad el trámite de pago de dicha factura, y procedan de inmediato con la misma <br>

Agradecemos enormemente su cumplimiento. Si ya efectuó el pago favor ignorar el presente mensaje.<br><br><br>

Atte:<br><br>


Auxiliar Administrativo</p>

";
   
    $aEmail8["correo"]=$vDatos8['email']; 
    
    $aEmail8["asunto"]="Cobro de factura"; 

    $aEmail8["mensaje"]=$mensajeRecurrente8;

    $oControl->enviarCorreo($aEmail8);

    unset($oControl);


    $bEmail8["correo"]="D.ARDILA@JURISCON.COM.CO"; 
    
    $bEmail8["asunto"]="Cobro de factura copia"; 

    $bEmail8["mensaje"]=$mensajeRecurrente8;

    $oControl->enviarCorreo($bEmail8);

    unset($oControl);
    $cEmail8["correo"]="J.PINTO@JURISCON.COM.CO"; 
    
    $cEmail8["asunto"]="Cobro de factura copia"; 

    $cEmail8["mensaje"]=$mensajeRecurrente8;

    $oControl->enviarCorreo($cEmail8);

    unset($oControl);


    $dEmail8["correo"]=$emDatos8['email']; 
    
    
    $dEmail8["asunto"]="Cobro de factura copia"; 

    $dEmail8["mensaje"]=$mensajeRecurrente8;

    $oControl->enviarCorreo($dEmail8);

    unset($oControl);

}



$eLista9 = new Lista('factura_venta');

$eLista9->setFiltro("estado","!=",3);
$eLista9->setFiltro("datediff(curdate(),fechaVencimiento)","=",24);

$eolista9=$eLista9->getLista();

foreach ($eolista9 as $key => $factura9) {
    $cliente9 = new data("cliente","idCliente",$factura9["idCliente"]);
    $vDatos9=$cliente9->getDatos();

    $empresa9 = new data("empresa","idEmpresa",$factura9["idEmpresa"]);
    $emDatos9=$empresa9->getDatos(); 

    $mensajeRecurrente9 = "
<p>Estimados señores: ".$vDato9["razonSocial"]."<br>

Nos ponemos en contacto con Ustedes porque según nuestros datos, a fecha de hoy, está pendiente de pago de su factura  de compra-venta emitida por la empresa ".$emDatos9['razonSocial'].", la cual tiene las siguientes referencias:<br>

Factura N°:             ".$factura9['nroFactura']."<br>
Fecha de emisión:       ".$factura9['fechaFactura']."<br>
Fecha de vencimiento:   ".$factura9['fechaVencimiento']."<br>
Valor a pagar:          $".$factura9['total']." <br>

Como es habitual, en su día les remitimos las facturas vía correo electrónico.
Rogamos verifiquen con su departamento de contabilidad el trámite de pago de dicha factura, y procedan de inmediato con la misma <br>

Agradecemos enormemente su cumplimiento. Si ya efectuó el pago favor ignorar el presente mensaje.<br><br><br>

Atte:<br><br>

Auxiliar Administrativo</p>

";
   
    $aEmail9["correo"]=$vDatos9['email']; 
    
    $aEmail9["asunto"]="Cobro de factura"; 

    $aEmail9["mensaje"]=$mensajeRecurrente9;

    $oControl->enviarCorreo($aEmail9);

    unset($oControl);


    $bEmail9["correo"]="D.ARDILA@JURISCON.COM.CO"; 
    
    $bEmail9["asunto"]="Cobro de factura copia"; 

    $bEmail9["mensaje"]=$mensajeRecurrente9;

    $oControl->enviarCorreo($bEmail9);

    unset($oControl);
    $cEmail9["correo"]="J.PINTO@JURISCON.COM.CO"; 
    
    $cEmail9["asunto"]="Cobro de factura copia"; 

    $cEmail9["mensaje"]=$mensajeRecurrente9;

    $oControl->enviarCorreo($cEmail9);

    unset($oControl);


    $dEmail9["correo"]=$emDatos9['email']; 
    
    
    $dEmail9["asunto"]="Cobro de factura copia"; 

    $dEmail9["mensaje"]=$mensajeRecurrente9;

    $oControl->enviarCorreo($dEmail9);

    unset($oControl);

}


$eLista10 = new Lista('factura_venta');

$eLista10->setFiltro("estado","!=",3);
$eLista10->setFiltro("datediff(curdate(),fechaVencimiento)","=",27);

$eolista10=$eLista10->getLista();

foreach ($eolista10 as $key => $factura10) {
    $cliente10 = new data("cliente","idCliente",$factura10["idCliente"]);
    $vDatos10=$cliente10->getDatos();

    $empresa10 = new data("empresa","idEmpresa",$factura10["idEmpresa"]);
    $emDatos10=$empresa10->getDatos(); 

    $mensajeRecurrente10 = "
<p>Estimados señores: ".$vDato10["razonSocial"]."<br>

Nos ponemos en contacto con Ustedes porque según nuestros datos, a fecha de hoy, está pendiente de pago de su factura  de compra-venta emitida por la empresa ".$emDatos10['razonSocial'].", la cual tiene las siguientes referencias:<br>

Factura N°:             ".$factura10['nroFactura']."<br>
Fecha de emisión:       ".$factura10['fechaFactura']."<br>
Fecha de vencimiento:   ".$factura10['fechaVencimiento']."<br>
Valor a pagar:          $".$factura10['total']." <br>

Como es habitual, en su día les remitimos las facturas vía correo electrónico.
Rogamos verifiquen con su departamento de contabilidad el trámite de pago de dicha factura, y procedan de inmediato con la misma <br>

Agradecemos enormemente su cumplimiento. Si ya efectuó el pago favor ignorar el presente mensaje.<br><br><br>

Atte:<br><br>


Auxiliar Administrativo</p>

";
   
    $aEmail10["correo"]=$vDatos10['email']; 
    
    $aEmail10["asunto"]="Cobro de factura"; 

    $aEmail10["mensaje"]=$mensajeRecurrente10;

    $oControl->enviarCorreo($aEmail10);

    unset($oControl);


    $bEmail10["correo"]="D.ARDILA@JURISCON.COM.CO"; 
    
    $bEmail10["asunto"]="Cobro de factura copia"; 

    $bEmail10["mensaje"]=$mensajeRecurrente10;

    $oControl->enviarCorreo($bEmail10);

    unset($oControl);
    $cEmail10["correo"]="J.PINTO@JURISCON.COM.CO"; 
    
    $cEmail10["asunto"]="Cobro de factura copia"; 

    $cEmail10["mensaje"]=$mensajeRecurrente10;

    $oControl->enviarCorreo($cEmail10);

    unset($oControl);


    $dEmail10["correo"]=$emDatos10['email']; 
    
    
    $dEmail10["asunto"]="Cobro de factura copia"; 

    $dEmail10["mensaje"]=$mensajeRecurrente10;

    $oControl->enviarCorreo($dEmail10);

    unset($oControl);

}




$eLista11 = new Lista('factura_venta');

$eLista11->setFiltro("estado","!=",3);
$eLista11->setFiltro("datediff(curdate(),fechaVencimiento)","=",30);

$eolista11=$eLista11->getLista();

foreach ($eolista11 as $key => $factura11) {
    $cliente11 = new data("cliente","idCliente",$factura11["idCliente"]);
    $vDatos11=$cliente11->getDatos();

    $empresa11 = new data("empresa","idEmpresa",$factura11["idEmpresa"]);
    $emDatos11=$empresa11->getDatos(); 

    $mensajeRecurrente11 = "
<p>Estimados señores: ".$vDato11["razonSocial"]."<br>

Nos ponemos en contacto con Ustedes porque según nuestros datos, a fecha de hoy, está pendiente de pago de su factura  de compra-venta emitida por la empresa ".$emDatos11['razonSocial'].", la cual tiene las siguientes referencias:<br>

Factura N°:             ".$factura11['nroFactura']."<br>
Fecha de emisión:       ".$factura11['fechaFactura']."<br>
Fecha de vencimiento:   ".$factura11['fechaVencimiento']."<br>
Valor a pagar:          $".$factura11['total']." <br>

Como es habitual, en su día les remitimos las facturas vía correo electrónico.
Rogamos verifiquen con su departamento de contabilidad el trámite de pago de dicha factura, y procedan de inmediato con la misma <br>

Agradecemos enormemente su cumplimiento. Si ya efectuó el pago favor ignorar el presente mensaje.<br><br><br>

Atte:<br><br>


Auxiliar Administrativo</p>

";
   
    $aEmail11["correo"]=$vDatos11['email']; 
    
    $aEmail11["asunto"]="Cobro de factura"; 

    $aEmail11["mensaje"]=$mensajeRecurrente11;

    $oControl->enviarCorreo($aEmail11);

    unset($oControl);



    $bEmail11["correo"]="D.ARDILA@JURISCON.COM.CO"; 
    
    $bEmail11["asunto"]="Cobro de factura copia"; 

    $bEmail11["mensaje"]=$mensajeRecurrente11;

    $oControl->enviarCorreo($bEmail11);

    unset($oControl);
    $cEmail11["correo"]="J.PINTO@JURISCON.COM.CO"; 
    
    $cEmail11["asunto"]="Cobro de factura copia"; 

    $cEmail11["mensaje"]=$mensajeRecurrente11;

    $oControl->enviarCorreo($cEmail11);

    unset($oControl);


    $dEmail11["correo"]=$emDatos11['email']; 
    
    
    $dEmail11["asunto"]="Cobro de factura copia"; 

    $dEmail11["mensaje"]=$mensajeRecurrente11;

    $oControl->enviarCorreo($dEmail11);

    unset($oControl);

}





$eLista60 = new Lista('factura_venta');

$eLista60->setFiltro("estado","!=",3);
$eLista60->setFiltro("datediff(curdate(),fechaVencimiento)","=",60);

$eolista60=$eLista60->getLista();

foreach ($eolista60 as $key => $factura60) {
    $cliente60 = new data("cliente","idCliente",$factura60["idCliente"]);
    $vDatos60=$cliente60->getDatos();

    $empresa60 = new data("empresa","idEmpresa",$factura60["idEmpresa"]);
    $emDatos60=$empresa60->getDatos(); 

    $mensajeRecurrente60 = "
<p>Estimados señores: ".$vDato11["razonSocial"]."<br>

De nuevo nos vemos obligados a ponernos en contacto con usted en referencia al incumplimiento en el pago de la factura con la siguiente referencia:<br>

Factura N°:             ".$factura60['nroFactura']."<br>
Fecha de emisión:       ".$factura60['fechaFactura']."<br>
Fecha de vencimiento:   ".$factura60['fechaVencimiento']."<br>
Valor a pagar:          $".$factura60['total']." <br>

Hasta el momento no hemos obtenido una respuesta satisfactoria por su parte ni a estas comunicaciones escritas ni a las llamadas telefónicas, por ello le instamos a hacer efectivo el importe sin más demora mediante una transferencia a cualquiera de la(s) siguiente(s) cuenta(s) bancaria(s):<br>
xxxxxxxxxxxxx:  ________<br>
xxxxxxxxxxxxx:  ________<br>
 <br>

En caso de que no pudiera hacer efectivo el pago, le invitamos a que se ponga en contacto con nosotros para negociar posibles opciones para saldar la deuda y evitar así la acumulación de intereses.<br>

Así mismo, le comunicamos que, si en el plazo de 24 horas hábiles no hemos recibido noticias suyas, nos veremos obligados a darle poder a nuestros abogados para el inicio del correspondiente proceso ejecutivo, así como a adoptar todas aquellas acciones legales y comerciales que consideremos oportunas, con todas las molestias, implicaciones y recargos económicos que esto puede generar. <br><br>

Atte:<br><br>


Auxiliar Administrativo</p>

";
   
    $aEmail60["correo"]=$vDatos60['email']; 
    
    $aEmail60["asunto"]="Cobro de factura"; 

    $aEmail60["mensaje"]=$mensajeRecurrente60;

    $oControl->enviarCorreo($aEmail60);

    unset($oControl);


    $bEmail60["correo"]="D.ARDILA@JURISCON.COM.CO"; 
    
    $bEmail60["asunto"]="Cobro de factura copia"; 

    $bEmail60["mensaje"]=$mensajeRecurrente60;

    $oControl->enviarCorreo($bEmail60);

    unset($oControl);
    $cEmail60["correo"]="J.PINTO@JURISCON.COM.CO"; 
    
    $cEmail60["asunto"]="Cobro de factura copia"; 

    $cEmail60["mensaje"]=$mensajeRecurrente60;

    $oControl->enviarCorreo($cEmail60);

    unset($oControl);


    $dEmail60["correo"]=$emDatos60['email']; 
    
    
    $dEmail60["asunto"]="Cobro de factura copia"; 

    $dEmail60["mensaje"]=$mensajeRecurrente60;

    $oControl->enviarCorreo($dEmail60);

    unset($oControl);

}


  ?>