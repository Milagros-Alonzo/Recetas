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
}
