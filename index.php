<?php
require_once __DIR__ . '/config/config.php';
$title = "Página de Recetas";
ob_start(); // Inicia el almacenamiento en búfer de salida

// incluye la creacion de la session y la revificacion de ella
include BASE_PATH . '/include/session/createSession.php';
?>


<section class="title">
    <div class="title-text">
        <input type="text">
        <h1>Bienvenido a la Página de Recetas</h1>
        <p>Descubre, comparte y disfruta las mejores recetas caseras.</p>
        <a href="views/recipes/add.php" class="btn btn-primary">Añadir tu Receta</a>
    </div>
</section>
<section class="featured-recipes">
    <h2>Recetas Destacadas</h2>
    <div class="recipe-grid">
        <div class='recipe-item'>
            <img src='' alt='Receta'>
            <h3>Título de la Receta</h3>
            <p>Descripción breve de la receta...</p>
            <a href='' class='btn btn-secondary'>Ver Receta</a>
        </div>
    </div>
</section>


<?php
//incluye el script para la actualizacion de la session y que se mantenga abierta
include BASE_PATH . '/public/js/sessionScript.php';
$content = ob_get_clean(); // Guarda el contenido en $content
include BASE_PATH . '/views/layout.php'; // Incluye la plantilla principal
