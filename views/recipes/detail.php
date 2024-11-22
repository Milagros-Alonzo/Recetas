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

?>




    <div class="detaller-receta-container">
        <h1>Detalles de la Receta</h1>
        <div class="detalle-receta">
            <!-- Aquí se cargarán los detalles de la receta -->
        </div>
    </div>

    <script>   
        <?php include BASE_PATH . '/public/js/fetch_recipeDetail.js'; ?>
        
        document.addEventListener('DOMContentLoaded', function() {
                fetchRecetaDetail(<?php  echo isset($_GET['id']) ? $_GET['id'] : 0; ?>);
            });
    </script>
           <!-- Mostrar Comentarios -->
 <div class="mostrar-comentarios">
            <h2>Comentarios</h2>
            <div id="comentarios-lista">
                <!-- Aquí se mostrarán los comentarios cargados con JavaScript -->
            </div>
        </div>
 </div
 <?php include BASE_PATH . '/public/js/fetch_comments.js'; ?>
<?php
//incluye el script para la actualizacion de la session y que se mantenga abierta
//include BASE_PATH . '/public/js/sessionScript.php';
$content = ob_get_clean(); // Guarda el contenido en $content
include BASE_PATH . '/views/layout.php'; // Incluye la plantilla principal