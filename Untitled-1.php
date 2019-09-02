<?php

$msg='abcd';
require_once('PHPMailer/PHPMailerAutoload.php');
$mail = new PHPMailer;
//$mail->SMTPDebug = 2;
$mail->isSMTP();
$mail->Host='sg3plcpnl0194.prod.sin3.secureserver.net';
$mail->Port=465;
$mail->SMTPAuth=true;
$mail->SMTPSecure='ssl';

$mail->Username='sel@selhrd.com';
$mail->Password='pglV4^P^7eZn';

$mail->SetFrom('sel@selhrd.com','SEL-HRD');
$mail->AddAddress('simanta.am.fl@gmail.com');
$mail->AddReplyTo('noreply@selhrd.com');
$mail->isHTML(true);
$mail->Subject='Leave Application to Reporter';
$mail->Body=$msg;
//$mail->AddStringAttachment($attachment, 'leave_form.pdf');
if(!$mail->send())
{
    echo "Mailer Error: " . $mail->ErrorInfo;
    echo '<div class="alert alert-danger" align="center">
                                                Mail Sending Failed to Reporter!
                                                </div>';
}
else
{
    echo '<div class="alert alert-success" align="center">
                                                Mail Sent to Reporter!
                                                </div>';
}




?>