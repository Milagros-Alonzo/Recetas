<header>
    
    <nav>
        <ul>
        <li><a href="<?php echo BASE_URL; ?>">Inicio</a></li>
        <li><a href="<?php echo BASE_URL . '/views/recipes/list.php'; ?>">Ver Mis Receta</a></li>

        <li><a href="<?php echo BASE_URL . '/views/recipes/add.php'; ?>">Agregar Receta</a></li>

        <?php if (!isset($_SESSION['user'])): ?>
                <li><a href="<?php echo BASE_URL . '/views/auth/login.php'; ?>">Iniciar Sesión</a></li>
        <?php endif ?>

        
        
        <?php if (isset($_SESSION['user'])): ?>
            <!-- si eres admin mostrar lo de abajo -->
            <?php if ($_SESSION['es_admin'] === 'admin'): ?>
                <li><a href="">Usuarios</a></li>
                <li><a href="">Panel de Control</a></li>
            <?php endif; ?>
                <li><a href="<?php echo BASE_URL . '/include/session/cerrarSession.php'; ?> ">Cerrar Sesión</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
