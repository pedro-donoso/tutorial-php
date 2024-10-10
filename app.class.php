<?php

require_once("db.class.php");
require_once("template.class.php");

class App {
    private $db;
    private $model;
    private $args = [];

    public function __construct() {
        $uri = $_SERVER["REQUEST_URI"];
        $uriParts = explode("/", $uri);
        array_shift($uriParts);

        for ($i = 0; $i < count($uriParts); $i++) {
            $this->args[] = $uriParts[$i];
        }

        $this->connectDB();
        $this->loadModel($uriParts[0] ?? '');
    }

    private function connectDB() {
        try {
            $this->db = DB::getInstance();
        } catch (Exception $e) {
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        }
    }

    private function loadModel($modelName) {
        if ($modelName != "") {
            $modelPath = $_SERVER['DOCUMENT_ROOT'] . "/models/" . $modelName . ".php";
            if (file_exists($modelPath)) {
                require_once($modelPath);
                $modelName = ucfirst($modelName);
                $this->model = new $modelName($this->db);
                $this->callMethod();
            } else {
                echo "Modelo " . $modelName . " no encontrado.";
            }
        } else {
            $template = new Template("/views/index.html", [
                "title" => "Página de Inicio",
                "child" => '<h1>Bienvenido a la Tienda en Línea</h1>'
            ]);
            $this->render($template);
        }
    }

    private function callMethod() {
        $template = "";
        if (empty($this->args[1])) {
            $template = $this->model->index();
        } elseif ($this->args[1] === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? '';
            $this->model->addProduct($name, $price);
            $template = $this->model->index();
        } elseif ($this->args[1] === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $this->args[2] ?? '';
            $this->model->deleteProduct($id);
            $template = $this->model->index();
        } elseif (is_numeric($this->args[1])) {
            $template = $this->model->show($this->args[1]);
        }
    
        $this->render($template);
    }

    private function render($child) {
        $childHtml = (string)$child;

        $view = new Template("/views/app.html", [
            "title" => "Tienda en Línea",
            "child" => $childHtml
        ]);

        echo $view;
    }
}

















