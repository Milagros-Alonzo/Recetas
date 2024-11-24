<?php
    require_once __DIR__ . '/../models/User.php';
    require_once __DIR__ . '/../helpers/Validator.php';
    require_once __DIR__ . '/../config/config.php'; 

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'forgot_password') {
        $controller = new AuthController();
        ob_clean(); // Limpia alguna salida previa
        $controller->forgotPassword($_POST['email']);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'resetPassword') {
        $controller = new AuthController();
        $controller->resetPassword($_POST);
    }
    
    


    class AuthController {
        private $usuarioModel;
        private $validator;

        public function __construct()
        {
            $this->usuarioModel = new User();// Instancia del modelo
            $this->validator = new Validator();
        }    
         
        public function guardarUsuario($datos)
        {
            session_start();
            try {
                // Validar datos usando Validator

                $rules = [
                    'nombre'=> [
                        'required' => true,
                        'string' =>  true,
                        'max' => 50,
                    ],
                    'email'=> [
                        'required' => true,
                        'email' => true,
                    ],
                    'password'=> [
                        'required' => true,
                        'string' => true,
                        'min' => 8,
                    ],
                ];
                
                if($this->validator->validate($datos, $rules)){
                    $nombre = $datos['nombre'];
                    $email = $datos['email'];
                    $password = $datos['password'];
                    
                    $this->usuarioModel = new User(
                        $nombre,
                        $email,
                        $password,
                    );
                    
                    // Llama al modelo para guardar los datos
                    $id = $this->usuarioModel->insertUser();
    
                    if ($id) {
                        // Crear sesión para el usuario registrado
                        $_SESSION['user'] = $id;
                        $_SESSION['user_name'] = $nombre;
                        $_SESSION['user_email'] = $email;
                        $_SESSION['es_admin'] = $datos['rol'] ?? 'usuario';
    
                        // Devuelve un éxito indicando que la sesión se inició
                        return header('location: ' . BASE_URL . '/index.php');
                    // llamar al constructor y asignar los valores
                    } else {
                        $_SESSION['mensaje'] = 'Error al registrar el usuario';
                        // Manejar errores de validación
                        return header('location: ' . BASE_URL . '/views/auth/login.php');              
                    }
                } else {
                    $err = $this->validator->getErrors();
                    var_dump($err);
                }
            } catch (Exception $e) {
                $_SESSION['mensaje'] = 'Algo salió mal!. ' . $e->getMessage();
                // Manejar errores de validación
                return header('location: ' . BASE_URL . '/views/auth/login.php');
            }
        }

        public function login($datos) 
        {
            session_start();
            try {

                $rules = [
                    'email' => [
                        'required' => true,
                        'email' => true,
                    ],
                    'password' => [
                        'required' => true,
                    ]
                ];

                if($this->validator->validate($datos, $rules)){
                    $email = $datos['email'];
                    $password = $datos['password'];
            
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
                } else {
                    // Datos no válidos, obtener errores
                    $errors = $this->validator->getErrors();
                    var_dump($errors);
                }
            } catch (Exception $e) {
                // Manejar errores y redirigir al login con un mensaje
                $_SESSION['mensaje'] = $e->getMessage();
                header("Location: " . BASE_URL . "/views/auth/login.php");
                exit;
            }
        }

        public function resetPassword($data)
        {
            require_once __DIR__ . '/../helpers/TokenGenerator.php';
            session_start();

            try {
                // Verificar que el token existe en la base de datos
                $token = $data['token'];
                $newPassword = $data['password'];

                if (empty($token) || empty($newPassword)) {
                    throw new Exception("Token o contraseña vacíos.");
                }

                $user = $this->usuarioModel->findUserByResetToken($token);
                if (!$user) {
                    throw new Exception("Token no válido o expirado.");
                }

                // Actualizar la contraseña
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                $this->usuarioModel->updatePassword($user['id'], $hashedPassword);

                // Eliminar el token de restablecimiento
                $this->usuarioModel->deletePasswordResetToken($user['id']);

                // Redirigir al inicio de sesión con un mensaje de éxito
                $_SESSION['mensaje'] = 'Contraseña actualizada correctamente. Por favor, inicia sesión.';
                header('Location: ' . BASE_URL . '/views/auth/login.php');
                exit();
            } catch (Exception $e) {
                // Manejo de errores
                $_SESSION['mensaje'] = 'Error al restablecer la contraseña: ' . $e->getMessage();
                header('Location: ' . BASE_URL . '/views/auth/reset_password.php?token=' . $token);
                exit();
            }
        }


        //configo de forgotPassword.....

        //funcion para recuperar contraseñas//
        public function forgotPassword($email)
        {
            require_once __DIR__ . '/../PHPMailer/PHPMailer.php';
            require_once __DIR__ . '/../PHPMailer/SMTP.php';
            require_once __DIR__ . '/../PHPMailer/Exception.php';
            require_once __DIR__ . '/../helpers/TokenGenerator.php';
        
            session_start();
        
            try {
                // Verificar si el correo existe en la base de datos
                $user = $this->usuarioModel->findUserByEmail($email);
                if (!$user) {
                    $_SESSION['mensaje'] = 'El correo no está registrado.';
                    header('Location: ' . BASE_URL . '/views/auth/forgot_password.php');
                    exit();
                }
        
                // Generar un token único
                $token = TokenGenerator::generate();
        
                // Guardar el token en la base de datos
                $this->usuarioModel->savePasswordResetToken($user['id'], $token);
        
                // Crear el enlace de recuperación
                $resetLink = "http://localhost" . BASE_URL . "/views/auth/reset_password.php?token=" . $token;
        
                // Configurar PHPMailer
                $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Cambia esto a tu servidor SMTP
                $mail->SMTPAuth = true;
                $mail->Username = 'alonzomilagros24@gmail.com'; // Cambia esto
                $mail->Password = 'csnw ufxs sswt hbor'; // Cambia esto
                $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
    

                // Configuración del correo
                $mail->setFrom('alonzomilagros24@gmail.com', 'Recetas Web');
                $mail->addAddress($email);
                $mail->CharSet = 'UTF-8'; // Establece la codificación UTF-8
                $mail->isHTML(true); // Activa el uso de HTML en el cuerpo del correo
                $mail->Subject = 'Recuperación de Contraseña';
                $mail->Body = "
                    <p>Hola,</p>
                    <p>Haz clic en el siguiente enlace para restablecer tu contraseña:</p>
                    <p><a href='$resetLink' target='_blank'>$resetLink</a></p>
                    <p>Si no solicitaste este cambio, puedes ignorar este correo.</p>";

        
                // Enviar correo
                $mail->send();
                $_SESSION['mensaje'] = 'Hemos enviado un enlace de recuperación a tu correo.';
                header('Location: ' . BASE_URL . '/views/auth/login.php');
                exit();
            } catch (Exception $e) {
                error_log('Error al enviar correo: ' . $e->getMessage());
                $_SESSION['mensaje'] = 'Error al enviar el correo. Intentar mas tarde ';
                header('Location: ' . BASE_URL . '/views/auth/forgot_password.php');
                exit();
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