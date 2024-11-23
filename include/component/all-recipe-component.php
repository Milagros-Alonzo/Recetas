<?php
include BASE_PATH . '/controllers/RecipeController.php';

$recipeController = new RecipeController();

if(isset($id) && $id != '') {
    $recetas = json_decode($recipeController->getRecipe($id));
}else {
    $recetas = json_decode($recipeController->getAllRecipe());
}
?>

<?php if(isset($recetas)): ?>
    <?php foreach($recetas as $receta): ?>

        <div class="receta-contenedor card" onclick="window.location.href='<?= BASE_URL . '/views/recipes/detail.php?id=' . $receta->id; ?>'">
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
<?php endif ?>