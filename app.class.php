<?php

require_once("db.class.php");

class App {

    private $db;
    private $model;

    public function __construct(){
        $uri = $_SERVER["REQUEST_URI"];
        $uriParts = explode("/", $uri);
        array_shift($uriParts);

        $this->connectDB();
        $this->loadModel($uriParts[0] ?? 'default'); // Usa 'default' si $uriParts[0] no está definido
    }

    public function connectDB(){
        try {
            $this->db = DB::getInstance();
        } catch (Exception $e) {
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        }
    }

    public function loadModel($modelName) {
        require_once("models/".$modelName.".php");
        $modelName = ucfirst($modelName);

        // Asegúrate de pasar la instancia correcta
        $this->model = new $modelName($this->db);
    }
}

