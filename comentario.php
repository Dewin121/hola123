<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoge los datos del formulario
    $nameform51m = $_POST["nameform51m"];
    $emailform51m = $_POST["emailform51m"];
    $textareaform51m = $_POST["textareaform51m"];

    // Configura PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'dewin121@gmail.com';
        $mail->Password   = 'eylzslrsiwxlwxvv';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Configuración del remitente y destinatario
        $mail->setFrom('dewin121@gmail.com', 'Mailer');
        $mail->addAddress('dewin121@gmail.com', 'Joe User');

        // Configuración del contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Comentario De ' . $nameform51m;

        // Cuerpo del correo con datos del formulario
        $mail->Body = "
            <p>Nombre y Apellido: $nameform51m</p>
            <p>Correo: $emailform51m</p>
            <p>Mensaje: $textareaform51m</p>
        ";

        // Adjuntar archivo si se ha proporcionado
        if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == UPLOAD_ERR_OK) {
            $archivo_nombre = $_FILES['archivo']['name'];
            $archivo_ruta = $_FILES['archivo']['tmp_name'];

            $mail->addAttachment($archivo_ruta, $archivo_nombre);
            $mail->Body .= "<p>Archivo Adjunto: $archivo_nombre</p>";
        }

        $mail->AltBody = 'Este es el cuerpo del mensaje en texto plano para clientes de correo no HTML';

        // Envío del correo
        $mail->send();

        // Mensaje enviado correctamente
        echo '<script>
                alert("Comentario enviado correctamente");
                window.location.href = "index.html";
              </script>';
        exit; // Asegura que no se ejecuten más instrucciones después de la redirección
    } catch (Exception $e) {
        // En caso de error, devuelve un mensaje de error
        echo '<script>
                alert("Error al enviar el Comentario. Por favor, inténtalo de nuevo más tarde.");
                window.location.href = "index.html";
              </script>';
        exit;
    }
} else {
    echo '<script>
            alert("Acceso no permitido");
            window.location.href = "index.html";
          </script>';
    exit;
}
?>
