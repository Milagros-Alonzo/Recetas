<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);
    $comment = htmlspecialchars($_POST['comment']);
    
    // Validación básica
    if (empty($name) || empty($email) || empty($message) || empty($comment)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        // Enviar correo (configura tu correo real)
        $to = "Contacto@recetasapp.com";
        $subject = "Nuevo comentario en la receta";
        $body = "Nombre: $name\nCorreo: $email\nTeléfono: $phone\nComentario:\n$comment\nMensaje adicional:\n$message";
        $headers = "From: $email";

        if (mail($to, $subject, $body, $headers)) {
            $success = "Gracias por tu comentario. Lo revisaremos pronto.";
        } else {
            $error = "Hubo un error al enviar tu comentario. Por favor, inténtalo de nuevo.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - Recetas App</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff5e6;
            color: #333;
        }
        .contact-page {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        .contact-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .contact-header h1 {
            color: #d35400;
            font-size: 2.5rem;
        }
        .contact-header p {
            color: #e67e22;
            font-size: 1.2rem;
        }
        .contact-container {
            display: flex;
            flex-wrap: wrap;
            background: #fbeee6;
            border-radius: 10px;
            padding: 20px;
            max-width: 900px;
            width: 100%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .contact-info {
            flex: 1;
            margin-right: 20px;
        }
        .contact-info h2 {
            color: #e74c3c;
            margin-bottom: 10px;
        }
        .contact-info p {
            margin: 10px 0;
        }
        .contact-info .info-item {
            margin: 5px 0;
            font-size: 0.9rem;
        }
        .contact-form {
            flex: 1;
            margin-left: 20px;
        }
        .contact-form .form-group {
            margin-bottom: 15px;
        }
        .contact-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            font-size: 0.9rem;
        }
        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 0.9rem;
            background-color: #fff;
        }
        .contact-form button {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s ease;
        }
        .contact-form button:hover {
            background: #c0392b;
        }
        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="contact-page">
        <!-- Encabezado -->
        <div class="contact-header">
            <h1>Contáctanos</h1>
            <p>Déjanos tus comentarios y dudas acerca de nuestra app </p>
        </div>

        <div class="contact-container">
            <!-- Información de contacto -->
            <div class="contact-info">
                <h2>Información de contacto</h2>
                <p>Email: contacto@recetasapp.com</p>
                <p>Teléfono: +507 967 046 867</p>
                <p>Dirección: Panama, Panamá City</p>
            </div>

            <!-- Formulario de contacto -->
            <div class="contact-form">
                <?php if (!empty($success)): ?>
                    <div class="message success"><?= $success; ?></div>
                <?php endif; ?>
                <?php if (!empty($error)): ?>
                    <div class="message error"><?= $error; ?></div>
                <?php endif; ?>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" id="name" name="name" value="<?= htmlspecialchars($name ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Número de Teléfono</label>
                        <input type="text" id="phone" name="phone" value="<?= htmlspecialchars($phone ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="comment">Comentario</label>
                        <textarea id="comment" name="comment" rows="4" required><?= htmlspecialchars($comment ?? '') ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="message">Mensaje Adicional</label>
                        <textarea id="message" name="message" rows="3"><?= htmlspecialchars($message ?? '') ?></textarea>
                    </div>
                    <button type="submit">Enviar Comentario</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
