<?php
require_once __DIR__ . '/config/config.php';
$title = "Página de Recetas";
ob_start(); // Inicia el almacenamiento en búfer de salida

// incluye la creacion de la session y la revificacion de ella
include BASE_PATH . '/include/session/createSession.php';
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
            const recetas = [
        {
            "id": 1,
            "author": "mi amor",
            "titulo": "Tacos de Pollo",
            "description": "Deliciosos tacos con pollo marinado y vegetales frescos.",
            "tiempo": "30 minutos",
            "ingredientes": "[30gm de tomtate ,2 cucharas de mantequilla]",
            "imagen" : "path"
        },
        {
            "id": 2,
            "titulo": "Ensalada César",
            "description": "Clásica ensalada César con aderezo casero.",
            "tiempo": "1 hora",
            "author": "María López"
        },
        {
            "id": 3,
            "titulo": "Pasta Alfredo",
            "description": "Pasta cremosa con salsa Alfredo y queso parmesano.",
            "tiempo": "40 minutos",
            "author": "Carlos Gómez"
        },
        {
            "id": 4,
            "titulo": "Ensalada César",
            "description": "Clásica ensalada César con aderezo casero.",
            "tiempo": "1 hora",
            "author": "María López"
        },
        {
            "id": 5,
            "titulo": "Ensalada César",
            "description": "Clásica ensalada César con aderezo casero.",
            "tiempo": "1 hora",
            "author": "María López"
        },
    ];

    // Renderizar recetas
    function cargarRecetas(recetas) {
        console.log(recetas)

        const container = document.querySelector('.container-receta');
        container.innerHTML = recetas.map(recipe => `
            <div class="card">
                <div class="titulo"><Strong>${recipe.titulo}</Strong></div>
                <hr>
                <div class="imagen">
                    <img class="img-index" src="<?php echo BASE_URL . '/public/img/gato.png'; ?>" alt="Receta 1">
                </div>
                <div class="autor">${recipe.author}</div>
                <div class="tiempo">${recipe.tiempo}</div>
            </div>
        `).join('');
    }

    // Llamar a la función para renderizar
    document.addEventListener('DOMContentLoaded',  cargarRecetas(recetas));
    </script>

<?php
//incluye el script para la actualizacion de la session y que se mantenga abierta
include BASE_PATH . '/public/js/sessionScript.php';
$content = ob_get_clean(); // Guarda el contenido en $content
include BASE_PATH . '/views/layout.php'; // Incluye la plantilla principal
