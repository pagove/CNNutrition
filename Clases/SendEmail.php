<?php

use PHPMailer\PHPMailer\PHPMailer;

include_once "Mail/PHPMailer.php";
include_once "Mail/Exception.php";
include_once "Mail/SMTP.php";

class SendEmail
{
    public static function send($para, $subject, $body = "", $bodyHtml = "")
    {

        $mail = new PHPMailer(true);
        $from = DatosConexion::getDatosEmail();
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $from->usr;
            $mail->Password = $from->passwd;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->CharSet = 'UTF-8';
            $mail->Port = 465;

            $mail->setFrom($from->usr, Utilidades::ifutf8_encode('Carlos Nadal Pavía'));
            $mail->addAddress($para);

            $mail->Subject = Utilidades::ifutf8_encode($subject);
            if ($bodyHtml) {
                $mail->isHTML(true);
                $body = $bodyHtml;
            } else {
                $mail->isHTML(false);
            }
            $mail->Body = Utilidades::ifutf8_encode($body);

            $mail->send();
            Logger::haz_log(__CLASS__, "Email enviado a to[$para] con el asunto [$subject] y mensaje: [$body]");
            return new TRetorno(true);
        } catch (Exception $e) {
            return new TRetorno(false, "Error al enviar el correo: {$mail->ErrorInfo}");
        }
    }
}
