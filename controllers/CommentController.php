<?php
require_once __DIR__ . '/../models/Comment.php';


require_once __DIR__ . '/../helpers/Validator.php';
require_once __DIR__ . '/../config/config.php'; 

class CommentController {
    private $commentModel;
    private $validator;

    public function __construct() {
        $this->commentModel = new Comment();
        $this->validator = new Validator();

    }

    public function guardarComentario( $data ) 
    {
        session_start();
        //var_dump(json_encode($data));

        //var_dump((int)$data['rating']);
        try {
            $this->commentModel = new Comment();

            $rules = [
                'tuComentario' => [
                    'required' => true,
                    'string' => true,
                    'max' => 500
                ],
                'rating' => [
                    'int' => true,
                    'between' => [0, 5]
                ],
                'receta_id' => [
                    'required' => true,
                    'int' => true
                ],
                'user_id' => [
                    'required' => true,
                    'int' => true
                ]
            ];
            
            $validator = new Validator();
            if ($validator->validate($data, $rules)) {
                $comentario = $data['tuComentario'];
                $rating = $data['rating'];
                $receta_id = $data['receta_id'];
                $user_id = $data['user_id'];

                $this->commentModel = new Comment(
                    $receta_id,
                    $user_id,
                    $comentario,
                    $rating
                );

                $this->commentModel->save();

                $_SESSION['mensaje'] = 'se insertaron correctamente el comentario';
                return header("Location: " . BASE_URL . "/views/recipes/detail.php?id=" . $receta_id);

            } else {
                // Datos no válidos, obtener errores
                $errors = $validator->getErrors();
                print_r($errors);
            }

        } catch (Exception $e) {
            // Manejar errores y redirigir con un mensaje
            $_SESSION['mensaje'] = $e->getMessage();
            header("Location: " . BASE_URL . "/views/recipes/detail.php");
            exit;

        }
    }

    public function updateComentario( $data ) 
    {
        session_start();
        try {
            $this->commentModel = new Comment();

            $rules = [
                'tuComentario' => [
                    'required' => true,
                    'string' => true,
                    'max' => 500
                ],
                'rating' => [
                    'int' => true,
                    'between' => [0, 5]
                ],
                'receta_id' => [
                    'required' => true,
                    'int' => true
                ],
                'user_id' => [
                    'required' => true,
                    'int' => true
                ]
            ];
            
            $validator = new Validator();
            if ($validator->validate($data, $rules)) {
                $comentario = $data['tuComentario'];
                $rating = $data['rating'];
                $receta_id = $data['receta_id'];
                $user_id = $data['user_id'];

                $this->commentModel = new Comment(
                    $receta_id,
                    $user_id,
                    $comentario,
                    $rating
                );

                $this->commentModel->update();

                $_SESSION['mensaje'] = 'se actualizo tu comentario correctamente';
                return header("Location: " . BASE_URL . "/views/recipes/detail.php?id=" . $receta_id);

            } else {
                // Datos no válidos, obtener errores
                $errors = $validator->getErrors();
                print_r($errors);
            }

        } catch (Exception $e) {
            // Manejar errores y redirigir con un mensaje
            $_SESSION['mensaje'] = $e->getMessage();
            header("Location: " . BASE_URL . "/views/recipes/detail.php");
            exit;

        }
    }

    public function deleteComentario($data) {
        $rules = [
            'receta_id' => [
                'required' => true,
                'int' => true,
            ],
            'user_id' => [
                'required' => true,
                'int' => true,
            ],
        ];

        if($this->validator->validate($data, $rules)){
            $receta_id = $data['receta_id']; 
            $user_id = $data['user_id'];

            $deleted = $this->commentModel->delete_Id_recetaId($user_id, $receta_id);

            if($deleted) {
                $_SESSION['mensaje'] = 'se elimino tu comentario correctamente';
                return header("Location: " . BASE_URL . "/views/recipes/detail.php?id=" . $receta_id);
            }
        }else {
            $errors = $this->validator->getErrors();
            print_r($errors);
        }

    }


    public function getCommentId($data) {
        try {
            $receta_id = $data['receta_id'];
            $user_id = $data['user_id'];

            $comments = Comment::getComentario_UserId_recetaId($receta_id, $user_id);

            return json_encode($comments);

        } catch (Exception $e) {
            http_response_code(500);
            return json_encode(["message" => "Error al obtener comentarios.", "error" => $e->getMessage()]);
        }
    }

    public function getComment($data) {
        try {
            $receta = $data['receta_id'];
    
            $allComments = Comment::getComentario_RecetaId($receta);

            return json_encode($allComments);

        }catch (Exception $e) {
            http_response_code(500);
            return json_encode(["message" => "Error al obtener comentarios.", "error" => $e->getMessage()]);
        }
    }
}

    /*
    *
    * Procesar solicitud del form de login
    *
    */
    $controller = new CommentController();
    //manejo de post
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        var_dump($_POST);
        if (isset($_POST['action'])) {
            if ($_POST['action'] === 'subirComentario'){
                $controller->guardarComentario($_POST);
            }

            if($_POST['action'] === 'updateComentario'){ 
                $controller->updateComentario($_POST);
            }

            if($_POST['action'] === 'borrarComentario') {
                $controller->deleteComentario($_POST);
            }
        }
    }  
