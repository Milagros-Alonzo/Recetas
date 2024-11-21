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



<?php
//incluye el script para la actualizacion de la session y que se mantenga abierta
include BASE_PATH . '/public/js/sessionScript.php';
$content = ob_get_clean(); // Guarda el contenido en $content
include BASE_PATH . '/views/layout.php'; // Incluye la plantilla principal