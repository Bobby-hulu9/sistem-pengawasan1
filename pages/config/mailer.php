<?php
require __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function getMailer(): PHPMailer|null {
    $mail = new PHPMailer(true);

    try {
        
        $mail->isSMTP();
$mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   ='hulubobby65@gmail.com'; 
$mail->Password   ='vwuuyjhndxftzdnr';   
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587;

        $mail->setFrom('no-reply@sistemanda.com', 'Sistem Pengawasan');

        return $mail;

    } catch (Exception $e) {
        return null;
    }
}
