<?php

class DB {
    private $db;
    private static $instance = null;

    private function __construct() {
        $this->db = new mysqli("localhost", "Nicky", "nicky", "tienda");
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DB();
        }
        return self::$instance;
    }

    public function query($sql) {
        $result = $this->db->query($sql);

        $arr = [];

        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }

        return $arr;
    }
}



