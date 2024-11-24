<?php

require_once __DIR__ . '/../models/Recipe.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../include/session/SessionManager.php';

class AdminController
{
    public function dashboard()
    {

        // Inicia la sesión usando SessionManager
        SessionManager::startSession();

        $this->checkAdmin();

        
        // Obtener estadísticas
        $totalRecetas = Recipe::countAllReceipes();
        $totalUsuarios = User::countAllUsers();
        //$totalComentarios = Comment::countAll();

        // Redirigir al dashboard con estadísticas
        include BASE_PATH . '/views/admin/dashboard.php';
    }

    private function checkAdmin()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user_role'] !== 'administrador') {
            $_SESSION['mensaje'] = 'Acceso denegado. Solo administradores pueden acceder.';
            header('Location: ' . BASE_URL . '/views/auth/login.php');
            exit();
        }
    }

    public function manageRecipes()
    {
        // Inicia la sesión usando SessionManager
        SessionManager::startSession();

        $this->checkAdmin();

        // Obtener todas las recetas
        $recipes = Recipe::getAllReceipes();

        // Redirigir a la vista de gestión de recetas
        include BASE_PATH . '/views/admin/manage_recipes.php';
    }

    public function manageUsers()
    {
        // Inicia la sesión usando SessionManager
        SessionManager::startSession();

        $this->checkAdmin();

        // Obtener todos los usuarios
        $users = User::getAllUsers();

        // Redirigir a la vista de gestión de usuarios
        include BASE_PATH . '/views/admin/manage_users.php';
    }
    
    public function deleteRecipe($id)
    {
        // Inicia la sesión usando SessionManager
        SessionManager::startSession();

        $this->checkAdmin();

        if (Recipe::deleteById($id)) {
            $_SESSION['mensaje'] = 'Receta eliminada con éxito.';
        } else {
            $_SESSION['mensaje'] = 'Error al eliminar la receta.';
        }

        header('Location: ' . BASE_URL . '/views/admin/manage_recipes.php');
        exit();
    }
    /*
    public function deleteComment($id)
    {
        session_start();
        $this->checkAdmin();

        if (Comment::deleteById($id)) {
            $_SESSION['mensaje'] = 'Comentario eliminado con éxito.';
        } else {
            $_SESSION['mensaje'] = 'Error al eliminar el comentario.';
        }

        header('Location: ' . BASE_URL . '/views/admin/manage_comments.php');
        exit();
    }
    */

    /*
    public function manageComments()
    {
        session_start();
        $this->checkAdmin();

        // Obtener todos los comentarios
        $comments = Comment::getAll();

        // Redirigir a la vista de gestión de comentarios
        include BASE_PATH . '/views/admin/manage_comments.php';
    }
    */
}

// Procesar las solicitudes de administración
$controller = new AdminController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'dashboard':
                $controller->dashboard();
                break;
            case 'manageRecipes':
                $controller->manageRecipes();
                break;
            case 'manageUsers':
                $controller->manageUsers();
                break;
            /*case 'manageComments':
                $controller->manageComments();
                break;
            */
            default:
                header('Location: ' . BASE_URL . '/views/admin/dashboard.php');
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'deleteRecipe':
                $controller->deleteRecipe($_POST['id']);
                break;
            /*    
            case 'deleteComment':
                $controller->deleteComment($_POST['id']);
                break;
            */
        }
    }
}
