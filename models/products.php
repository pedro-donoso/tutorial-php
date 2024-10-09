<?php 

class Products {
    private $db;

    public function __construct($db) {
        $this->db = $db;
        echo "Este es el modelo de producto";
    }

    public function index() {
        $sql = "SELECT * FROM products";
        $result = $this->db->query($sql); // Asegúrate de que esto retorna un objeto mysqli_result

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = (object) $row; // Convertir a objeto
        }

        return json_encode($products); // Convertir a JSON
    }
}



