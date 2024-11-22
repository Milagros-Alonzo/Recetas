<?php
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../config/config.php';

class CommentController {
    private $commentModel;

    public function __construct() {
        $this->commentModel = new Comment();
    }

    public function addComment($data) {
        session_start();
        if (!isset($_SESSION['user'])) {
            $_SESSION['mensaje'] = 'Debe iniciar sesión para comentar.';
            header('Location: ' . BASE_URL . '/views/auth/login.php');
            exit();
        }

        $userId = $_SESSION['user'];
        $recetaId = $data['receta_id'];
        $comentario = $data['comentario'];
        $estrellas = $data['estrellas'];

        try {
            $this->commentModel->saveComment($userId, $recetaId, $comentario, $estrellas);
            $_SESSION['mensaje'] = 'Comentario añadido exitosamente.';
            header('Location: ' . BASE_URL . '/views/recipe/detail.php?id=' . $recetaId);
        } catch (Exception $e) {
            $_SESSION['mensaje'] = 'Error al añadir comentario: ' . $e->getMessage();
            header('Location: ' . BASE_URL . '/views/recipe/detail.php?id=' . $recetaId);
        }
    }
}

// Procesar la solicitud del formulario
$controller = new CommentController();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'addComment') {
    $controller->addComment($_POST);
}
