<?php

require_once("template.class.php");

$uri = $_SERVER["REQUEST_URI"];
$uriParts = explode("/", $uri);
array_shift($uriParts);

$child = new Template("views/index.html", [
    "nombre" => "Nick"
]);

$view = new Template("views/app.html", [
    "title" => "Tienda en linea",
    "child"=> $child
]);

echo $view;