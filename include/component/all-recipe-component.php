<?php
include BASE_PATH . '/controllers/RecipeController.php';

$recipeController = new RecipeController();

if(isset($id) && $id != '') {
    $recetas = json_decode($recipeController->getRecipe($id));
    if (isset($recetas[0]->user_id)) $_SESSION['now_user_id'] = $recetas[0]->user_id;
}else {
    $recetas = json_decode($recipeController->getAllRecipe());
    var_dump($recetas);
}
?>
<?php if(isset($recetas) && !empty($recetas)): ?>
    <?php foreach($recetas as $receta): ?>

        <div class="receta-contenedor card" id="<?= $receta->id; ?>">
            <div class="titulo"><strong>Nombre: <?= $receta->titulo; ?></strong></div>
            <hr>
            <div class="imagen">
                <img class="img-index" src="<?= BASE_URL . '/public/img/' . $receta->imagen; ?>" alt="Receta">
            </div>
            <div class="receta_id">id de la receta: <?= $receta->id; ?></div>
            <div class="autor">Autor: <?= $receta->nombre_usuario; ?></div>
            <div class="tiempo">tiempo de preparacion: <?= $receta->tiempo ? $receta->tiempo : 'No especificado'; ?></div>
        </div>

    <?php endforeach ?>
    <?php else: ?>
        <h1> No hay recetas disponibles</h1>
<?php endif ?>