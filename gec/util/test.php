<?php
require("class.phpmailer.php");
$mail = new PHPMailer();
//********************************************/
$SMTP_Host = "mail.lintinzone.com";
$SMTP_Port = 25;
$SMTP_UserName = "lintinzo@lintinzone.com";
$SMTP_Password = "l1nTInte@m";
$from = $SMTP_UserName;
$to = "tung121089@gmail.com";
// Luu y: $SMTP_UserName = $from
//********************************************/

$mail->IsSMTP();
$mail->Host     = $SMTP_Host;
$mail->SMTPAuth = true;
$mail->Username = $SMTP_UserName;
$mail->Password = $SMTP_Password;

$mail->From     = $from;
$mail->FromName = "LintinZone";
$mail->AddAddress($to);
//$mail->AddReplyTo("info@site.com","Information");

$mail->WordWrap = 50;
//$mail->AddAttachment("/var/tmp/file.tar.gz");
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg");
$mail->IsHTML(true);

$mail->Subject  =  "LintinZone - Thư xác nhận thành viên";
$mail->Body     =  "Xác nhận <b>thành viên</b>";
$mail->AltBody  =  "Xác nhận thành viên";

if(!$mail->Send())
{
   echo "Mail gui khong thanh cong! <p>";
   echo "Thong bao loi: " . $mail->ErrorInfo;
   exit;
}
echo "Mail gui thanh cong!";
?>