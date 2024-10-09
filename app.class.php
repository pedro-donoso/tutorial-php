<?php

require_once("db.class.php");
require_once("template.class.php");

class App
{
    private $db;
    private $model;
    private $args = [];

    public function __construct()
    {
        $uri = $_SERVER["REQUEST_URI"];
        $uriParts = explode("/", $uri);
        array_shift($uriParts);

        for ($i = 1; $i < count($uriParts); $i++) {
            $this->args[] = $uriParts[$i];
        }

        $this->connectDB();
        $this->loadModel($uriParts[0]);
    }

    private function connectDB()
    {
        try {
            $this->db = DB::getInstance();
        } catch (Exception $e) {
            echo "Error al conectar a la base de datos: " . $e->getMessage();
        }
    }

    private function loadModel($modelName)
    {
        if ($modelName != "") {
            $modelPath = "models/" . $modelName . ".php";
            if (file_exists($modelPath)) {
                require_once($modelPath);
                $modelName = ucfirst($modelName);

                $this->model = new $modelName($this->db);
                $this->callMethod($modelName);
            } else {
                echo "Modelo " . $modelName . " no encontrado.";
            }
        } else {
            $template = new Template("views/index.html", [
                "title" => "Página de Inicio",
                "child" => '<h1>Bienvenido a la Tienda en Líne</h1>'
            ]);
            $this->render($template);
        }
    }

    private function callMethod($modelName)
    {
        $template = "";
        if ($modelName === 'Products' && !isset($this->args[0])) {
            $template = $this->model->index();
            $this->renderTable($template);
        } else {
            $this->render($template);
        }
    }

    private function renderTable($child)
    {
        $childHtml = '<main>
                        <div class="container">
                            <h1>Esta es la lista de productos</h1>
                            <p>La cantidad de productos es <span id="product-count"></span></p>
                            <table class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                    </tr>
                                </thead>
                                <tbody id="product-list"></tbody>
                            </table>
                        </div>
                        <script>
                            const products = JSON.parse(\'' . $child . '\');
                            document.getElementById("product-count").innerText = products.length;
                            const productList = document.getElementById("product-list");
                            products.forEach(product => {
                                const row = document.createElement("tr");
                                row.innerHTML = `<td>${product.name}</td><td>${product.price}</td>`;
                                productList.appendChild(row);
                            });
                        </script>
                    </main>';

        $view = new Template("views/app.html", [
            "title" => "Tienda en Línea",
            "child" => $childHtml
        ]);

        echo $view;
    }

    private function render($child)
    {
        $view = new Template("views/app.html", [
            "title" => "Tienda en Línea",
            "child" => $child
        ]);

        echo $view;
    }
}












