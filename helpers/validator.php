<?php


class Validator
{
    private $errors = [];

    public function validate($data, $rules)
    {
        foreach ($rules as $field => $fieldRules) {
            $value = isset($data[$field]) ? $data[$field] : null;

            foreach ($fieldRules as $rule => $ruleValue) {
                $methodName = 'validate' . ucfirst($rule);

                if (method_exists($this, $methodName)) {
                    $result = $this->{$methodName}($field, $value, $ruleValue);
                    if (!$result) {
                        // Si la validación falla, se agrega un mensaje de error
                        $this->addError($field, $rule);
                    }
                } else {
                    throw new Exception("La regla de validación '$rule' no existe.");
                }
            }
        }

        return empty($this->errors);
    }
    

    private function addError($field, $rule)
    {
        $this->errors[$field][] = "El campo '$field' no cumple la regla '$rule'.";
    }

    public function getErrors()
    {
        return $this->errors;
    }

    // Métodos de validación

    private function validateRequired($field, $value, $ruleValue)
    {
        if ($ruleValue) {
            return !empty($value) || $value === '0';
        }
        return true;
    }

   private function validateEnum($field, $value, $ruleValue)
    {
        // $ruleValue es un array de valores permitidos
        if (is_array($ruleValue) && in_array($value, $ruleValue)) {
            return true; // El valor es válido
        }

        return false; // El valor no está permitido
    }

    private function validateEmail($field, $value, $ruleValue)
    {
        if ($ruleValue) {
            return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
        }
        return true;
    }
    private function validateInt($field, $value, $ruleValue)
    {
        if ($ruleValue) {
            return filter_var($value, FILTER_VALIDATE_INT) !== false;
        }
        return true;
    }
    

    private function validateFloat($field, $value, $ruleValue)
    {
        if ($ruleValue) {
            return filter_var($value, FILTER_VALIDATE_FLOAT) !== false;
        }
        return true;
    }

    private function validateString($field, $value, $ruleValue)
    {
        if ($ruleValue) {
            return is_string($value);
        }
        return true;
    }

    private function validateMax($field, $value, $ruleValue)
    {
        return strlen($value) <= $ruleValue;
    }

    private function validateMin($field, $value, $ruleValue)
    {
        return strlen($value) >= $ruleValue;
    }

    private function validateBetween($field, $value, $ruleValue)
    {
        $min = $ruleValue[0];
        $max = $ruleValue[1];
        return $value >= $min && $value <= $max;
    }

    private function validateDate($field, $value, $ruleValue)
    {
        if ($ruleValue) {
            return (bool)strtotime($value);
        }
        return true;
    }

    private function validateImage($field, $value, $ruleValue)
    {
        // Verificar que la validación está activa y que el archivo fue subido
        if ($ruleValue && isset($value['tmp_name']) && is_uploaded_file($value['tmp_name'])) {
            // Validar el tipo MIME permitido
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($value['type'], $allowedTypes)) {
                return false;
            }
    
            // Validar el archivo usando getimagesize
            $imageInfo = getimagesize($value['tmp_name']);
            if ($imageInfo === false) {
                return false; // No es una imagen válida
            }
    
            return true; // El archivo es una imagen válida
        }
    
        return false; // No es un archivo válido
    }
    

    private function validateArray($field, $value, $ruleValue)
    {
        if ($ruleValue) {
            return is_array($value);
        }
        return true;
    }

    private function validateMinItems($field, $value, $ruleValue)
    {
        if (is_array($value)) {
            return count($value) >= $ruleValue;
        }
        return false;
    }



    /*
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

    */
}
