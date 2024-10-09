<?php

require_once("db.class.php");
require_once("template.class.php");

class App {

    private $db;
    private $model;
    private $args = [];

    public function __construct(){
        $uri = $_SERVER["REQUEST_URI"];
        $uriParts = explode("/", $uri);
        array_shift($uriParts);

        for ($i = 1; $i < count($uriParts); $i++){
            $this->args[] = $uriParts[$i];
        }

        $this->connectDB();
        $this->loadModel($uriParts[0]);
    }

    private function connectDB(){
        try {
            $this->db = DB::getInstance();
        } catch (Exception $e) {
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        }
    }

    private function loadModel($modelName) {
        if ($modelName != "") {
            require_once("models/".$modelName.".php");
            $modelName = ucfirst($modelName);

            $this->model = new $modelName($this->db);
            $this->callMethod($this->model);
        }
    }

    private function callMethod($model) {
        $template = "";
        if (!isset($this->args[0])) {
            $template = $this->model->index();
        }

        $this->render($template);
    }

    private function render($child) {
        $view = new Template("views/app.html", [
            "title" => "Tienda en línea",
            "child" => '<main><div class="container-fluid"><h1>Esta es la lista de productos</h1><p>La cantidad de productos es <span id="product-count"></span></p><table class="table table-striped"><thead><tr><th>Nombre</th><th>Precio</th></tr></thead><tbody id="product-list"></tbody></table></div><script>const products = JSON.parse(\'' . $child . '\'); document.getElementById("product-count").innerText = products.length; const productList = document.getElementById("product-list"); products.forEach(product => { const row = document.createElement("tr"); row.innerHTML = `<td>${product.name}</td><td>${product.price}</td>`; productList.appendChild(row); });</script></main>'
        ]);
        
        echo $view;
    }
}










