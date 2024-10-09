<?php

class Products {
    private $db;

    public function __construct($db) {
        $this->db = $db;

    }

    public function index() {
        $sql = "SELECT * FROM products";
        $products = $this->db->query($sql);

        return json_encode($products);
    }
}






