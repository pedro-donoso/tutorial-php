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
        $name = $this->db->escape($name);
        $price = $this->db->escape($price);
        $sql = "INSERT INTO products (name, price) VALUES ('$name', '$price')";
        $this->db->query($sql);
    }
}












