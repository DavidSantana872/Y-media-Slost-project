<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Asegúrate de que PHPMailer está instalado

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$mailInstance = new PHPMailer(true);
try {
    // Configuración del servidor SMTP de Hostinger
    $mailInstance->isSMTP();
    $mailInstance->Host = $_ENV['SMTP_HOST']; 
    $mailInstance->SMTPAuth = true;
    $mailInstance->Username = $_ENV['SMTP_USER']; // Tu correo empresarial
    $mailInstance->Password = $_ENV['SMTP_PASSWORD']; // La contraseña de tu correo en Hostinger
    $mailInstance->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Usar SSL
    $mailInstance->Port = 465; // Cambiar a 587 si usas TLS

} catch (Exception $e) {
    echo "Error al enviar el correo: {$mailInstance->ErrorInfo}";
}

function send_email($mail, $to, $body, $subject) {
    $from = $_ENV['SMTP_USER'];
    try{
        // Configurar el remitente y destinatario
        $mail->setFrom($from, "Tienda de perfumes");
        $mail->addAddress($to, 'Cliente Ganador'); // Cambia por el destinatario real

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        // Enviar el correo
        $mail->send();
        return true; 
        
    }catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
        return false;
    }
}
?>

