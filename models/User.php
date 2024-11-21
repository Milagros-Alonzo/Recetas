<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../helpers/databaseConexion.php';
class user {
    private $nombre;
    private $email;
    private $contrasena;
    private $rol;
    private $token_sesion;



    // Constructor
    public function __construct($nombre = null, $email = null,  $contrasena = null, $rol = 'usuario', $token_sesion = null)
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->contrasena = $contrasena;
        $this->rol = $rol;
        $this->token_sesion = $token_sesion;
    }
 
     /*
    *
    *las consultas a base de datos
    *
    */
    public function insertUser(){
        $pdo = getConnection();

        $sql = "INSERT INTO usuarios (nombre, email, contrasena, rol, fecha_registro) 
        VALUES (:nombre, :email, :contrasena, :rol, NOW())";

        $stmt = $pdo->prepare($sql);

        // Encripta la contraseña
        
        $hashPassword = password_hash($this->contrasena, PASSWORD_BCRYPT);

        $stmt->execute([
            ':nombre' => $this->nombre,
            ':email' => $this->email,
            ':contrasena' => $hashPassword,
            ':rol' => $this->rol,
        ]);

        return $pdo->lastInsertId();
    }


    public function findUserByEmail($email)
    {
        $pdo = getConnection();

        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':email' => $email
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC); // devuelve toda la info del usuario
    }
 
    public function savePasswordResetToken($userId, $token)
    {
        $pdo = getConnection(); // Obtiene la conexión a la base de datos
    
        $sql = "UPDATE usuarios 
                SET reset_token = :reset_token, reset_token_expire = DATE_ADD(NOW(), INTERVAL 1 HOUR) 
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':reset_token' => $token,
            ':id' => $userId
        ]);
    
        return $stmt->rowCount() > 0; // Devuelve true si se actualizó al menos una fila
    }
 
 // Getters y Setters

 public function getNombre() { return $this->nombre; }
 public function setNombre($nombre) { $this->nombre = $nombre; }

 public function getEmail() { return $this->email; }
 public function setEmail($email) { $this->email = $email; }

 public function getContrasena() { return $this->contrasena; }
 public function setContrasena($contrasena) { $this->contrasena = $contrasena; }

 public function getRol() { return $this->rol; }
 public function setRol($rol) { $this->rol = $rol; }

 public function getTokenSesion() { return $this->token_sesion; }
 public function setTokenSesion($token_sesion) { $this->token_sesion = $token_sesion; }




}


?>