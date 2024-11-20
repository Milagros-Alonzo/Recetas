<?php
require_once __DIR__ . '/config/config.php';
$title = "Página de Recetas";
ob_start(); // Inicia el almacenamiento en búfer de salida

// incluye la creacion de la session y la revificacion de ella
include BASE_PATH . '/include/session/createSession.php';
?>


    <main>
        <div class="recipe-container" id="recipeContainer">
            <!-- Las tarjetas se renderizan aquí dinámicamente -->
        </div>
    </main>

    <script>
            const recetas = [
        {
            "id": 1,
            "title": "Tacos de Pollo",
            "description": "Deliciosos tacos con pollo marinado y vegetales frescos.",
            "image": "https://via.placeholder.com/300x200?text=Tacos",
            "author": "Juan Pérez"
        },
        {
            "id": 2,
            "title": "Ensalada César",
            "description": "Clásica ensalada César con aderezo casero.",
            "image": "https://via.placeholder.com/300x200?text=Ensalada",
            "author": "María López"
        },
        {
            "id": 3,
            "title": "Pasta Alfredo",
            "description": "Pasta cremosa con salsa Alfredo y queso parmesano.",
            "image": "https://via.placeholder.com/300x200?text=Pasta",
            "author": "Carlos Gómez"
        }
    ];
    console.log(recetas)

    // Renderizar recetas
    function cargarRecetas(recetas) {
        console.log('hola')
        const container = document.getElementById('recipeContainer');
        container.innerHTML = recetas.map(recipe => `
            <div class="card">
                <img src="${recipe.image}" alt="${recipe.title}">
                <div class="card-content">
                    <h2 class="card-title">${recipe.title}</h2>
                    <p class="card-description">${recipe.description}</p>
                    <div class="card-footer">
                        <span>Autor: ${recipe.author}</span>
                    </div>
                </div>
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
