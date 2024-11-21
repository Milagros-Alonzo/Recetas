<?php
require_once __DIR__ . '/config/config.php';
$title = "Página de Recetas";
ob_start(); // Inicia el almacenamiento en búfer de salida

include BASE_PATH . '/include/session/SessionManager.php';

SessionManager::startSession();

if(isset($_SESSION['user'])) {
    SessionManager::checkSessionTimeout();
}
$mensaje = SessionManager::getMessage();

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


        </div>
    </div>
    

    <script>
    mensaje = <?php echo json_encode($mensaje ?? ''); ?>;
    console.log(mensaje);
    if(mensaje) {
        alert(mensaje)
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
