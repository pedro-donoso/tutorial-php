<?php

class Template{

    private $content;
    public function __construct($path, $data = []) {
        extract($data);
        ob_start();
        include ($path);
        $this->content = ob_get_clean();
    }

    public function __tostring(){
        return $this->content;
    }
}