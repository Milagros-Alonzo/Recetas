<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/Validator.php';
require_once __DIR__ . '/../config/config.php';

class AdminController
{
    private $userModel;
    private $validator;

    public function __construct()
    {
        $this->userModel = new User();
        $this->validator = new Validator();
    }

    public function createUser($data)
    {
        try {
            $rules = [
                'nombre' => ['required' => true, 'string' => true, 'max' => 100],
                'email' => ['required' => true, 'email' => true],
                'contrasena' => ['required' => true, 'string' => true, 'min' => 6],
                'rol' => ['required' => true, 'in' => ['admin', 'usuario']]
            ];

            if ($this->validator->validate($data, $rules)) {
                $nombre = $data['nombre'];
                $email = $data['email'];
                $contrasena = $data['contrasena'];
                $rol = $data['rol'];

                $this->userModel = new User($nombre, $email, $contrasena, $rol);
                $this->userModel->insertUser();

                return json_encode(['message' => 'Usuario creado exitosamente']);
            } else {
                return json_encode(['errors' => $this->validator->getErrors()]);
            }
        } catch (Exception $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }

    public function updateUser($data)
    {
        try {
            $rules = [
                'id' => ['required' => true, 'int' => true],
                'nombre' => ['string' => true, 'max' => 100],
                'email' => ['email' => true],
                'rol' => ['in' => ['admin', 'usuario']]
            ];

            if ($this->validator->validate($data, $rules)) {
                $id = $data['id'];
                $nombre = $data['nombre'] ?? null;
                $email = $data['email'] ?? null;
                $rol = $data['rol'] ?? null;

                $updated = $this->userModel->updateUser($id, $nombre, $email, $rol);

                if ($updated) {
                    return json_encode(['message' => 'Usuario actualizado exitosamente']);
                } else {
                    return json_encode(['message' => 'No se pudo actualizar el usuario']);
                }
            } else {
                return json_encode(['errors' => $this->validator->getErrors()]);
            }
        } catch (Exception $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }

    public function deleteUser($data)
    {
        try {
            $rules = ['id' => ['required' => true, 'int' => true]];

            if ($this->validator->validate($data, $rules)) {
                $id = $data['id'];

                $deleted = $this->userModel->deleteUser($id);

                if ($deleted) {
                    return json_encode(['message' => 'Usuario eliminado exitosamente']);
                } else {    
                    return json_encode(['message' => 'No se pudo eliminar el usuario']);
                }
            } else {
                return json_encode(['errors' => $this->validator->getErrors()]);
            }
        } catch (Exception $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }

    public function getAllUsers()
    {
        try {
            $users = $this->userModel->getAllUsers();
            return json_encode($users);
        } catch (Exception $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }
}

$controller = new AdminController();

// Procesar solicitudes POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'createUser') {
            echo $controller->createUser($_POST);
        } elseif ($_POST['action'] === 'updateUser') {
            echo $controller->updateUser($_POST);
        } elseif ($_POST['action'] === 'deleteUser') {
            echo $controller->deleteUser($_POST);
        }
    }
}

// Procesar solicitudes GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === 'getAllUsers') {
        echo $controller->getAllUsers();
    }
}
?>
