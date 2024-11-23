

<?php
require_once __DIR__ . '/../../config/config.php';

$token = $_GET['token'] ?? null;
if (!$token) {
    die("Token no válido.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/public/css/reset_password.css'; ?>">
</head>
<body>
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg reset-password-card">
        <h1 class="text-center mb-4">Restablecer Contraseña</h1>
        <form action="../../controllers/AuthController.php" method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <div class="mb-3">
                <label for="password" class="form-label">Nueva Contraseña</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Ingrese su nueva contraseña" required>
            </div>
            <div class="d-grid">
                <button type="submit" name="action" value="resetPassword" class="btn btn-primary">Restablecer Contraseña</button>
            </div>
        </form>
    </div>
</div>

<script src="<?php echo BASE_URL . '/public/js/reset_password.js'; ?>"></script>
</body>
</html>