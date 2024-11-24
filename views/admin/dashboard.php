<?php
require_once __DIR__ . '/../../config/config.php';

$title = "Panel de Administración";

ob_start();
?>

<div class="container mt-5">
    <h1 class="mb-4">Panel de Administración</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total de Recetas</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($totalRecetas ?? 0); ?></h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total de Usuarios</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($totalUsuarios ?? 0); ?></h5>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">  
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Comentarios</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($totalComments ?? 0); ?></h5>
                </div>
            </div>
        </div>
        
        
    </div>
</div>

<?php
$content = ob_get_clean();
include BASE_PATH . '/views/layout.php';
