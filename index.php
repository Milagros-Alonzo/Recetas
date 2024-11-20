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
    mensaje = <?php echo json_encode($mensaje ?? ''); ?>;
    console.log(mensaje);
    if(mensaje) {
        alert(mensaje)
        <?php
            $_SESSION['mensaje'] = '';
        ?>
    }


    async function fetchRecetas() {
        try {
            const response = await fetch("<?php echo BASE_URL . '/controllers/RecipeController.php?action=getRecipe' ?>", {
                method: 'GET',
            });

            if (!response.ok) {
                throw new Error('Error en la solicitud');
            }

            const result = await response.json();

            if (result.success) {
                console.log('Recetas:', result.data);
                cargarRecetas(result.data);
            } else {
                console.error('Error:', result.message);
            }
        } catch (error) {
            console.error('Error al obtener las recetas:', error);
        }
    }

            const recetas = [];

    // Renderizar recetas
    function cargarRecetas(recetas) {
        console.log(recetas)

        const container = document.querySelector('.container-receta');
        container.innerHTML = recetas.map(recipe => `
            <div class="card">
                <div class="titulo"><Strong>${recipe.titulo}</Strong></div>
                <hr>
                <div class="imagen">
                    <img class="img-index" src="<?php echo BASE_URL; ?>/public/img/${recipe.imagen}" alt="Receta 1">
                </div>
                <div class="autor">${recipe.nombre_usuario}</div>
                <div class="tiempo">${recipe.tiempo}</div>
            </div>
        `).join('');
    }

    // Llamar a la función para renderizar
    
    document.addEventListener('DOMContentLoaded',  fetchRecetas());
    </script>

<?php
//incluye el script para la actualizacion de la session y que se mantenga abierta
include BASE_PATH . '/public/js/sessionScript.php';
$content = ob_get_clean(); // Guarda el contenido en $content
include BASE_PATH . '/views/layout.php'; // Incluye la plantilla principal
