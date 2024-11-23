/*
* es muy importante declarar la cosnt id
*si se quiere obtener las recetas por id o no se pone null
*
*/

async function fetchRecetaDetail(id) {
    console.log(id)
    try { 
        const url = `<?php echo BASE_URL . '/controllers/RecipeController.php?action=getRecipeDetail&id=${id}'; ?>`;
        const response = await fetch(url, {
            method: 'GET',
        });

        if (!response.ok) {
            throw new Error('Error en la solicitud');
        }

        const recipe = await response.json();

        if (recipe) {
            console.log(recipe)
            cargarRecetaDetail(recipe); // Asegúrate de acceder al primer elemento si es un array de objetos
        } else {
            console.warn('Error: posible problema con la respuesta del servidor', recipe);
        }
    } catch (error) {
        console.error('Error al obtener los detalles de la receta:', error);
    }
}

// Renderizar detalle de la receta
function cargarRecetaDetail(receta) {
    if (!receta) {
        console.error("La receta no se encontró.");
        return;
    }
    const recetaFinal = receta[0];
    const ingredienteFinal = receta[1]

    const container = document.querySelector('.detalle-receta');

    container.innerHTML = `
        <h1>Receta: ${recetaFinal[0]['titulo'] ?? 'Título no disponible'}, id: ${recetaFinal[0]['id']}</h1>
        <div class="imagen">
            <img class="img-index" src="<?php echo BASE_URL; ?>/public/img/${recetaFinal[0]['imagen']}" alt="Receta ${recetaFinal[0]['titulo']}">
        </div>
        <p><strong>Tiempo de preparación:</strong> ${recetaFinal[0]['tiempo'] ?? 'No especificado'}</p>
        <p><strong>Descripción:</strong> ${recetaFinal[0]['descripcion'] ?? 'No disponible'}</p>
        <p><strong>Pasos:</strong> ${recetaFinal[0]['pasos'] ?? 'No especificados'}</p>
        <p><strong>Ingredientes:</strong> 
            ${ingredienteFinal.map(r => r.ingrediente).join(', ') || 'No especificados'}
        </p>

    `;
}