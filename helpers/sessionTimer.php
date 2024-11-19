<?php
session_start();

// Configura el tiempo máximo de inactividad (en segundos)
$session_timeout = 300; // 5 minutos

if (isset($_SESSION['LAST_ACTIVITY'])) {
    // Comprueba si la sesión ha expirado
    if ((time() - $_SESSION['LAST_ACTIVITY']) > $session_timeout) {
        session_unset();
        session_destroy();
        echo json_encode(['status' => 'error', 'message' => 'Sesión expirada']);
    } else {
        // Si la sesión no ha expirado, actualiza la última actividad
        $_SESSION['LAST_ACTIVITY'] = time();
        echo json_encode(['status' => 'success', 'message' => 'Sesión actualizada']);
    }
} else {
    // Si no hay registro de actividad, la sesión está expirada
    echo json_encode(['status' => 'error', 'message' => 'Sesión no iniciada o expirada']);
}
exit();
