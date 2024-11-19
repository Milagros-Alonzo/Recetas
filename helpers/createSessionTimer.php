<?php
// Tiempo de expiración en segundos (5 minutos)
$session_timeout = 300; // 5 * 60 segundos

// Verifica si existe una marca de tiempo de la última actividad
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $session_timeout) {
    // La sesión ha expirado
    session_unset();
    session_destroy();
    header('location: ' . BASE_URL . "/views/auth/login.php"); // Redirige al usuario a la página de login
    exit();
}

// Actualiza la marca de tiempo de la última actividad
    $_SESSION['LAST_ACTIVITY'] = time();
