<?php
function getConnection()
{
    $host = DB_HOST;
    $database = DB_NAME;
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", DB_USER, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (Exception $err) {
        die("Error de conexión: " . $err->getMessage());
    }
} 

function closeConnection($pdo) 
{
    $pdo = null;
}