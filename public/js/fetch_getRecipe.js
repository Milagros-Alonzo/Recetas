/*
* es muy importante declarar la cosnt id
*si se quiere obtener las recetas por id o no se pone null
*
*/



async function fetchRecetas() {
    try {
        user_id = id ? id : null;

        const url = user_id
            ? `<?php echo BASE_URL . '/controllers/RecipeController.php?action=getRecipe&id=${user_id}'; ?>`
            : `<?php echo BASE_URL . '/controllers/RecipeController.php?action=getRecipe'; ?>`;
        const response = await fetch(url, {
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

// Renderizar recetas
function cargarRecetas(recetas) {
    console.log(recetas);

    const container = document.querySelector('.container-receta');
    container.innerHTML = recetas.map(recipe => `
        <div class="receta-contenedor" onclick="window.location.href='<?php echo BASE_URL; ?>/views/recipes/detail.php?id=${recipe.id}'">
            <div class="titulo"><strong>${recipe.titulo}</strong></div>
            <hr>
            <div class="imagen">
                <img class="img-index" src="<?php echo BASE_URL; ?>/public/img/${recipe.imagen}" alt="Receta ${recipe.titulo}">
            </div>
            <div class="autor">${recipe.nombre_usuario}</div>
            <div class="tiempo">${recipe.tiempo}</div>
        </div>
    `).join('');
}

// Llamar a la función para renderizar
document.addEventListener('DOMContentLoaded', fetchRecetas);

