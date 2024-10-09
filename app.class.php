<?php

class App
{
    public function __construct()
    {

        $uri = $_SERVER["REQUEST_URI"];
        $uriParts = explode("/", $uri);
        array_shift($uriParts);
    }
}