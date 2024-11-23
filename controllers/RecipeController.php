<?php
    require_once __DIR__ . '/../models/Recipe.php';
    require_once __DIR__ . '/../models/Ingredient.php';

    require_once __DIR__ . '/../helpers/Validator.php';
    require_once __DIR__ . '/../config/config.php'; 


class RecipeController {
    private $recetaModel;
    private $ingredientModel;

        public function __construct()
        {
            $this->recetaModel = new Recipe(); // Instancia del modelo
            $this->ingredientModel = new Ingredient();
        }    

        public function guardarReceta($data, $file) 
        {
            session_start();
            try {

                $datosValidados = Validator::validateRecipeData($data, $file);
    
                $titulo = $datosValidados['titulo'];
                $descripcion = $datosValidados['descripcion'];
                $pasos = $datosValidados['pasos'];
                $tiempo = $datosValidados['tiempo'];
                $ingredientes = $datosValidados['ingredientes'];
                $imagen = $datosValidados['imagen'];
                $tipoComida = $datosValidados['tipo_comida'];


                //validaciones
                if (!isset($_SESSION['user'])) {
                    return header('location: ' . BASE_URL . '/views/auth/login.php');              
                }

                // Validar campos requeridos
                if (empty($titulo) || empty($descripcion) || empty($pasos) || empty($tiempo) || empty($ingredientes)) {
                    $_SESSION['mensaje'] = 'Todos los campos son obligatorios.';
                    return header('location: ' . BASE_URL . '/views/recipes/add.php');
                }
    
                // Subir imagen (si existe)
                $uniqueName = null;
                if (!empty($imagen['tmp_name'])) {
                    $uniqueName = Validator::uploadImage($imagen, $_SERVER['DOCUMENT_ROOT'] . '/PROYECTO_FINAL/Recetas/public/img/');
                }

   
                $this->recetaModel = new Recipe(
                    $_SESSION['user'],
                    $titulo,
                    $descripcion,
                    $pasos,
                    $tiempo,
                    $uniqueName
                );


                
                // Llama al modelo para guardar los datos
                $id = $this->recetaModel->save();

                $this->ingredientModel = new Ingredient(
                    $id,
                    $ingredientes
                );
                

                
                $this->ingredientModel->save();

                $_SESSION['mensaje'] = 'se insertaron correctamente los datos';
                return header("Location: " . BASE_URL . "/index.php");
            }  catch (Exception $e) {
                // Manejar errores y redirigir con un mensaje
                $_SESSION['mensaje'] = $e->getMessage();
                header("Location: " . BASE_URL . "/views/recipes/add.php");
                exit;
            }
            
        }

        public function getAllRecipe() {
            session_start();
            try {
                $this->recetaModel = new Recipe();
                $recipes = $this->recetaModel->getAll();
        
                // Construir la respuesta con las claves 'success', 'data' y 'message'
                $response = [
                    'success' => true,
                    'data' => $recipes,
                    'message' => 'Recetas obtenidas exitosamente'
                ];
        
                // Establecer el encabezado Content-Type a application/json
                header('Content-Type: application/json');
        
                // Devolver la respuesta en formato JSON
                echo json_encode($response);

            }catch (Exception $e) {
                $errorResponse = [
                    'success' => false,
                    'message' => $e->getMessage()
                ];
        
                header('Content-Type: application/json');
                echo json_encode($errorResponse);
            }
        }

        public function getRecipe($id) {
            session_start();
            try {
                $this->recetaModel = new Recipe();
                $recipes = $this->recetaModel->getByUserId($id);
        
                // Construir la respuesta con las claves 'success', 'data' y 'message'
                $response = [
                    'success' => true,
                    'data' => $recipes,
                    'message' => 'Recetas obtenidas exitosamente'
                ];
        
                // Establecer el encabezado Content-Type a application/json
                header('Content-Type: application/json');
        
                // Devolver la respuesta en formato JSON
                echo json_encode($response);

            }catch (Exception $e) {
                $errorResponse = [
                    'success' => false,
                    'message' => $e->getMessage()
                ];
        
                header('Content-Type: application/json');
                echo json_encode($errorResponse);
            }
        }

        public function getRecipeDetail($id) {
            session_start();
            try {
                $this->recetaModel = new Recipe();
                $this->ingredientModel = new Ingredient();

                $recipes = $this->recetaModel->getById($id);
                $ingredient = $this->ingredientModel->getByRecetaId($id);

        
                // Construir la respuesta con las claves 'success', 'data' y 'message'
                $response = [
                    'success' => true,
                    'data' => [$recipes, $ingredient],
                    'message' => 'Recetas obtenidas exitosamente'
                ];
        
                // Establecer el encabezado Content-Type a application/json
                header('Content-Type: application/json');
        
                // Devolver la respuesta en formato JSON
                echo json_encode($response);

            }catch (Exception $e) {
                $errorResponse = [
                    'success' => false,
                    'message' => $e->getMessage()
                ];
        
                header('Content-Type: application/json');
                echo json_encode($errorResponse);
            }
        }
}



    /*
    *
    * Procesar solicitud del form de login
    *
    */
    $controller = new RecipeController();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['action'] === 'register') {
            $controller->guardarReceta($_POST, $_FILES);
        } 
    }  elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        //var_dump(json_encode($_GET['id']));
        //var_dump(json_encode(empty(trim($_GET['id']))));
        //exit;
        if ($_GET['action'] === 'getRecipe' && empty($_GET['id'])) {
            $controller->getAllRecipe();
        }elseif ($_GET['action'] === 'getRecipeDetail') {
            $controller->getRecipeDetail($_GET['id']);
        } else {
            $controller->getRecipe($_GET['id']);
        }
    }
    
        
        //throw new Exception(json_encode($_GET));