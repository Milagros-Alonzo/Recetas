<?php
require_once __DIR__ . '/../../config/config.php';
$title = "Recetas Detalladas";
ob_start(); // Inicia el almacenamiento en búfer de salida
include BASE_PATH . '/include/session/SessionManager.php';

SessionManager::startSession();
if(isset($_SESSION['user'])) {
    SessionManager::checkSessionTimeout();
}
$mensaje = SessionManager::getMessage();

// Obtener el ID de la receta de la URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id === 0) {
    echo "ID de receta inválido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de la Receta - <?php echo htmlspecialchars($title); ?></title>
    <script>
    const BASE_URL = '<?php echo BASE_URL; ?>';
</script>
<script src="<?php echo BASE_URL; ?>/public/js/fetch_recipeDetail.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Fetching details for recipe ID:', <?php echo $id; ?>);

            fetchRecetaDetail(<?php echo $id; ?>, BASE_URL);

        });
    </script>
</head>
<body>
    <div class="detalle-receta">
        <!-- Aquí se cargarán los detalles de la receta -->
    </div>
</body>
</html>

<?php
//incluye el script para la actualizacion de la session y que se mantenga abierta
include BASE_PATH . '/public/js/sessionScript.php';
$content = ob_get_clean(); // Guarda el contenido en \$content
include BASE_PATH . '/views/layout.php';
?>
