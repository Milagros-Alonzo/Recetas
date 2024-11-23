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




    <div class="detaller-receta-container">
        <h1>Detalles de la Receta</h1>
        <div class="detalle-receta">
            <!-- Aquí se cargarán los detalles de la receta -->
        </div>
            <div class="mostrar-comentarios">
                <h2>Comentarios</h2>
                <div class="tuComentario-container">
                    <form id="subir-comentario" action="<?php echo BASE_URL . '/controllers/CommentController.php'; ?>" method="post" enctype="multipart/form-data">
                        <div class="imagen-perfil-container">
                        <img src="<?php echo BASE_URL . '/public/img/' . (isset($_SESSION['profile_image']) ? $_SESSION['profile_image'] : 'default.png'); ?>" alt="tu perfil" class="imagen-perfil">
                        </div>
                        <div class="input-area">
                            <div class="textarea-container">
                                <textarea name="tuComentario" id="tu-comentario-texbox" placeholder="Escribe tu comentario aqui"></textarea>
                            </div>
                            <div class="btn-container">
                                <div class="rating" id="rating">
                                    <i class="fa-regular fa-star" data-value="1"></i>
                                    <i class="fa-regular fa-star" data-value="2"></i>
                                    <i class="fa-regular fa-star" data-value="3"></i>
                                    <i class="fa-regular fa-star" data-value="4"></i>
                                    <i class="fa-regular fa-star" data-value="5"></i>
                                </div>

                                <p id="fecha"></p>
                                <input type="hidden" id="selected-rating" name="rating" value="0"></input>
                                <input type="hidden" id="receta_id" name="receta_id" value="<?php  echo isset($_GET['id']) ? $_GET['id'] : 0; ?>">
                                <input type="hidden" id="user_id" name="user_id" value="<?php  echo isset($_SESSION['user']) ? $_SESSION['user']: ''; ?>">
                                <button 
                                    type="submit" 
                                    id="btn-borrar-comentario" 
                                    name="action" 
                                    value="borrarComentario"
                                    <?php echo isset($_SESSION['user']) ? '' : 'data-logged-in="false"'; ?>
                                    onclick="return confirm('¿Estás seguro de que deseas borrar este comentario?');"
                                >Borrar
                                </button>

                                <button 
                                    type="submit" 
                                    id="btn-subir-comentario" 
                                    name="action" 
                                    value="subirComentario"
                                    <?php echo isset($_SESSION['user']) ? '' : 'data-logged-in="false"'; ?>
                                >subir</button>
                            </div>
                        </div>                
                    </form>
                </div>
                <div id="comentarios-lista-container">
                        <!-- Aquí se mostrarán los comentarios cargados con JavaScript -->
                </div>
            </div>

    </div>

    <script>   
        <?php include BASE_PATH . '/public/js/fetch_recipeDetail.js'; ?>;
        <?php 
            if(isset($_SESSION['user'])) {
                include BASE_PATH . '/public/js/fetch_comments.js'; 
            }
        ?>
        
        document.addEventListener('DOMContentLoaded', function() {
                let receta_id = "<?php  echo isset($_GET['id']) ? $_GET['id'] : 0; ?>";
                let user_id =  "<?php  echo isset($_SESSION['user']) ? $_SESSION['user']: ''; ?>";

                if (typeof getComment_id === 'function') {
                    getComment_id(receta_id, user_id);
                }
                fetchRecetaDetail(receta_id);
                getCommentAll(receta_id);
        });

        mensaje = <?php echo json_encode($mensaje); ?>;
        console.log(mensaje);
        if(mensaje) {
            alert(mensaje)
            <?php
                $_SESSION['mensaje'] = '';
            ?>
        }


        //manejas el bootn se subir comentarios
        document.getElementById('btn-subir-comentario').addEventListener('click', function(e) {
            // Verificar si el usuario está logueado
            if (this.getAttribute('data-logged-in') === 'false') {
                alert('Debes iniciar sesión para poder subir un comentario.');
                e.preventDefault();
            } else {
                if(this.innerText === 'actualizar') {
                    return;
                }
                // Si está logueado, permite el envío
                document.getElementById('subir-comentario').submit();
            }
        });


        //manejas el bootn se subir comentarios
        document.getElementById('btn-borrar-comentario').addEventListener('click', function(e) {
            // Verificar si el usuario está logueado
            if (this.getAttribute('data-logged-in') === 'false') {
                e.preventDefault();
                alert('Debes iniciar sesión para poder borrar un comentario.');
                return;
            } else {
                if(this.innerText === 'actualizar') {
                    return;
                }
                // Si está logueado, permite el envío
                document.getElementById('subir-comentario').submit();
            }
        });


        //manejar la funcionalidad de las estrellas
        const stars = document.querySelectorAll('.rating .fa-star');
        const ratingDisplay = document.getElementById('selected-rating');
        stars.forEach(star => {
            
            star.addEventListener('click', () => {
                console.log('hola')
                const rating = star.getAttribute('data-value');
                // Remover clase "filled" de todas las estrellas
                stars.forEach(s => s.classList.remove('filled'));
                // Agregar clase "filled" hasta la estrella seleccionada
                for (let i = 0; i < rating; i++) {
                    console.log(i)
                    stars[ i ].classList.add('filled');
                }
                // Mostrar la calificación seleccionada
                ratingDisplay.value = rating;
            });
        });
    </script>

<?php
//incluye el script para la actualizacion de la session y que se mantenga abierta
//include BASE_PATH . '/public/js/sessionScript.php';
$content = ob_get_clean(); // Guarda el contenido en $content
include BASE_PATH . '/views/layout.php'; // Incluye la plantilla principal