<?php
require_once BASE_PATH . '/config/config.php';

session_start();
session_destroy();

header("Location:" . BASE_URL . "/views/auth/login.php");
?>