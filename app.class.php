<?php

require_once("db.class.php");
require_once("template.class.php");

class App {

    private $db;
    private $model;
    private $args = [];

    public function __construct(){
        $uri = $_SERVER["REQUEST_URI"];
        $uriParts = explode("/", $uri);
        array_shift($uriParts);

        for ($i = 1; $i < count($uriParts); $i++){
            $this->args[] = $uriParts[$i];
        }

        $this->connectDB();
        $this->loadModel($uriParts[0]);
        $this->callMethod(); // No necesita pasar $uriParts aquí
    }

    private function connectDB(){
        try {
            $this->db = DB::getInstance();
        } catch (Exception $e) {
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        }
    }

    private function loadModel($modelName) {
        $modelPath = "models/" . $modelName . ".php";
        if (file_exists($modelPath)) {
            require_once($modelPath);
            $modelName = ucfirst($modelName);
            $this->model = new $modelName($this->db);
        } else {
            echo "Modelo " . $modelName . " no encontrado.";
        }
    }

    private function callMethod() {
        $template = "";
        if (!isset($this->args[0])) {
            $template = $this->model->index(); // Asegúrate de que esto retorna una cadena de texto
        }

        $this->render($template);
    }

    private function render($child) {
        $view = new Template("views/app.html", [
            "title" => "Tienda en línea",
            "child" => $child
        ]);
        
        echo $view;
    }
}







