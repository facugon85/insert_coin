<?php
// Establecer el tipo de contenido a JSON
header('Content-Type: application/json');

// Verificar que la solicitud sea POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar los datos del formulario
    $name = strip_tags(trim($_POST["name"]));
    $name = str_replace(array("\r","\n"),array(" "," "),$name);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    // Verificar que los campos no estén vacíos y que el email sea válido
    if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Devolver una respuesta de error en formato JSON
        echo json_encode(['success' => false, 'error' => 'Por favor, completa todos los campos correctamente.']);
        exit;
    }

    // Configurar el correo electrónico
    $recipient = "theinsertcoinbox@gmail.com";
    $subject = "Nuevo Comentario de Arcade Box";
    
    $email_content = "Nombre: $name\n";
    $email_content .= "Correo Electrónico: $email\n\n";
    $email_content .= "Comentario:\n$message\n";

    $email_headers = "From: $name <$email>";

    // Intentar enviar el correo electrónico
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Devolver una respuesta de éxito en formato JSON
        echo json_encode(['success' => true]);
    } else {
        // Devolver una respuesta de error en formato JSON
        echo json_encode(['success' => false, 'error' => 'Hubo un problema al enviar el correo. Inténtalo de nuevo más tarde.']);
    }

} else {
    // Si no es una solicitud POST, devolver una respuesta de error
    echo json_encode(['success' => false, 'error' => 'Método de solicitud inválido.']);
}
?>
