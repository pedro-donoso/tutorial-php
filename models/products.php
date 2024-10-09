<?php 

class Products {

    private $db;

    public function __construct($db) {
        $this->db = $db;
        echo "Este es el modelo de producto ";
    }

    public function index() {   
       $products = $this->db->query("SELECT * FROM products");
       
       return new Template("views/products/index.html", [
        "products" => $products
        ]);
    }

    public function show($id) {   
        // Código para mostrar un producto específico
    }

    public function create() {   
        // Código para crear un nuevo producto
    }

    public function update($id) {   
        // Código para actualizar un producto existente
    }

    public function delete($id) {   
        // Código para eliminar un producto
    }
}
