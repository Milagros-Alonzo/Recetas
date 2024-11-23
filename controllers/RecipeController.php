<?php
    require_once __DIR__ . '/../models/Recipe.php';
    require_once __DIR__ . '/../models/Ingredient.php';
    require_once __DIR__ . '/../models/Comment.php';


    require_once __DIR__ . '/../helpers/Validator.php';
    require_once __DIR__ . '/../config/config.php'; 


class RecipeController {
    private $recetaModel;
    private $ingredientModel;
    private $commentModel;
    private $validator;

        public function __construct()
        {
            $this->recetaModel = new Recipe(); // Instancia del modelo
            $this->ingredientModel = new Ingredient();
            $this->commentModel = new Comment();
            $this->validator = new Validator(); // Instancia del helper
        }    

        public function guardarReceta($data, $file) 
        {
            $datosCombinados = array_merge($_POST, $_FILES);

            session_start();
            try {

                $rules = [
                    'titulo' => [
                        'required' => true,
                        'string' => true,
                        'max' => 200
                    ],
                    'descripcion' => [
                        'required' => true,
                        'string' => true,
                        'max' => 2000
                    ],
                    'pasos' => [
                        'required' => true,
                        'string' => true,
                        'max' => 2000
                    ],
                    'tiempo' => [
                        'required' => true,
                        'string' => true,
                        'max' => 50
                    ],
                    'ingrediente' => [
                        'required' => true,
                        'array' => true,
                        'minItems' => 1
                    ],
                    'imagen' => [
                        'required' => true,
                        'image' => true
                    ]
                ];
                
                
                if($this->validator->validate($datosCombinados, $rules)) {
                    
                    $titulo = $data['titulo'];
                    $descripcion = $data['descripcion'];
                    $pasos = $data['pasos'];
                    $tiempo = $data['tiempo'];
                    $ingredientes = $data['ingrediente'];
                    $imagen = $file['imagen'];
                    
    
                    //validaciones
                    if (!isset($_SESSION['user'])) {
                        return header('location: ' . BASE_URL . '/views/auth/login.php');              
                    }
    
                    // Subir imagen (si existe)
                    $uniqueName = null;
                    if (!empty($imagen['tmp_name'])) {
                        $uniqueName = $this->validator->uploadImage($imagen, $_SERVER['DOCUMENT_ROOT'] . '/PROYECTO_FINAL/Recetas/public/img/');
                    }

       
                    //instancasr recetas y guardar la base de datos
                    $this->recetaModel = new Recipe(
                        $_SESSION['user'],
                        $titulo,
                        $descripcion,
                        $pasos,
                        $tiempo,
                        $uniqueName
                    );
    
                    $id = $this->recetaModel->save();
                    
                    
                    
                    //isntancias de ingredientes y guardar la base de datos
                    $this->ingredientModel = new Ingredient(
                        $id,
                        $ingredientes
                    );
                    $this->ingredientModel->save();


    
                    $_SESSION['mensaje'] = 'se insertaron correctamente los datos';
                    return header("Location: " . BASE_URL . "/index.php");
                }else {
                    $errors = $this->validator->getErrors();
                    var_dump($errors);
                }
                
            }  catch (Exception $e) {
                // Manejar errores y redirigir con un mensaje
                $_SESSION['mensaje'] = $e->getMessage();
                header("Location: " . BASE_URL . "/views/recipes/add.php");
                exit;
            }
            
        }

        public function getAllRecipe() {
            try {
                $recipes = Recipe::getAll();


                return json_encode($recipes);

            }catch (Exception $e) {

                return json_encode($e->getMessage());
            }
        }

        public function getRecipe($id) {
            try {
                $recipes = Recipe::getByUserId($id);
        
        
                // Devolver la respuesta en formato JSON
                return json_encode($recipes);

            }catch (Exception $e) {
                return json_encode($e->getMessage());
            }
        }

        public function getRecipeDetail($id) {
            $id = $id['recipe_id'];
            try {
                $recipes = Recipe::getById($id);
                $ingredient = Ingredient::getByRecetaId($id);

                return json_encode([$recipes, $ingredient]);
            }catch (Exception $e) {

                return json_encode($e->getMessage());
            }
        }

}


    /*
    *
    * Procesar solicitud del form de login
    *
    */
    $controller = new RecipeController();

    //manejo de post
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['action'])) {
            if ($_POST['action'] === 'register') {
                $controller->guardarReceta($_POST, $_FILES);
            }
        }
    }  
    
    //manejo de get
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if(isset($_GET['action'])) {
            if ($_GET['action'] === 'getRecipe' && empty($_GET['id'])) {
                $controller->getAllRecipe();
            }elseif ($_GET['action'] === 'getRecipeDetail') {
                $controller->getRecipeDetail($_GET['id']);
            } else {
                $controller->getRecipe($_GET['id']);
            }
        }
    }
    
        
