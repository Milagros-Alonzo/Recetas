<?php
    require_once __DIR__ . '/../models/User.php';
    require_once __DIR__ . '/../helpers/Validator.php';


    class AuthController {
        private $usuarioModel;

        public function __construct()
        {
            $this->usuarioModel = new User(); // Instancia del modelo
        }    
    
        public function guardarUsuario($datos)
        {
            try {
                // Validar datos usando Validator
                $datosValidados = Validator::validateUserData($datos);
    

                $this->usuarioModel = new User(
                    $datosValidados['nombre'],
                    $datosValidados['email'],
                    $datosValidados['password'],
                );
                
                // Llama al modelo para guardar los datos
                $id = $this->usuarioModel->insertUser();
    
                return $id; // Devuelve el ID del usuario insertado
    
            } catch (Exception $e) {
                // Manejar errores de validación
                return ['error' => $e->getMessage()];
            }
        }
    }



    // Procesar solicitud del form de login
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new AuthController();
        //
        if ($_POST['action'] === 'register') {
            $resultado = $controller->guardarUsuario($_POST);

            if (isset($resultado['error'])) {
                echo "Error: " . $resultado['error'];
            } else {
                echo "Usuario registrado con ID: " . $resultado;
            }
        } elseif ($_POST['action'] === 'login') {
            //$resultado = $controller->login($_POST['email'], $_POST['password']);

            if (isset($resultado['error'])) {
                echo "Error: " . $resultado['error'];
            } else {
                header("Location: ../views/dashboard.php");
            }
        }
    }