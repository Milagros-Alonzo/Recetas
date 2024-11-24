<?php
require_once __DIR__ . '/../../config/config.php';
$title = "Recetas Detalladas";
ob_start(); // Inicia el almacenamiento en búfer de salida

//llamar todas las funciones del controlador
include BASE_PATH . '/controllers/RecipeController.php';
include BASE_PATH . '/controllers/CommentController.php';
include BASE_PATH . '/include/session/SessionManager.php';

SessionManager::startSession();
$CommentController = new CommentController();
$recipeController = new RecipeController();
$recipe_id = $_GET['id'];


if(isset($_SESSION['user'])) {
    $_SESSION['now_user_id']= $_SESSION['user'];
    SessionManager::checkSessionTimeout();
    $user_id = $_SESSION['user'];
    $comment_user = json_decode($CommentController->getCommentId([
        'user_id' => $user_id,
        'receta_id' => $recipe_id,
    ]));   
}
$commentAll = json_decode($CommentController->getComment([
    'receta_id' => $recipe_id,
])); 
$receta_detail = json_decode($recipeController->getRecipeDetail([
    'recipe_id' => $recipe_id,
]));
$mensaje = SessionManager::getMessage();


?>




    <div class="detaller-receta-container">
        <h1>Detalles de la Receta</h1>
        <div class="detalle-receta">
            <?php if(isset($receta_detail)): ?>
                <?php foreach($receta_detail[0] as $receta): ?>
                    <?php if(!empty($receta)): ?>
                        <h1>Receta: <?= $receta->titulo ?? 'Título no disponible' ?></h1>
                        <div class="imagen">
                            <img 
                                class="img-index" 
                                src="<?= BASE_URL; ?>/public/img/<?= $receta->imagen ?? 'default.png' ?>" 
                                alt="Receta <?= htmlspecialchars($receta->titulo ?? 'Sin título') ?>">
                        </div>
                        <p><strong>Tiempo de preparación:</strong> <?= $receta->tiempo ?? 'No especificado' ?></p>
                        <p><strong>Descripción:</strong> <?= $receta->descripcion ?? 'No disponible' ?></p>
                        <p><strong>Pasos:</strong> <?= $receta->pasos ?? 'No especificados' ?></p>
                        <p><strong>Ingredientes:</strong> 
                            <?= !empty($receta_detail[1]) 
                                ? implode(', ', array_column($receta_detail[1], 'ingrediente')) 
                                : 'No especificados' ?>
                        </p>
                    <?php endif ?>
                <?php endforeach ?>
            <?php endif ?>
        </div>
            <div class="mostrar-comentarios">
                <h2>Comentarios</h2>
                <div class="tuComentario-container">
                    <form id="subir-comentario" action="<?php echo BASE_URL . '/controllers/CommentController.php'; ?>" method="post" enctype="multipart/form-data">
                        <div class="imagen-perfil-container">
                        <img src="<?php echo BASE_URL . '/public/img/' . (isset($_SESSION['profile_image']) ? $_SESSION['profile_image'] : ''); ?>" alt="tu perfil" class="imagen-perfil">
                        </div>
                        <div class="input-area">
                            <div class="textarea-container">
                                <textarea name="tuComentario" id="tu-comentario-texbox" placeholder="Escribe tu comentario aqui"></textarea>
                            </div>
                            <div class="btn-container">
                                <div class="rating" id="rating">
                                    <i class="fa-regular fa-star real" data-value="1"></i>
                                    <i class="fa-regular fa-star real" data-value="2"></i>
                                    <i class="fa-regular fa-star real" data-value="3"></i>
                                    <i class="fa-regular fa-star real" data-value="4"></i>
                                    <i class="fa-regular fa-star real" data-value="5"></i>
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
                    <?php if (!empty($commentAll)): ?>
                        <?php foreach ($commentAll as $comment): ?>
                            <?php 
                                $nowUserId = isset($_SESSION['now_user_id']) ? $_SESSION['now_user_id'] : ''; 
                                if ($comment->user_id != $nowUserId): ?>
                                <form action="<?php echo BASE_URL . '/controllers/CommentController.php'; ?>" method="post" style="width: 100%; height: 100%;">
                                <div class="comentario">
                                        <input type="hidden" name="commentId" value="<?php echo $comment->id; ?>">
                                        <input type="hidden" name="receta_id" value="<?php echo $comment->receta_id; ?>">

                                        <div class="imagen-perfil-container"> 
                                            <img 
                                            src="<?= BASE_URL; ?>/public/img/<?= $comment->imagen_perfil ?? 'default.png'; ?>" 
                                            class="imagen-perfil"
                                            >
                                        </div>
                                        <div class="comentario-contenido">
                                            <div class="usuario"><?= htmlspecialchars($comment->nombre_usuario); ?></div>
                                            <div class="texto"><?= htmlspecialchars($comment->comentario); ?></div>
                                            <div class="btn-container" style="display:flex; justify-content: space-between;">
                                                <div class="rating">
                                                    <?php for ($i = 0; $i < 5; $i++): ?>
                                                        <i class="<?= $i < $comment->estrellas ? 'fa-solid' : 'fa-regular'; ?> fa-star"></i>
                                                    <?php endfor; ?>
                                                </div>
                                                <?php if(isset($_SESSION['es_admin']) && $_SESSION['es_admin'] ==  'administrador'): ?>
                                                    <button 
                                                        style="margin-right: 50px; margin-top:10px; width:100px;"
                                                        type="submit" 
                                                        id="btn-borrar-comentario" 
                                                        name="action" 
                                                        value="borrarComentarioAdmin"
                                                        <?php echo isset($_SESSION['user']) ? '' : 'data-logged-in="false"'; ?>
                                                        onclick="return confirm('¿Estás seguro de que deseas borrar este comentario?');"
                                                    >Borrar
                                                    </button>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

    </div>

        <?php if(isset($comment_user)): ?>
            <script>    
                    const commentUser = <?php echo json_encode($comment_user); ?>;
                    if(commentUser.length > 0) {
                        const comentarios = document.getElementById("tu-comentario-texbox");
                        const fecha = document.getElementById('fecha');
                        const estrella = document.querySelectorAll('.tuComentario-container .rating .fa-star');
                        const estrallaInput = document.getElementById('selected-rating');
                        const estrellaAsignado = commentUser[0]['estrellas'];
                        const tuComentario = document.querySelector('.tuComentario-container');
                        const btnComentario = document.getElementById('btn-subir-comentario');
                        const btnAction = document.getElementById('btn-subir-comentario');
                        
                        tuComentario.classList.add('disabled')
                        comentarios.value = commentUser[0]['comentario']
                        fecha.innerText = commentUser[0]['fecha']
                        estrallaInput.value = commentUser[0]['estrellas']
                        btnComentario.innerText = 'actualizar';
                        btnAction.value = 'updateComentario';



                        const manejarClick = event => {
                            event.preventDefault();
                        
                            setTimeout(() => {
                                btnComentario.innerText = 'subir';
                                tuComentario.classList.remove('disabled');
                        
                                // Eliminar el evento después de su ejecución
                                btnComentario.removeEventListener('click', manejarClick);
                            }, 100);
                        };
                        
                        // Añadir el manejador de eventos
                        btnComentario.addEventListener('click', manejarClick);
                        



                        for (let i = 0; i < estrellaAsignado; i++) {
                            estrella[ i ].classList.add('filled');
                        }
                    }
            </script>
        <?php endif ?>


    <script>   

        mensaje = <?php echo json_encode($mensaje); ?>;
        console.log(mensaje);
        if(mensaje) {
            alert(mensaje)
            <?php
                $_SESSION['mensaje'] = '';
            ?>
        }


        //manejas el bootn se subir comentarios (prevenir que el user suba si no a iniciado session)
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
                document.getElementById('btn-subir-comentario').submit();
            }
        });


        //manejas el bootn se subir comentarios  (prevenir que el user suba si no a iniciado session)
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
                document.getElementById('btn-borrar-comentario').submit();
            }
        });


        //manejar la funcionalidad de las estrellas
        const stars = document.querySelectorAll('.rating .fa-star.real');
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