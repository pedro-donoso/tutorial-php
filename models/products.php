<?php

class Products {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function index() {
        $sql = "SELECT * FROM products";
        $result = $this->db->query($sql);

        $products = [];
        while ($row = $result->fetch_object()) {
            $products[] = $row;
        }

        return new Template("/views/products/index.html", [
            "products" => $products
        ]);
    }

    public function show($id) {
        $id = $this->db->escape($id);
        $product = $this->db->queryOne("SELECT * FROM products WHERE product_id = " . $id);

        return new Template("/views/products/show.html", [
            "product" => $product
        ]);
    }

    public function addProduct($name, $price) {
    $sql = "INSERT INTO products (name, price) VALUES (?, ?)";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$name, $price]);
    return $this->db->lastInsertId();
}

    public function deleteProduct($id) {
        $id = $this->db->escape($id);
        $product = $this->db->queryOne("SELECT * FROM products WHERE product_id = " . $id);
        if ($product) {
            $sql = "DELETE FROM products WHERE product_id = " . $id;
            $this->db->query($sql);
            return true; // Producto eliminado con éxito
        } else {
            return false; // Producto no encontrado
        }
    }

    


}












