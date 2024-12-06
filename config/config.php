<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Cargar el archivo .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Definir constantes con las variables de entorno
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
define('DB_NAME', $_ENV['DB_NAME']);

define('BASE_PATH', dirname(__DIR__));
define('BASE_URL', $_ENV['BASE_URL']);

define('CONEXION_DB', $_ENV['CONEXION_DB']);
