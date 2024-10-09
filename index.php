<?php

require_once("app.class.php");
require_once("template.class.php");

new App();

$child = new Template("views/index.html", [
    "nombre" => "Nick"
]);

$view = new Template("views/app.html", [
    "title" => "Tienda en linea",
    "child"=> $child
]);

echo $view;