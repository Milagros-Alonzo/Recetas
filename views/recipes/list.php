<?php
require_once __DIR__ . '/../../config/config.php';
$title = "Recetas Detalladas";
ob_start(); // Inicia el almacenamiento en búfer de salida
include BASE_PATH . '/include/session/SessionManager.php';

SessionManager::startSession();
SessionManager::requireAuth();
if(isset($_SESSION['user'])) {
    SessionManager::checkSessionTimeout();
}
$mensaje = SessionManager::getMessage();
?>

<div class="main-content">
        <div class="container-titulo">
            <h1 class="titulo-pagina">Mis Recetas</h1>
            <div class="search-box">
                <button class="btn-search"><i class="fas fa-search"></i></button>
                <input type="text" class="input-search" id="searchInput" placeholder="Escriba recetas o ingredientes para buscar...">
                <div id="results">
                </div>
            </div>
            <hr>
        </div>   
        <form action="">
            <div class="controller-container-receta">
                <button 
                    type="submit" 
                    id="borrar-receta-user" 
                    class="ov-btn-grow-skew-reverse"
                    name="action" 
                    value="borrar-receta-user"
                    onclick="return confirm('¿Estás seguro de que deseas borrar esta receta?');"
                >Borrar Receta?
                </button>
                <button 
                    type="submit" 
                    id="actualizar-receta-user" 
                    class="ov-btn-grow-skew-reverse"
                    name="action" 
                    value="actualizar-receta-user"
                    onclick="return confirm('¿Estás seguro de que deseas actualizar esta receta?');"
                >actualizar Receta?
                </button>
                <button 
                    type="button" 
                    id="subir-receta-user" 
                    class="ov-btn-grow-skew-reverse"
                    name="action" 
                    value="subir-receta-user"
                    onclick="window.location.href='<?= BASE_URL . '/views/recipes/add.php';?>'"
                >crear una nueva Receta
                </button>
            </div>     
            <div class="container-receta">
                <!-- para la lista de tus recetas nececitas declarar un id -->
                <?php $id = isset($_SESSION['user']) ? $_SESSION['user'] : ''; ?>
                <!-- llamar el componente -->
                <?php include BASE_PATH . '/include/component/all-recipe-component.php'; ?>
            </div>
        </form>
    </div>

<?php
//incluye el script para la actualizacion de la session y que se mantenga abierta
include BASE_PATH . '/public/js/sessionScript.php';
$content = ob_get_clean(); // Guarda el contenido en $content
include BASE_PATH . '/views/layout.php'; // Incluye la plantilla principal