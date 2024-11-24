<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../helpers/databaseConexion.php';

class Comment
{
    private $id;
    private $receta_id;
    private $user_id;
    private $comentario;
    private $estrellas;
    private $fecha;

    public function __construct($receta_id = null, $user_id = null, $comentario = null, $estrellas = null, $fecha = null)
    {
        $this->receta_id = $receta_id;
        $this->user_id = $user_id;
        $this->comentario = $comentario;
        $this->estrellas = $estrellas;
        $this->fecha = $fecha;
    }

    // Métodos para la base de datos

    public static function getComentario_RecetaId($receta_id)
    {
        $pdo = getConnection();
        $stmt = $pdo->prepare("
        SELECT 
            comentarios.*, 
            usuarios.nombre AS nombre_usuario 
        FROM 
            comentarios
        JOIN 
            usuarios 
        ON 
            comentarios.user_id = usuarios.id
        WHERE 
            comentarios.receta_id = :receta_id
        ORDER BY 
            comentarios.fecha DESC
    ");
        $stmt->execute(['receta_id' => $receta_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getComentario_UserId_recetaId($receta_id, $user_id)
    {
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT * FROM comentarios WHERE user_id = :user_id and receta_id = :receta_id ORDER BY fecha DESC");
        $stmt->execute(['user_id' => $user_id, 'receta_id' => $receta_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getComentario_UserId($user_id)
    {
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT 1 FROM comentarios WHERE user_id = :user_id ORDER BY fecha DESC");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function save()
    {
        $pdo = getConnection();
        $stmt = $pdo->prepare("INSERT INTO comentarios (receta_id, user_id, comentario, estrellas) VALUES (:receta_id, :user_id, :comentario, :estrellas)");
        return $stmt->execute([
            'receta_id' => $this->receta_id,
            'user_id' => $this->user_id,
            'comentario' => $this->comentario,
            'estrellas' => $this->estrellas
        ]);
    }

    public function update()
    {
        $pdo = getConnection();
        $stmt = $pdo->prepare("
            UPDATE comentarios 
            SET 
                comentario = :comentario, 
                estrellas = :estrellas 
            WHERE 
                receta_id = :receta_id 
                AND user_id = :user_id
        ");
        
        return $stmt->execute([
            'comentario' => $this->comentario,
            'estrellas' => $this->estrellas,
            'receta_id' => $this->receta_id,
            'user_id' => $this->user_id
        ]);
    
    }

    public function delete_Id_recetaId($user_id, $receta_id)
    {
        $pdo = getConnection();
        $stmt = $pdo->prepare("DELETE FROM comentarios WHERE user_id = :user_id and receta_id = :receta_id");
        return $stmt->execute(['user_id' => $user_id, 'receta_id' => $receta_id]);
    }


    // Getters y Setters

    public function getId() { return $this->id; }
    public function setId($id) { $this->id = $id; }

    public function getRecetaId() { return $this->receta_id; }
    public function setRecetaId($receta_id) { $this->receta_id = $receta_id; }

    public function getUserId() { return $this->user_id; }
    public function setUserId($user_id) { $this->user_id = $user_id; }

    public function getComentario() { return $this->comentario; }
    public function setComentario($comentario) { $this->comentario = $comentario; }

    public function getEstrellas() { return $this->estrellas; }
    public function setEstrellas($estrellas) 
    { 
        if ($estrellas >= 1 && $estrellas <= 5) {
            $this->estrellas = $estrellas; 
        } else {
            throw new Exception("Las estrellas deben estar entre 1 y 5.");
        }
    }

    public function getFecha() { return $this->fecha; }
    public function setFecha($fecha) { $this->fecha = $fecha; }
}
