<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="public/css/styles.css"></head>
<body>
 <?php   
include 'templates/header.php';
?>
<div class="parent-container">
    <div class="main-content">
            <section class="title">
                <div class="title-text">
                    <h1>Bienvenido a la Página de Recetas</h1>
                    <p>Descubre, comparte y disfruta las mejores recetas caseras.</p>
                    <a href="views/recipes/add.php" class="btn btn-primary">Añadir tu Receta</a>
                </div>
            </section>
            <section class="featured-recipes">
                <h2>Recetas Destacadas</h2>
                <div class="recipe-grid">
                    <?php
                    // Código para listar recetas destacadas.
                    // Ejemplo de receta destacada.
                    echo "<div class='recipe-item'>
                            <img src='public/images/placeholder.jpg' alt='Receta'>
                            <h3>Título de la Receta</h3>
                            <p>Descripción breve de la receta...</p>
                            <a href='views/recipes/detail.php?id=1' class='btn btn-secondary'>Ver Receta</a>
                          </div>";
                    ?>
                </div>
            </section>
        </div>
</div>



<?php
include 'templates/footer.php';
?>   
</body>
</html>
