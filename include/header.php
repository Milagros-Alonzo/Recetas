<?php 
require_once __DIR__ . '/../config/config.php';
?>
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
                <li><a href="<?php echo BASE_URL; ?> /include/session/cerrarSession.php">Cerrar Sesión</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
