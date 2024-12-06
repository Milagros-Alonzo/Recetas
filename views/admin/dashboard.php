<?php
require_once __DIR__ . '/../../config/config.php';
$title = "Administrador de usuarios";
ob_start();

include BASE_PATH . '/controllers/AdminController.php';

// Inicializar controlador
$adminController = new AdminController();

// Obtener lista de usuarios
$usuarios = json_decode($adminController->getAllUsers());

?>

    <div class="gestion-usuarios-container">
        <h1>Gestión de Usuarios</h1>
        <?php if (!empty($usuarios)): ?>
            <table class="tabla-usuarios">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= htmlspecialchars($usuario->id); ?></td>
                            <td><?= htmlspecialchars($usuario->nombre); ?></td>
                            <td><?= htmlspecialchars($usuario->email); ?></td>
                            <td><?= htmlspecialchars($usuario->rol); ?></td>
                            <td><?= htmlspecialchars($usuario->fecha_registro); ?></td>
                            <td>
                                <form action="<?= BASE_URL ?>/controllers/AdminController.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $usuario->id; ?>">
                                    <button type="submit" name="action" value="updateUser">Editar</button>
                                </form>
                                <form action="<?= BASE_URL ?>/controllers/AdminController.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $usuario->id; ?>">
                                    <button type="submit" name="action" value="deleteUser" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Borrar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay usuarios registrados.</p>
        <?php endif; ?>
    </div>



    <script>   

        mensaje = <?php echo json_encode($mensaje); ?>;
        console.log(mensaje);
        if(mensaje) {
            alert(mensaje)
            <?php
                $_SESSION['mensaje'] = '';
            ?>
        }
    </script>

<?php
//incluye el script para la actualizacion de la session y que se mantenga abierta
//include BASE_PATH . '/public/js/sessionScript.php';
$content = ob_get_clean(); // Guarda el contenido en $content
include BASE_PATH . '/views/layout.php'; // Incluye la plantilla principal