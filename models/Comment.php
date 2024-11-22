<?php
require_once __DIR__ . '/../helpers/databaseConexion.php';

class Comment {
    public function saveComment($userId, $recetaId, $comentario, $estrellas) {
        $pdo = getConnection();

        // Insertar el comentario en la tabla comentarios
        $sqlComentario = "INSERT INTO comentarios (receta_id, user_id, comentario, fecha) 
                          VALUES (:receta_id, :user_id, :comentario, NOW())";
        $stmt = $pdo->prepare($sqlComentario);
        $stmt->execute([
            ':receta_id' => $recetaId,
            ':user_id' => $userId,
            ':comentario' => $comentario
        ]);

        // Insertar la valoración en la tabla valoraciones
        $sqlValoracion = "INSERT INTO valoraciones (receta_id, user_id, estrellas, fecha) 
                          VALUES (:receta_id, :user_id, :estrellas, NOW())";
        $stmt = $pdo->prepare($sqlValoracion);
        $stmt->execute([
            ':receta_id' => $recetaId,
            ':user_id' => $userId,
            ':estrellas' => $estrellas
        ]);
    }

    public function getCommentsByRecipeId($recetaId) {
        $pdo = getConnection();
        $sql = "SELECT comentarios.comentario, comentarios.fecha, usuarios.nombre 
                FROM comentarios 
                INNER JOIN usuarios ON comentarios.user_id = usuarios.id
                WHERE comentarios.receta_id = :receta_id
                ORDER BY comentarios.fecha DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':receta_id' => $recetaId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
