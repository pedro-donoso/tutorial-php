<?php

require_once("db.class.php");

class App {

    private $db;

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
        $modelPath = "models/" . $modelName . ".php"; // Ajusta la ruta a tus modelos
        if (file_exists($modelPath)) {
            require_once($modelPath);
            echo "Cargando el modelo " . $modelName;
        } else {
            echo "Modelo " . $modelName . " no encontrado.";
        }
    }
}
