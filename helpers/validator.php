<?php


class Validator
{
    public static function validateUserData($data)
    {
        // Sanitizar y validar datos
        $nombre = trim($data['nombre']);
        $email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
        $password = trim($data['password']);
        $rol = trim($data['rol'] ?? '');

        if (!$email) {
            throw new Exception("El correo electrónico no es válido.");
        }

        if (strlen($password) < 8) {
            throw new Exception("La contraseña debe tener al menos 6 caracteres.");
        }

        // Devuelve los datos sanitizados
        return [
            'nombre' => $nombre,
            'email' => $email,
            'password' => $password,
            'rol' => $rol
        ];
    }

    public static function validateLoginData($data) {
        $email = filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL);
        $password = trim($data['password']);

        if (!$email) {
            throw new Exception("El correo electrónico no es válido.");
        }

        return [
            'email' => $email,
            'password' => $password,
        ];
    }


    public static function validateRecipeData($data,  $file)
    {   
        $titulo = htmlspecialchars(trim($data['titulo'] ?? ''), ENT_QUOTES);
        $descripcion = htmlspecialchars(trim($data['descripcion'] ?? ''), ENT_QUOTES);
        $pasos = htmlspecialchars(trim($data['pasos'] ?? ''), ENT_QUOTES);
        $tiempo = htmlspecialchars(trim($data['tiempo'] ?? ''), ENT_QUOTES);
        $ingredientes = isset($data['ingrediente']) && is_array($data['ingrediente']) 
            ? array_map('trim', $data['ingrediente']) 
            : [];
        $imagen = $file['imagen'] ?? null;
    
        // Validaciones
        if (empty($titulo)) {
            throw new Exception("El título no puede estar vacío.");
        }
    
        if (empty($descripcion)) {
            throw new Exception("La descripción no puede estar vacía.");
        }
    
        if (empty($pasos)) {
            throw new Exception("Los pasos no pueden estar vacíos.");
        }
    
        if (empty($tiempo)) {
            throw new Exception("El tiempo no puede estar vacío.");
        }
    
        if (empty($ingredientes)) {
            throw new Exception("Debe seleccionar al menos un ingrediente.");
        }
    
        // Retorno de datos validados
        return [
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'pasos' => $pasos,
            'tiempo' => $tiempo,
            'ingredientes' => $ingredientes,
            'imagen' => $imagen,
        ];
    }

    // Validar y cargar imagen
    public static function uploadImage($file, $uploadDir)
    {
        // Verificar errores
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('Error al subir la imagen.');
        }

        // Verificar tipo de archivo
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception('El tipo de archivo no es válido.');
        }

        // Generar nombre único para la imagen
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $uniqueName = uniqid('img_', true) . '.' . $extension;

        // Mover la imagen al directorio de destino
        $uploadPath = $uploadDir . $uniqueName;
        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            throw new Exception('No se pudo guardar la imagen.');
        }

        return $uniqueName;
    }
}
