<?php
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/controllers/adminController.php';
require_once __DIR__ . '/controllers/authController.php';
require_once __DIR__ . '/include/session/SessionManager.php';


// Inicia sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    SessionManager::startSession();
}
// Determina la acción a ejecutar
$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'home': // Página principal de recetas
        $title = "Página de Recetas";
        ob_start();
        include BASE_PATH . '/views/recipes/list.php';
        $content = ob_get_clean();
        break;

    case 'dashboard': // Panel de administración
        $controller = new AdminController();
        $controller->dashboard();
        exit();

    default: // Página no encontrada
        http_response_code(404);
        $title = "Página no encontrada";
        ob_start();
        echo "<h1>404 - Página no encontrada</h1>";
        $content = ob_get_clean();
        break;
}
?>

<div class="main-content">
    <div class="container-titulo">
        <h1 class="titulo-pagina">Página de Recetas</h1>
        <div class="search-box">
            <button class="btn-search"><i class="fas fa-search"></i></button>
            <input type="text" class="input-search" id="searchInput" placeholder="Escriba recetas o ingredientes para buscar...">
            <div id="results">
            </div>
        </div>
        <hr>
    </div>        
    <div class="container-receta">
        <!-- Aquí se mostrarán las recetas obtenidas con JavaScript -->
    </div>
</div>

<script>
    mensaje = <?php echo json_encode($mensaje ?? ''); ?>;
    console.log(mensaje);
    if(mensaje) {
        alert(mensaje);
        <?php
            $_SESSION['mensaje'] = '';
        ?>
    }
    const id = '';
    <?php include BASE_PATH . '/public/js/fetch_getRecipe.js'; ?>
</script>

<?php
//incluye el script para la actualizacion de la session y que se mantenga abierta
//include BASE_PATH . '/public/js/sessionScript.php';
$content = ob_get_clean(); // Guarda el contenido en $content
include BASE_PATH . '/views/layout.php'; // Incluye la plantilla principal
