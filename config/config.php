<?php
define('BASE_PATH', dirname(__DIR__)); 

require_once BASE_PATH . '/helpers/envLoader.php';

// Cargar variables de entorno
loadEnv(BASE_PATH . '/.env');

define('BASE_URL', getenv('BASE_URL')); 
define('DB_HOST', getenv('DB_HOST'));
define('DB_USER', getenv('DB_USER'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));
define('DB_NAME', getenv('DB_NAME'));

define('CONEXION_DB', BASE_PATH . '/helpers/databaseConexion.php');

?>