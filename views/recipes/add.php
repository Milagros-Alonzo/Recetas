<?php
require_once __DIR__ . '/../../config/config.php';
$title = "Agregar Recetas";
ob_start(); // Inicia el almacenamiento en búfer de salida

// incluye la creacion de la session y la revificacion de ella
include BASE_PATH . '/include/session/SessionManager.php';

SessionManager::startSession();
SessionManager::requireAuth();
if (isset($_SESSION['user'])) {
    SessionManager::checkSessionTimeout();
}
$mensaje = SessionManager::getMessage();
?>

<div class="main-content">
    <div class="form-container-receta">
        <h1>Agregar de Recetas</h1>
        <hr>
        <form id="recipeForm" action="<?php echo BASE_URL . '/controllers/RecipeController.php'; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo" maxlength="100" required>
                <div class="error-message" id="tituloError"></div>
            </div>
            <div class="form-group">
                <label for="tipo_comida">Tipo de comida</label>
                <select id="tipo_comida" name="tipo_comida" required>
                    <option value="Desayunos">Desayunos</option>
                    <option value="Almuerzos" selected>Almuerzos</option>
                    <option value="Cenas">Cenas</option>
                </select>
                <div class="error-message" id="tipoComidaError"></div>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" required></textarea>
                <div class="error-message" id="descripcionError"></div>
            </div>
            <div class="form-group">
                <label for="pasos">Pasos:</label>
                <textarea id="pasos" name="pasos" required></textarea>
                <div class="error-message" id="pasosError"></div>
            </div>
            <div class="form-group">
                <label for="tiempo">Tiempo</label>
                <input type="text" id="tiempo" name="tiempo" maxlength="50" required>
                <div class="error-message" id="tiempoError"></div>
            </div>
            <div class="form-group" style="display: flex">
                <label for="newIngredient">Agregar un Ingrediente</label>
                <input type="text" id="newIngredient" placeholder="Ejemplo: 1 Tomate" maxlength="40">
                <button type="button" style="margin-left: 6px" onclick="AgregarIngredientes()">Agregar Ingrediente</button>

            </div>
            <div class="checkbox-group" id="checkboxGroup">
                <!-- Los ingredientes aparecerán aquí -->
            </div>
            <div class="form-group">
                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" required>
                <div class="error-message" id="imagenError"></div>
                <div id="vistaPrevia" style="margin-top: 20px;">
                    <img id="imagenPreview" src="" alt="Vista previa" style="display: none; max-width: 100%; height: auto;">
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" name="action" value="register">Guardar Receta</button>
            </div>
        </form>
    </div>
</div>


<script>
    mensaje = <?php echo json_encode($mensaje); ?>;
    console.log(mensaje);
    if (mensaje) {
        alert(mensaje)
        <?php
        $_SESSION['mensaje'] = '';
        ?>
    }

    // Validación sencilla con JavaScript
    document.getElementById('recipeForm').addEventListener('submit', function(event) {
        let isValid = true;

        // Limpia mensajes previos
        document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

        // Validación personalizada para campos requeridos
        // Lista de campos a validar
        const fields = ['titulo', 'descripcion', 'pasos', 'tiempo', 'tipo_comida', 'imagen'];

        fields.forEach(field => {
            const input = document.getElementById(field);
            if (!input.value) {
                document.getElementById(`${field}Error`).textContent = 'Este campo es obligatorio.';
                isValid = false;
            }
        });

        if (!isValid) {
            event.preventDefault();
        }
    });

    const inputImagen = document.getElementById('imagen');
    const vistaPrevia = document.getElementById('imagenPreview');

    // Escuchar cambios en el input file
    inputImagen.addEventListener('change', function(event) {
        const archivo = event.target.files[0];

        if (archivo) {
            const lector = new FileReader();

            // Cuando la lectura esté completa, mostrar la imagen
            lector.onload = function(e) {
                vistaPrevia.src = e.target.result;
                vistaPrevia.style.display = 'block'; // Mostrar la imagen
            };

            lector.readAsDataURL(archivo); // Leer el archivo como DataURL
        } else {
            vistaPrevia.src = '';
            vistaPrevia.style.display = 'none'; // Ocultar la imagen
        }
    });

    const ingredientes = document.getElementById('checkboxGroup');
    const inputIngrediente = document.getElementById('newIngredient');

    function AgregarIngredientes() {
        const ingredientesContainer = document.createElement('div');
        ingredientesContainer.className = 'checkbox-item';

        const input = document.createElement('input');

        input.readOnly = true;
        input.type = 'text';
        input.classList.add('input-ingrediente')
        input.name = 'ingrediente[]';
        input.value = inputIngrediente.value

        const deleteButton = document.createElement('button');
        deleteButton.type = 'button';
        deleteButton.textContent = 'Eliminar';
        deleteButton.className = 'delete-btn';

        deleteButton.addEventListener('click', () => {
            if (confirm('deseas eleminar este ingrediente?')) {
                ingredientes.removeChild(ingredientesContainer);
            }
        });

        ingredientesContainer.appendChild(input);
        ingredientesContainer.appendChild(deleteButton);

        ingredientes.appendChild(ingredientesContainer);

        inputIngrediente.value = '';
    }
</script>

<?php
//incluye el script para la actualizacion de la session y que se mantenga abierta
include BASE_PATH . '/public/js/sessionScript.php';
$content = ob_get_clean(); // Guarda el contenido en $content del html
include BASE_PATH . '/views/layout.php'; // Incluye la plantilla principal