<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../helpers/databaseConexion.php';


class Recipe
{
    private $user_id;
    private $titulo;
    private $descripcion;
    private $pasos;
    private $tiempo;
    private $ingredientes;
    private $imagen;
    private $tipoComida;

    public function __construct($user_id = null, $titulo = null, $descripcion = null, $pasos = null, $tiempo = null,  $imagen = null, $tipocomida = null) {
        $this->user_id = $user_id;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->pasos = $pasos;
        $this->tiempo = $tiempo;
        $this->imagen = $imagen;
        $this ->tipoComida = $tipocomida;
    }

    public static function getAll()
    {
        $pdo = getConnection();
        $stmt = $pdo->prepare("
            SELECT 
                recetas.*,
                usuarios.nombre AS nombre_usuario
            FROM recetas
            INNER JOIN usuarios ON recetas.user_id = usuarios.id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getByUserId($id)
    {
        $pdo = getConnection();
        $stmt = $pdo->prepare("
            SELECT 
                recetas.*,
                usuarios.nombre AS nombre_usuario
            FROM 
                recetas
            INNER JOIN 
                usuarios 
            ON 
                recetas.user_id = usuarios.id
            WHERE 
                recetas.user_id = :id
        ");
    
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public static function getById($id)
    {
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT * FROM recetas WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save()
    {
        $pdo = getConnection();
        $stmt = $pdo->prepare(
            "INSERT INTO recetas (user_id, titulo, descripcion, pasos, tiempo, imagen,tipo_comida)
             VALUES (:user_id, :titulo, :descripcion, :pasos, :tiempo, :imagen, :tipo_comida)"
        );
        $stmt->execute([
            'user_id' => $this->user_id,
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'pasos' => $this->pasos,
            'tiempo' => $this->tiempo,
            'imagen' => $this->imagen,
            'tipo_comida' => $this ->tipoComida
        ]);

        return $pdo->lastInsertId();
    }

    public static function deleteById($id)
    {
        $pdo = getConnection();
        $stmt = $pdo->prepare("DELETE FROM recetas WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function update($id)
    {
        $pdo = getConnection();
        $stmt = $pdo->prepare(
            "UPDATE recetas 
            SET titulo = :titulo, 
                descripcion = :descripcion, 
                pasos = :pasos, 
                tiempo = :tiempo, 
                imagen = :imagen
            WHERE id = :id"
        );

        return $stmt->execute([
            'id' => $id,
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'pasos' => $this->pasos,
            'tiempo' => $this->tiempo,
            'imagen' => $this->imagen
        ]);
    }

    public function updateNoImg($id)
    {
        $pdo = getConnection();
        $stmt = $pdo->prepare(
            "UPDATE recetas 
            SET titulo = :titulo, 
                descripcion = :descripcion, 
                pasos = :pasos, 
                tiempo = :tiempo
            WHERE id = :id"
        );

        return $stmt->execute([
            'id' => $id,
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'pasos' => $this->pasos,
            'tiempo' => $this->tiempo,
        ]);
    }

    
    // Getters y Setters

    public function getUserId() { return $this->user_id; }
    public function setUserId($user_id) { $this->user_id = $user_id; }

    public function getTitulo() { return $this->titulo; }
    public function setTitulo($titulo) { $this->titulo = $titulo; }

    public function getDescripcion() { return $this->descripcion; }
    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }

    public function getPasos() { return $this->pasos; }
    public function setPasos($pasos) { $this->pasos = $pasos; }

    public function getTiempo() { return $this->tiempo; }
    public function setTiempo($tiempo) { $this->tiempo = $tiempo; }

    public function getImagen() { return $this->imagen; }
    public function setImagen($imagen) { $this->imagen = $imagen; }

    public function getTipoComida() { return $this->tipoComida; }
    public function setTipoComida($tipoComida) { $this->tipoComida = $tipoComida; }

    // Métodos para la base de datos
    
}
?>
