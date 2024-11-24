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
        <!-- llamar el componente -->
        <?php include BASE_PATH . '/include/component/all-recipe-component.php'; ?>
    </div>
</div>

<script>
document.getElementById('searchInput').addEventListener('keyup', function (event) {
    const searchTerm = this.value;

    // Crear un objeto con los filtros
    const filters = {
        titulo: searchTerm, // Búsqueda por título
        tipo_comida: '', // Puedes asignar el valor de un dropdown o input aquí
        ingrediente: '', // Opcional, si se necesita buscar por ingrediente
        tiempo: '' // Opcional, si se necesita filtrar por tiempo
    };

    // Enviar la búsqueda solo si el usuario presiona Enter o escribe más de 2 caracteres
    if (event.key === "Enter" || searchTerm.length > 2) {
        const resultsDiv = document.getElementById('results');
        resultsDiv.innerHTML = '<p>Cargando resultados...</p>'; // Mensaje de carga mientras se procesan los datos

        fetch('<?php echo BASE_URL; ?>/controllers/RecipeController.php?action=buscar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(filters),
        })
        .then(response => response.json())
        .then(data => {
            resultsDiv.innerHTML = ''; // Limpiar resultados anteriores

            if (Array.isArray(data) && data.length > 0) {
                data.forEach(recipe => {
                    const div = document.createElement('div');
                    div.innerHTML = `
                        <h3>${recipe.titulo}</h3>
                        <p><strong>Tipo de comida:</strong> ${recipe.tipo_comida}</p>
                        <p><strong>Tiempo:</strong> ${recipe.tiempo}</p>
                        <p><strong>Ingredientes:</strong> ${recipe.ingredientes}</p>
                    `;
                    resultsDiv.appendChild(div);
                });
            } else {
                resultsDiv.innerHTML = '<p>No se encontraron resultados.</p>'; // Mostrar mensaje si no hay resultados
            }
        })
        .catch(error => {
            console.error('Error:', error);
            resultsDiv.innerHTML = '<p>Ocurrió un error al buscar recetas. Inténtelo de nuevo.</p>';
        });
    }
});


</script>


<script>
    mensaje = <?php echo json_encode($mensaje ?? ''); ?>;
    console.log(mensaje);
    if(mensaje) {
        alert(mensaje);
        <?php
            $_SESSION['mensaje'] = '';
        ?>
    }
</script>

<?php
//incluye el script para la actualizacion de la session y que se mantenga abierta
//include BASE_PATH . '/public/js/sessionScript.php';
$content = ob_get_clean(); // Guarda el contenido en $content
include BASE_PATH . '/views/layout.php'; // Incluye la plantilla principal
