<?php
require_once __DIR__ . '/../../config/config.php';

$title = "Iniciar Sesión"; 
ob_start();
?>

<div class="container">
    <!-- Login Form -->
    <div id="login-form" class="form-container active">
        <h2>Iniciar Sesión</h2>
        <form>
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" placeholder="Ingresa tu correo" required>
            
            <label for="password">Contraseña</label>
            <input type="password" id="password" placeholder="Ingresa tu contraseña" required>
            
            <label>
                <input type="checkbox"> Recordarme
            </label>
            
            <button type="submit">Iniciar Sesión</button>
        </form>
        <p class="toggle-btn" onclick="toggleForms()">¿No tienes una cuenta? Regístrate aquí</p>
    </div>

    <!-- Register Form -->
    <div id="register-form" class="form-container">
        <h2>Registrarse</h2>
        <form>
            <label for="name">Nombre Completo</label>
            <input type="text" id="name" placeholder="Ingresa tu nombre completo" required>
            
            <label for="email-register">Correo Electrónico</label>
            <input type="email" id="email-register" placeholder="Ingresa tu correo" required>
            
            <label for="password-register">Contraseña</label>
            <input type="password" id="password-register" placeholder="Crea una contraseña" required>
            
            <button type="submit">Registrarse</button>
        </form>
        <p class="toggle-btn" onclick="toggleForms()">¿Ya tienes una cuenta? Inicia Sesión aquí</p>
    </div>
</div>


<?php
$content = ob_get_clean(); 
include BASE_PATH . '/views/layout.php'; 

