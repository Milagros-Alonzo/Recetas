<?php
    require_once __DIR__ . '/../models/User.php';
    require_once __DIR__ . '/../helpers/Validator.php';
    require_once __DIR__ . '/../config/config.php'; 

    class AuthController {
        private $usuarioModel;

        public function __construct()
        {
            $this->usuarioModel = new User(); // Instancia del modelo
        }    
         
        public function guardarUsuario($datos)
        {
            session_start();
            try {
                // Validar datos usando Validator
                $datosValidados = Validator::validateUserData($datos);
    
                // llamar al constructor y asignar los valores
                $this->usuarioModel = new User(
                    $datosValidados['nombre'],
                    $datosValidados['email'],
                    $datosValidados['password'],
                );
                
                // Llama al modelo para guardar los datos
                $id = $this->usuarioModel->insertUser();

                if ($id) {
                    // Crear sesión para el usuario registrado
                    $_SESSION['user_id'] = $id;
                    $_SESSION['user_name'] = $datosValidados['nombre'];
                    $_SESSION['user_email'] = $datosValidados['email'];
                    $_SESSION['user_role'] = $datosValidados['rol'];
        
                    // Devuelve un éxito indicando que la sesión se inició
                    return header('location: ' . BASE_URL . '/index.php');
                } else {
                    $_SESSION['mensaje'] = 'Error al registrar el usuario';
                    // Manejar errores de validación
                    return header('location: ' . BASE_URL . '/views/auth/login.php');              
                }
    
            } catch (Exception $e) {
                $_SESSION['mensaje'] = 'Algo salió mal!. ' . $e->getMessage();
                // Manejar errores de validación
                return header('location: ' . BASE_URL . '/views/auth/login.php');
            }
        }

        public function login($data) 
        {
            session_start();
            try {
                // Validar y sanitizar los datos
                $datosValidados = Validator::validateLoginData($data);
                
                $email = $datosValidados['email'];
                $password = $datosValidados['password'];
        
                if (!$email) {
                    $_SESSION['mensaje'] = 'El correo electrónico no es válido.';
                    // Manejar errores de validación
                    return header('location: ' . BASE_URL . '/views/auth/login.php');    
                }
        
                if (empty($password)) {
                    $_SESSION['mensaje'] = 'La contraseña no puede estar vacía.';
                    // Manejar errores de validación
                    return header('location: ' . BASE_URL . '/views/auth/login.php');   
                }
        
                // Buscar al usuario en la base de datos
                $user = $this->usuarioModel->findUserByEmail($email);
        
                if (!$user) {
                    $_SESSION['mensaje'] = 'El usuario no existe.';
                    // Manejar errores de validación
                    return header('location: ' . BASE_URL . '/views/auth/login.php');   
                }
                
                // Verificar contraseña

                if (!password_verify($password, $user['contrasena'])) {
                    $_SESSION['mensaje'] = 'La contraseña es incorrecta.';
                    // Manejar errores de validación
                    return header('location: ' . BASE_URL . '/views/auth/login.php'); 
                }
        
                // Iniciar sesión
                $_SESSION['user'] = $user['id'];
                $_SESSION['user_name'] = $user['nombre'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['es_admin'] = $user['rol'] ?? 'usuario';
        
                return header("Location: " . BASE_URL . "/index.php");
        
            } catch (Exception $e) {
                // Manejar errores y redirigir al login con un mensaje
                $_SESSION['mensaje'] = $e->getMessage();
                header("Location: " . BASE_URL . "/views/auth/login.php");
                exit;
            }
        }
        
    }
   
    /*
    *
    * Procesar solicitud del form de login
    *
    */
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new AuthController();
        //
        if ($_POST['action'] === 'register') {
            echo 'hola';
            $controller->guardarUsuario($_POST);
        } elseif ($_POST['action'] === 'login') {
            $controller->login($_POST);
        }
    }  