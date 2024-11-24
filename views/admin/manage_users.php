<?php
require_once __DIR__ . '/../../config/config.php';
$title = "Gestionar Usuarios";
ob_start();
?>

<div class="container mt-5">
    <h1 class="mb-4">Gestionar Usuarios</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['nombre']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['rol']); ?></td>
                <td>
                    <a href="../../controllers/AdminController.php?action=promoteUser&id=<?php echo $user['id']; ?>" class="btn btn-success btn-sm">Promover a Admin</a>
                    <a href="../../controllers/AdminController.php?action=demoteUser&id=<?php echo $user['id']; ?>" class="btn btn-warning btn-sm">Degradar a Usuario</a>
                    <a href="../../controllers/AdminController.php?action=deleteUser&id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
$content = ob_get_clean();
include BASE_PATH . '/views/layout.php';
