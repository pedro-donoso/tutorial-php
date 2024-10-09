<?php

require_once("db.class.php");

class App {

    private $db;

    public function __construct(){
        $uri = $_SERVER["REQUEST_URI"];
        $uriParts = explode("/", $uri);
        array_shift($uriParts);

        $this->connectDB();
    }

    public function connectDB(){
        try {
            $this->db = DB::getInstance();
        } catch (Exception $e) {
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        }
    }
}


