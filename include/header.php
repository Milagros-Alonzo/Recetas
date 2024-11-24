<header>
    <nav>
        <ul>
            <!-- Enlace al Inicio -->
            <li><a href="<?php echo BASE_URL; ?>">Inicio</a></li>

            <!-- Enlace a "Mis Recetas" -->
            <li><a href="<?php echo BASE_URL . '/views/recipes/list.php'; ?>">Ver Mis Recetas</a></li>

            <!-- Enlace a "Agregar Receta" -->
            <li><a href="<?php echo BASE_URL . '/views/recipes/add.php'; ?>">Agregar Receta</a></li>

            <!-- Mostrar "Iniciar Sesión" si no hay un usuario autenticado -->
            <?php if (!isset($_SESSION['user'])): ?>
                <li><a href="<?php echo BASE_URL . '/views/auth/login.php'; ?>">Iniciar Sesión</a></li>
            <?php endif; ?>

         
            <?php if (isset($_SESSION['user'])): ?>
                <!-- Mostrar enlaces de administración solo si es administrador -->
                <?php if ($_SESSION['user_role'] === 'administrador'): ?>
                    <li><a href="<?php echo BASE_URL . '/index.php?action=manageUsers'; ?>">Usuarios</a></li>
                    <li><a href="<?php echo BASE_URL . '/index.php?action=manageRecipes'; ?>">Gestionar Recetas</a></li>
                    <li><a href="<?php echo BASE_URL . '/index.php?action=dashboard'; ?>">Panel de Control</a></li>
                <?php endif; ?>
                
                <!-- Opción para cerrar sesión -->
                <li><a href="<?php echo BASE_URL . '/include/session/cerrarSession.php'; ?>">Cerrar Sesión</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
