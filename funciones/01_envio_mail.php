<?php

/*

// ENVIO MAIL DE ALERTA:	
$destinatario='info@msr.cat';
$asunto='ALERTA:'.$matricula.' '.$incidencia.' '.$ubicac;
$cabeceras  = 'MIME-Version: 1.0' . "\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\n";
$cabeceras .= 'From: info@msr.cat' . "\r\n";
$cabeceras .= 'Bcc: msr@msr.cat' . "\r\n";
$contenido  = $inicio_contenido;
$contenido .= 'SEGU generada:'.$fecha. 'a las '.$hora.'<br/>MATRICULA:'.$matricula.'<br/>INCIDENCIA: '.$incidencia.'<br/>LUGAR:'.$ubicac.'<br/>FOTO: <a href="http://www.tianatvd.cat/01_web/fotos2/'.$nombre_foto.'" target="_blank">'.$nombre_foto.'</a>';
$contenido.= $delimitador."\n";

mail($destinatario,$asunto,$contenido,$cabeceras);
*/

 
$cuerpo="ALERTA generada:".$fecha. "a las ".$hora."<br/>MATRICULA:".$matricula."<br/>INCIDENCIA: ".$incidencia."<br/>LUGAR:".$ubicac."<br/>FOTO: <a href='http://www.tsgtvd.cat/01_web/fotostsg/".$nombre_foto." target='_blank'>".$nombre_foto."</a>";

$asunto="ALERTA:$matricula.' '.$incidencia.' '.$ubicac";
//$archivo=$dir_raiz."/fac/".$nombre_pdf.".pdf";

$archivo=$dir_raiz."/fac/tt_01_000001.pdf";

require 'PHPMailer/class.phpmailer.php';
 $mail = new PHPMailer();
 $mail->IsSMTP(); // enable SMTP
 $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
 $mail->SMTPAuth = true; // authentication enabled
 $mail->SMTPSecure = ''; // secure transfer enabled REQUIRED for Gmail
 $mail->Host = "msr.cat";
 $mail->Port = 25; // or 587
 $mail->IsHTML(true);
 $mail->Username = "postmaster@msr.cat";
 $mail->Password = "Admin111";
 $mail->SetFrom("noreply@rsegu.com");
 $mail->Subject = $asunto;
 $mail->msgHTML($cuerpo);
 $mail->AddAttachment($archivo);
 $mail->IsHTML(true); // Enviar como HTML
 //$mail->Body = "Ingrese el texto del correo electrónico aquí";

 $mail->AddAddress("info@msr.cat");
 $mail->AddCC('info@torsia.cat');
 $mail->AddBCC('info@torsia.cat');
 //$mail->AddAddress("");
 if(!$mail->Send()) {
 echo "Mailer Error: " . $mail->ErrorInfo;
 } else {
 echo "Mensaje enviado correctamente";
 }
?>



