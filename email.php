<?php

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
$mail->AddAddress($email);
$mail->AddReplyTo('noreply@selhrd.com');
$mail->isHTML(true);
$mail->Subject='Leave Application';
$mail->Body="Hello";
//$mail->AddStringAttachment($attachment, 'leave_form.pdf');





if(!$mail->send())
{
    echo "Mailer Error: " . $mail->ErrorInfo;
    echo '<div class="alert alert-danger" align="center">
    Mail Sending Failed to Head!
    </div>';
}
else
{
    echo '<div class="alert alert-success" align="center">
    Mail Sent to You as Attachment!
    </div>';
}


//  ob_end_flush();
// mysqli_close($db);


?>
</div>

</div>
<!--/span-->

<!--/span-->

</div>
</div>


</body>
</html>












<?php
/*require_once('PHPMailer/PHPMailerAutoload.php');
$mail = new PHPMailer;
//$mail->SMTPDebug = 2;
$mail->isSMTP();
$mail->Host='mail.projectskt.com';
$mail->Port=465;
$mail->SMTPAuth==true;
$mail->SMTPSecure='ssl';

$mail->Username='tashik@projectskt.com';
$mail->Password='dKo15t9mW7';

$mail->SetFrom('tashik@projectskt.com','System Engineering Limited');
$mail->AddAddress('simanta.paul.26@gmail.com');
$mail->AddReplyTo('tashik@projectskt.com');

$mail->isHTML(true);
$mail->Subject='PHP Mailer Simanta';
$mail->Body="<h1>Simanta Paul</h1>";
if(!$mail->send())
{
    echo "Mailer Error: " . $mail->ErrorInfo;
}
else
{
    echo "Message Sent";
}
*/
?>

