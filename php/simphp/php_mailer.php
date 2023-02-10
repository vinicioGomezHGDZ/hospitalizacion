<?php
require_once '../../../../php/PHPMailer-5.2.23/PHPMailerAutoload.php';

$mail = new PHPMailer;
//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'mail.hgsd.gob.ec';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'sgh@hgsd.gob.ec';                 // SMTP username
$mail->Password = 'Sistemagh2017*';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('sgh@hgsd.gob.ec', 'Sistema de Gestión Hospitalaria');
$mail->addAddress('viniciogomez89@gmail.com', 'Vinicio Gomez');     // Add a recipient
$mail->addAddress('richirafaelreal@gmail.com','Rafael Real');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');
$body=utf8_decode('<table>
      <tr>
            <td width="50%" >
                <img src="../../../../img/logo.png " width="200" height="60">
            </td>
            <td width="50%" VALIGN="TOP">
            <H4>HOSPITAL GENERAL SANTO DOMINGO </H4>  
            <H4><center>Sistema de Gestión Hospitalaria</center></H4>
            </td>
      </tr>
      </table>
      <div>
      <table border="1" width="100%">
          <tr>
              <td>
                   Este correo es para comunicarle que tiene una interconsulta del 
                    servicio de: "'.$per[0]['tca_descripcion'].'" con el paciente: "'.$per[0]['paciente'].' ". con el cuadro clínico: "'.$per[0]['int_cuclia'].' " en la cama: "'. $per[0]['cam_codigo'] .' ".<br>
                    Tipo de solicitud : "'.$per[0]['mds_grabed'].'".
              </td>
          </tr>
      </table>');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->From     = "sgh@hgsd.gob.ec";
$mail->FromName = "HOSPITAL GENERAL SANTODOMINGO";
$mail->Subject  = "Solicitud de Interconsulta";
$mail->AltBody  = "Leer";
$mail->MsgHTML($body);

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
