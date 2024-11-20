<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../helpers/databaseConexion.php';


class Ingredient
{
    private $receta_id;
    private $ingrediente;

    public function __construct( $receta_id = null, $ingrediente = null)
    {
        $this->receta_id = $receta_id;
        $this->ingrediente = $ingrediente;
    }


    // Métodos para la base de datos
    public static function getAllByRecetaId($receta_id)
    {
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT * FROM ingredientes WHERE receta_id = :receta_id");
        $stmt->execute(['receta_id' => $receta_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save()
    {
        $pdo = getConnection();
         // Verificar si $this->ingrediente es un array
        if (is_array($this->ingrediente)) {
        
            foreach ($this->ingrediente as $ingrediente) {
                $stmt = $pdo->prepare("INSERT INTO ingredientes (receta_id, ingrediente) VALUES (:receta_id, :ingrediente)");
                $stmt->execute([
                    'receta_id' => $this->receta_id,
                    'ingrediente' => $ingrediente
                ]);
            }
            return true; // Éxito si todos los inserts se realizan correctamente
        } else {
            // Si no es un array, insertar un solo ingrediente
            $stmt = $pdo->prepare("INSERT INTO ingredientes (receta_id, ingrediente) VALUES (:receta_id, :ingrediente)");
            $stmt->execute([
                'receta_id' => $this->receta_id,
                'ingrediente' => $this->ingrediente
            ]);
            return true; // Éxito si el insert se realiza correctamente
        }
    }

    public static function deleteById($id)
    {
        $pdo = getConnection();
        $stmt = $pdo->prepare("DELETE FROM ingredientes WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }


    // Getters y Setters

    public function getRecetaId() { return $this->receta_id; }
    public function setRecetaId($receta_id) { $this->receta_id = $receta_id; }

    public function getIngrediente() { return $this->ingrediente; }
    public function setIngrediente($ingrediente) { $this->ingrediente = $ingrediente; }


}
?>
