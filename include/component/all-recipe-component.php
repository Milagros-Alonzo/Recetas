<?php
include BASE_PATH . '/controllers/RecipeController.php';

$recipeController = new RecipeController();
if(isset($_SESSION['es_admin']) && $_SESSION['es_admin'] ==  'administrador') {
    $recetas = json_decode($recipeController->getAllRecipe());
    if (isset($recetas[0]->user_id)) $_SESSION['now_user_id'] = $recetas[0]->user_id;

}else {
    if(isset($id) && $id != '') {
        $recetas = json_decode($recipeController->getRecipe($id));
        if (isset($recetas[0]->user_id)) $_SESSION['now_user_id'] = $recetas[0]->user_id;
    }else {
        $recetas = json_decode($recipeController->getAllRecipe());
    }
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
            <div class="autor">Autor: <?= $receta->nombre_usuario; ?></div>
            
            <p id="ingrediente" style="display:none"><strong>Ingredientes:</strong> 
                <?php if (!empty($receta->ingrediente)) { ?>
                    <?= implode(', ', array_map(fn($ing) => htmlspecialchars($ing->ingrediente), $receta->ingrediente)); ?>
                <?php } else { ?>
                    No especificados
                <?php } ?>
            </p>
            <div class="tiempo">tiempo de preparacion: <?= $receta->tiempo ? $receta->tiempo : 'No especificado'; ?></div>
        </div>
        <div id="noResults" style="display: none; text-align: center; margin-top: 20px;">
            <h2>No se encontraron recetas.</h2>
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
    const noResults = document.getElementById('noResults');

    searchInput.addEventListener('input', () => {
        const searchTerm = searchInput.value.toLowerCase(); // Convertir el texto a minúsculas

        let hasVisible = false;
        recipeCards.forEach(card => {
            const title = card.querySelector('.titulo strong').textContent.toLowerCase();
            const author = card.querySelector('.autor').textContent.toLowerCase();
            const tipoComida = card.querySelector('.tipo_comida').textContent.toLowerCase();
            const tiempo = card.querySelector('.tiempo').textContent.toLowerCase();
            const ingerdiente = card.querySelector('#ingrediente').textContent.toLowerCase();

            // Mostrar o esconder el card según el término de búsqueda
            if (title.includes(searchTerm) || author.includes(searchTerm) || tipoComida.includes(searchTerm) || tiempo.includes(searchTerm) || ingerdiente.includes(searchTerm)) {
                card.classList.remove('hidden');
                hasVisible = true;
            } else {
                card.classList.add('hidden');
            }

            if (!hasVisible) {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
            }
        });
    });
});
</script>