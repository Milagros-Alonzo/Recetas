<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../public/css/styles.css"></head>
<body>
 <?php   
include '../../templates/header.php';
?>
<div class="parent-container">
    <div class="contenedor-login">
            <form class="login" action="database-helper/consultas/login.php" style="margin: 0em;" method="POST">
                <div class="title">
                    <h1><i class="fa-solid fa-right-to-bracket"></i>      Login</h1>
                </div>
                <div class="input-container">
                    <div class="user-container">
                        <label for="user-input">User</label>
                        <input type="text" name="user" maxlength="20" class="user-input" autocomplete="off">
                    </div>
                    <div class="password-container">
                        <label for="password-input">Password</label>
                            <input type="password" name="password" maxlength="70" class="password-input" autocomplete="off">
                            <button type="button" class="btn btn-light view-btn"><i class='fa-regular fa-eye-slash eye-icon'></i></button>
                    </div>
                    <div class="submit-container">
                        <button type="submit" class="btn btn-light submit-btn">Enviar</button>
                    </div>
                    </div>
                    <div class="imagen-login">            
                        <img class="login-img" src="assets/animations/gato2.gif" type="video/gif">
                    </div>
            </form>
        </div>
</div>


<?php
include '../../templates/footer.php';
?>   
</body>
</html>
