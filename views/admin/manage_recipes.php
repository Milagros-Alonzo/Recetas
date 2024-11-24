<?php
require_once __DIR__ . '/../../config/config.php';
$title = "Gestionar Recetas";
ob_start();
?>

<div class="container mt-5">
    <h1 class="mb-4">Gestionar Recetas</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Autor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($recipes as $recipe): ?>
            <tr>
                <td><?php echo htmlspecialchars($recipe['id']); ?></td>
                <td><?php echo htmlspecialchars($recipe['titulo']); ?></td>
                <td><?php echo htmlspecialchars($recipe['descripcion']); ?></td>
                <td><?php echo htmlspecialchars($recipe['nombre_usuario']); ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $recipe['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                    <a href="../../controllers/AdminController.php?action=deleteRecipe&id=<?php echo $recipe['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta receta?');">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
$content = ob_get_clean();
include BASE_PATH . '/views/layout.php';
