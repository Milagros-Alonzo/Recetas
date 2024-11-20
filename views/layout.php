<?php
// Incluye el archivo de configuración
require_once __DIR__ . '/../config/config.php';

// Incluye el header y el footer utilizando rutas absolutas
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Mi Sitio Web'; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?> /public/css/styles3.css">
</head>
<body>
    <?php include BASE_PATH . '/include/header.php'; ?>

    <div class="parent-container">
        <div class="main-content">
            <?php echo $content ?? '<p>Contenido no disponible</p>'; ?>
        </div>
    </div>

    <?php include BASE_PATH . '/include/footer.php'; ?>

    <script src="<?php echo  BASE_URL . ' /public/js/scripts.js'; ?>"></script>
</body>
</html>
