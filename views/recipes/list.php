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
    <div class="list-container">

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
        <form id="form-control-receta" action="<?= BASE_URL . '/controllers/RecipeController.php';?>" method="POST">
            <div class="controller-container-receta">
                <input type="hidden" id="valorFinal" name="valorFinal" value="" >
                <button 
                    type="submit" 
                    id="borrar-receta-user" 
                    superId="borrar"
                    superName="para borrar la receta"
                    class="ov-btn-grow-skew-reverse"
                    name="action" 
                    value="borrar-receta-user"
                >Borrar Receta?
                </button>
                <button 
                    type="button" 
                    id="actualizar-receta-user" 
                    superId="actualizar"
                    superName="la actualizacion?"
                    class="ov-btn-grow-skew-reverse"
                    name="action" 
                    value="actualizar-receta-user"
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

                <button 
                    type="button" 
                    id="confirmar" 
                    class="ov-btn-grow-skew-reverse disabled"
                    name="action" 
                    value="subir-receta-user"
                >Confirmar
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
</div>


    <script>
        const deleteBtn = document.getElementById('borrar-receta-user');
        const updateBtn = document.getElementById('actualizar-receta-user');
        const addBtn = document.getElementById('subir-receta-user');
        const confirm = document.getElementById('confirmar');
        const containerRecipe = document.querySelector('.list-container');
        const cards = document.querySelectorAll('.receta-contenedor');
        const inputValue = document.getElementById('valorFinal');

        const form = document.getElementById('form-control-receta');

        [deleteBtn, updateBtn].forEach(btn => {
            btn.addEventListener('click', event => {
                event.preventDefault();
                deleteBtn.classList.add('disabled');
                updateBtn.classList.add('disabled');
                addBtn.classList.add('disabled');
                containerRecipe.classList.add('disabled');
                let name = btn.getAttribute('superName')
                let id = btn.getAttribute('superId')

                confirm.innerHTML = "Confrimar, " + name;
                confirm.classList.add(id);
                confirm.classList.remove('disabled');
                // Agregar el listener para seleccionar cards
                cards.forEach(card => {
                    card.addEventListener('click', event => {
                        selectCard(event)
                    });
                });
            });
        });

        confirm.addEventListener('click', event => {
            event.preventDefault();
            deleteBtn.classList.remove('disabled');
            updateBtn.classList.remove('disabled');
            addBtn.classList.remove('disabled');
            containerRecipe.classList.remove('disabled');

            if (confirm.classList.contains('actualizar')) {
                if(inputValue.value) {
                    const url = `<?= BASE_URL . '/views/recipes/add.php?getId=';?>${inputValue.value}`;
                    console.log(url)
                    alert('debe seleccionar una receta')
                    window.location.href=url
                }else {
                    alert('debe seleccionar una receta')
                }
            } else if (confirm.classList.contains('borrar')) {
                console.log('casi se borra')
                form.submit(); // Ejecutar el método de envío del formulario
            }

            confirm.className = 'ov-btn-grow-skew-reverse disabled';

            // Eliminar los listeners de las tarjetas
            cards.forEach(card => {
                card.removeEventListener('click', selectCard);
            });
        });

        // Listener para limpiar "unSelected" si haces clic fuera de las tarjetas
        document.addEventListener('click', event => {
            const clickedCard = event.target.closest('.receta-contenedor');
            if (!clickedCard) {
                // Si haces clic fuera de cualquier tarjeta, quitar la clase "unSelected"
                cards.forEach(card => {
                    card.classList.remove('unSelected');
                });
            }
        });

        function selectCard(event) {
            const card = event.currentTarget;
            const recipeId = card.getAttribute('id');
            
            console.log(`ID seleccionado: ${recipeId}`);
            inputValue.value = recipeId;

            // Agregar clase "unSelected" a todas las tarjetas excepto la seleccionada
            cards.forEach(card => {
                if (card.id !== recipeId) {
                    card.classList.add('unSelected');
                } else {
                    card.classList.remove('unSelected'); // Remover "unSelected" del seleccionado
                }
            });
        }


        cards.forEach(card => {
            card.addEventListener('click', () => locationCard(card));
        });

        function locationCard(card) {
            if(!containerRecipe.classList.contains('disabled')) {
                window.location.href='<?= BASE_URL . '/views/recipes/detail.php?id='; ?>' + card.id
            }
        }
    </script>

<?php
//incluye el script para la actualizacion de la session y que se mantenga abierta
include BASE_PATH . '/public/js/sessionScript.php';
$content = ob_get_clean(); // Guarda el contenido en $content
include BASE_PATH . '/views/layout.php'; // Incluye la plantilla principal