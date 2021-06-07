<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 'true');
// ini_set('display_startup_errors', 'true');

require $ROOT.'libraries/PHPMailer/src/PHPMailer.php';
require $ROOT.'libraries/PHPMailer/src/Exception.php';
require $ROOT.'libraries/PHPMailer/src/SMTP.php';
require $ROOT.'vendor/autoload.php';

class Control {
	
	public function encriptar($aArray=array()){
		
		$method = 'aes128';
		
		if(!isset($_SESSION)){ session_start(); }
		$pass=$_SESSION["acceso"];

		$encript=openssl_encrypt ($aArray["cadena"], $method, $pass);
		$encript=base64_encode($encript); 
		return $encript; 
	}

	public function desencriptar($aArray=array()){
		if(!isset($_SESSION)){ session_start(); }
		$pass=$_SESSION["acceso"];
		$method = 'aes128';
		$aArray["cadena"]=base64_decode($aArray["cadena"]); 
		$encrypted=openssl_decrypt ($aArray["cadena"],$method,$pass);
		if (false === $encrypted) {
		    $encrypted=openssl_error_string ();
		} 
		return $encrypted; 
	}

	public function eliminarMoneda($valor){
		
		$return=str_replace("$", "", str_replace(",", "", $valor)); 
		return $return; 
	}

	public function enviarCorreo($aDatos=array()){

		
			$mail = new PHPMailer\PHPMailer\PHPMailer();

			//Tell PHPMailer to use SMTP
			$mail->isSMTP();

			//Enable SMTP debugging
			// SMTP::DEBUG_OFF = off (for production use)
			// SMTP::DEBUG_CLIENT = client messages
			// SMTP::DEBUG_SERVER = client and server messages
			$mail->CharSet = "utf-8";		    
            $mail->SMTPDebug = 0;		    
		    $mail->SMTPOptions = array(
                                  'ssl' => array(
                                  'verify_peer' => false,
                                  'verify_peer_name' => false,
                                  'allow_self_signed' => true));

			$mail->SMTPAuth = false; 
			$mail->SMTPSecure = false;			
			$mail->Host = 'localhost';
			$mail->Port = 25;
			//Set the hostname of the mail server
			// // use
			// $mail->Host = 'server119.web-hosting.com';
			
			// // // if your network does not support SMTP over IPv6
			// // //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
			// // $mail->Port       = 587;
			// //$mail->SMTPSecure = 'ssl';
			// $mail->Port = 587; 
   
	  //       $mail->SMTPSecure = 'tls';
			// //$mail->SMTPAuth = false;
			// $mail->SMTPAuth = true;
	        //Whether to use SMTP authentication
	         //$mail->SMTPAuth   = true;

			//Username to use for SMTP authentication - use full email address for gmail
			$mail->Username = 'info@smartbuss.co';

			//Password to use for SMTP authentication
			$mail->Password = 'smart2020/';

			//Set who the message is to be sent from
			$mail->setFrom('info@smartbuss.co', "Info SmartBuss");

			//Set an alternative reply-to address
			//$mail->addReplyTo('replyto@example.com', 'First Last');

			//Set who the message is to be sent to
			$mail->addAddress($aDatos["correo"]);

			//Set the subject line
			$cabecera='<div style="text-align: center; width: 100%">
						<div style="width: 800px; border: 1px solid #CCC; height: 100%; display: inline-block;">
							<div style="width: 100%; height: 100px; background-color: #0e85b8; display: table; ">
								<div style="display: table-cell;vertical-align: middle;"><img src="http://smartbuss.co/assets/img/SmartBusslogo-04.png" style="width: 30%"></div>
								<div></div>
							</div>
					<div style="min-height: 500px; text-align: justify; padding: 5px; ">'; 

					$footer='</div>
							<div style="width: 100%; height: 50px;background-color: #0e85b8; display: table;">
								
							</div>
						</div>	
						</div>'; 
			$mail->Subject = utf8_decode($aDatos["asunto"]);

			//Read an HTML message body from an external file, convert referenced images to embedded,
			//convert HTML into a basic plain-text alternative body
			$mail->msgHTML($cabecera.$aDatos["mensaje"].$footer);

			//Replace the plain text body with one created manually
			$mail->AltBody = 'This is a plain-text message body';

			//Attach an image file
			if($aDatos["archivo"]!=""){
				$mail->addAttachment($aDatos["archivo"]);	
			}
			
			//var_dump($aDatos, $mail->ErrorInfo); 
			//send the message, check for errors
			if (!$mail->send()) {
			    return 'Mailer Error: '. $mail->ErrorInfo;
			} else {
			    return 1;
			    //Section 2: IMAP
			    //Uncomment these to save your message in the 'Sent Mail' folder.
			    #if (save_mail($mail)) {
			    #    echo "Message saved!";
			    #}
			}
	}
}
?>