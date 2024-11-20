<header>
    <nav>
        <ul>
            <?php
            // Verificar si el usuario está logueado
            if (isset($_SESSION['user'])): ?>
                <?php if ($_SESSION['es_admin'] === 'admin'): ?>
                    <li><a href="">Usuarios</a></li>
                    <li><a href="">Panel de Control</a></li>
                <?php endif; ?>
                <li><a href="<?php echo BASE_URL; ?>">Ver Receta</a></li>
                <li><a href="<?php echo BASE_URL . '/views/recipes/add.php'; ?>">Agregar Receta</a></li>
                <li><a href="<?php echo BASE_URL . '/include/session/cerrarSession.php'; ?> ">Cerrar Sesión</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
