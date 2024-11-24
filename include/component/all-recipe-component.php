<?php
include BASE_PATH . '/controllers/RecipeController.php';

$recipeController = new RecipeController();

if(isset($id) && $id != '') {
    $recetas = json_decode($recipeController->getRecipe($id));
    if (isset($recetas[0]->user_id)) $_SESSION['now_user_id'] = $recetas[0]->user_id;
}else {
    $recetas = json_decode($recipeController->getAllRecipe());
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
            <div class="tipo_comida">Tipo Comida: <?= $receta->tipo_comida; ?></div>
            <div class="receta_id">id de la receta: <?= $receta->id; ?></div>
            <div class="autor">Autor: <?= $receta->nombre_usuario; ?></div>
            <div class="tiempo">tiempo de preparacion: <?= $receta->tiempo ? $receta->tiempo : 'No especificado'; ?></div>
        </div>

    <?php endforeach ?>
    <?php else: ?>
        <h1> No hay recetas disponibles</h1>
<?php endif ?>


<script>
    //funcionalidad de filtro
    document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const recipeCards = document.querySelectorAll('.receta-contenedor.card');
    searchInput.addEventListener('input', () => {
        const searchTerm = searchInput.value.toLowerCase(); // Convertir el texto a minúsculas
        recipeCards.forEach(card => {
            const title = card.querySelector('.titulo strong').textContent.toLowerCase();
            const author = card.querySelector('.autor').textContent.toLowerCase();
            const tipoComida = card.querySelector('.tipo_comida').textContent.toLowerCase();
            const tiempo = card.querySelector('.tiempo').textContent.toLowerCase();

            // Mostrar o esconder el card según el término de búsqueda
            if (title.includes(searchTerm) || author.includes(searchTerm) || tipoComida.includes(searchTerm) || tiempo.includes(searchTerm)) {
                card.classList.remove('hidden');
            } else {
                card.classList.add('hidden');
            }
        });
    });
});
</script>