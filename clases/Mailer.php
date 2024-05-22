<?php

use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};

class Mailer
{
    function enviarEmail($destinatario, $asunto, $cuerpo)
    {
        require_once __DIR__ . '/../config/config.php';
        require __DIR__ . '/../phpmailer/src/PHPMailer.php';
        require __DIR__ . '/../phpmailer/src/SMTP.php';
        require __DIR__ . '/../phpmailer/src/Exception.php';

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      // Enable verbose debug output
            $mail->isSMTP();                                         // Send using SMTP
            $mail->Host       = MAIL_HOST;                           // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                // Enable SMTP authentication
            $mail->Username   = MAIL_USER;                           // SMTP username
            $mail->Password   = MAIL_PASS;                           // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Enable implicit TLS encryption
            $mail->Port       = MAIL_PORT;                           // TCP port to connect to

            //Recipients
            $mail->setFrom(MAIL_USER, 'CDP');
            $mail->addAddress($destinatario);

            // Content
            $mail->isHTML(true);                                     // Set email format to HTML
            $mail->Subject = $asunto;
            $mail->Body    = mb_convert_encoding($cuerpo, 'ISO-8859-1', 'UTF-8');

            // Set language
            $mail->setLanguage('es', __DIR__ . '/../phpmailer/language/phpmailer.lang.es.php');

            if($mail->send()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo "No se pudo enviar el mensaje: Error de envio: {$mail->ErrorInfo}";
            return false;
        }
    }
}
?>



