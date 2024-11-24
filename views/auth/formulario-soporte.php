
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas y Soporte</title>
    <link rel="stylesheet" href="styles.css"> <!-- Asegúrate de enlazar tu archivo CSS -->
</head>
<body>
    <div class="form-container">
        <h1>Consultas y Soporte</h1>
        
        <?php
        // Mostrar mensaje de éxito o error (si existe en la sesión)
        session_start();
        if (isset($_SESSION['mensaje'])) {
            echo "<p class='mensaje'>" . htmlspecialchars($_SESSION['mensaje']) . "</p>";
            unset($_SESSION['mensaje']); // Eliminar mensaje después de mostrarlo
        }
        ?>
        
        <form action="procesar-consulta.php" method="post">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="mensaje">Mensaje</label>
                <textarea id="mensaje" name="mensaje" rows="5" required></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-submit">Enviar Consulta</button>
            </div>
        </form>
    </div>
</body>
</html>
