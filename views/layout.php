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
    <link rel="stylesheet" href="<?php echo BASE_URL . '/public/css/styles3.css'; ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


</head>
<body>
    <?php include BASE_PATH . '/include/header.php'; ?>

    <div class="parent-container">
        <?php echo $content ?? '<p>Contenido no disponible</p>'; ?>
    </div>

    <?php include BASE_PATH . '/include/footer.php'; ?>

    <script src="<?php echo  BASE_URL . '/public/js/scripts.js'; ?>"></script>
</body>
</html>
