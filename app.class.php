<?php

require_once("db.class.php");

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
        if (!isset($this->args[0])) {
            $this->model->index(); // Aquí se usa $this->model
        }
    }
}





