<?php
class SessionManager
{
    private static $session_timeout = 300; // 5 minutos

    // Inicia la sesión si no está iniciada
    public static function startSession()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    // Verifica si el usuario está autenticado
    public static function requireAuth()
    {
        self::startSession();

        if (!isset($_SESSION['user'])) {
            header('location: ' . BASE_URL . "/views/auth/login.php");
            exit();
        }

        self::checkSessionTimeout();
    }

    // Verifica si la sesión ha expirado y la destruye si es necesario
    public static function checkSessionTimeout()
    {
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > self::$session_timeout) {
            session_unset();
            session_destroy();
            header('location: ' . BASE_URL . "/views/auth/login.php");
            exit();
        }

        // Actualiza la marca de tiempo de la última actividad
        $_SESSION['LAST_ACTIVITY'] = time();
    }

    // Establece un mensaje en la sesión
    public static function setMessage($message)
    {
        self::startSession();
        $_SESSION['mensaje'] = $message;
    }

    // Obtiene y limpia el mensaje de la sesión
    public static function getMessage()
    {
        self::startSession();
        if (isset($_SESSION['mensaje'])) {
            $message = $_SESSION['mensaje'];
            unset($_SESSION['mensaje']);
            return $message;
        }

        return null;
    }
}

