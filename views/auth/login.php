<?php
require_once __DIR__ . '/../../config/config.php';

$title = "Iniciar Sesión"; 
ob_start();

session_start();
if(isset($_SESSION['mensaje'])){
    $mensaje = $_SESSION['mensaje'];
}else {
    $mensaje = '';
}

if(isset($_SESSION['user'])){
    if($_SESSION['es_admin'] === true){
        //header("location: pages/adminHome.php");
    }else {
        //header("location: pages/Home.php");
    }
}
?>

<div class="container">
    <!-- Login Form -->
    <div id="login-form" class="form-container active">
        <h2>Iniciar Sesión</h2>
        <form action="../../controllers/AuthController.php" method="POST">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" placeholder="Ingresa tu correo" required>
            
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>
            <label>
                <input type="checkbox" id="recordarme" name="recordarme"> Recordarme
            </label>
            
            <button type="submit" name="action" value="login">Iniciar Sesión</button>
        </form>
        <p class="toggle-btn" onclick="toggleForms()">¿No tienes una cuenta? Regístrate aquí</p>
    </div>

    <!-- Registrarse Form -->
    <div id="register-form" class="form-container">
        <h2>Registrarse</h2>
        <form action="../../controllers/AuthController.php" method="POST">
            <label for="nombre">Nombre Completo</label>
            <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu nombre completo" required>
            
            <label for="email-register">Correo Electrónico</label>
            <input type="email" id="email-register" name="email" placeholder="Ingresa tu correo" required>
            
            <label for="password-register">Contraseña</label>
            <input type="password" id="password-register" name="password" placeholder="Crea una contraseña" required>


            <button type="submit" name="action" value="register">Registrarse</button>
        </form>
        <p class="toggle-btn" onclick="toggleForms()">¿Ya tienes una cuenta? Inicia Sesión aquí</p>
    </div>
</div>

<script>
    mensaje = <?php echo json_encode($mensaje); ?>;
    console.log(mensaje);
    if(mensaje) {
        alert(mensaje)

        <?php
            $_SESSION['mensaje'] = '';
        ?>
    }
</script>

<?php
$content = ob_get_clean(); 
include BASE_PATH . '/views/layout.php'; 

