async function fetchRecetaDetail(id, BASE_URL) {

    try {
        const url = `${BASE_URL}/controllers/RecipeController.php?action=getRecipe&id=${id}`;
        console.log('Fetching URL:', url);

        const response = await fetch(url, {
            method: 'GET',
        });

        if (!response.ok) {
            throw new Error('Error en la solicitud');
        }

        const result = await response.json();

        if (result.success) {
            console.log('Detalle de la Receta:', result.data);
            cargarRecetaDetail(result.data[0]); // Asegúrate de acceder al primer elemento si es un array de objetos
        } else {
            console.error('Error:', result.message);
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

    const container = document.querySelector('.detalle-receta');

    container.innerHTML = `
        <h1>${receta.titulo ?? 'Título no disponible'}</h1>
        <p><strong>Tiempo de preparación:</strong> ${receta.tiempo ?? 'No especificado'}</p>
        <p><strong>Descripción:</strong> ${receta.descripcion ?? 'No disponible'}</p>
        <p><strong>Pasos:</strong> ${receta.pasos ?? 'No especificados'}</p>
        <p><strong>Ingredientes:</strong> ${receta.ingredientes ?? 'No especificados'}</p>
       <?php if (!empty(\$receta['imagen'])): ?>
            <img src="<?php echo BASE_URL; ?>/public/img/<?php echo htmlspecialchars(\$receta['imagen']); ?>" alt="Imagen de <?php echo htmlspecialchars(\$receta['titulo']); ?>">
        <?php endif; ?>

    `;
}



// Renderizar detalle de la receta
function cargarRecetaDetail(receta) {
    const container = document.querySelector('.detalle-receta');
    container.innerHTML = `
        <h1>${receta.titulo}</h1>
        <p><strong>Tiempo de preparación:</strong> ${receta.tiempo}</p>
        <p><strong>Descripción:</strong> ${receta.descripcion}</p>
        <p><strong>Pasos:</strong> ${receta.pasos}</p>
        <p><strong>Ingredientes:</strong> ${receta.ingredientes}</p>
      <?php if (!empty($receta['imagen']) && file_exists(BASE_PATH . '/public/img/' . $receta['imagen'])): ?>
    <img src="<?php echo BASE_URL; ?>/public/img/<?php echo htmlspecialchars($receta['imagen']); ?>" alt="Imagen de <?php echo htmlspecialchars($receta['titulo']); ?>">
<?php else: ?>
    <p>Imagen no disponible</p>
<?php endif; ?>

<button onclick="window.location.href='<?php echo BASE_URL; ?>../../index.php'" class="btn-volver">Volver al Inicio</button>

    `;
}
