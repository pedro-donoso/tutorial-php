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
        if ($result === false) {
            die("Error en la consulta: " . $this->db->error);
        }
        return $result;
    }

    public function queryOne($sql) {
        $result = $this->query($sql);
        if ($result) {
            return $result->fetch_object();
        }
        return null;
    }

    public function escape($str) {
        return $this->db->escape_string($str);
    }

    public function prepare($sql) {
        return $this->db->prepare($sql);
    }

    public function execute($stmt, $params = array()) {
        $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        $stmt->execute();
        return $stmt;
    }

    public function lastInsertId() {
        return $this->db->insert_id;
    }
}




