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
    public static function getAllUsers() { 
        $pdo = getConnection();
        $sql = "SELECT id, nombre, email, rol, fecha_registro FROM usuarios";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para contar todos los usuarios
    public static function countAllUsers()
    {
        $pdo = getConnection();
        $sql = "SELECT COUNT(*) AS total FROM usuarios";
        $stmt = $pdo->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['total'] ?? 0;
    }

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

    

    public function validatePasswordResetToken($token) {
        $pdo = getConnection();
    
        $sql = "SELECT * FROM usuarios 
                WHERE reset_token = :reset_token 
                AND reset_token_expire > NOW()";
        $stmt = $pdo->prepare($sql);
    
        $stmt->execute([
            ':reset_token' => $token,
        ]);
    
        return $stmt->fetch(PDO::FETCH_ASSOC); // Devuelve los datos del usuario si el token es válido
    }
    
    

    public function findUserByResetToken($token){
        $pdo = getConnection();
        $sql = "SELECT * FROM usuarios WHERE reset_token = :reset_token AND reset_token_expire > NOW() LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':reset_token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword($userId, $hashedPassword){
        $pdo = getConnection();
        $sql = "UPDATE usuarios SET contrasena = :contrasena WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':contrasena' => $hashedPassword, ':id' => $userId]);
        return $stmt->rowCount() > 0;
    }

    public function deletePasswordResetToken($userId){
        $pdo = getConnection();
        $sql = "UPDATE usuarios SET reset_token = NULL, reset_token_expire = NULL WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $userId]);
    }

    

 
 // Getters y Setters.....

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