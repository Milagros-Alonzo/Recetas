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

        if (strlen($password) < 6) {
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
}
