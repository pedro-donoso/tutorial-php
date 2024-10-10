<?php

class Template {
    private $content;

    public function __construct($path, $data = []) {
        extract($data);
        ob_start();
        include $_SERVER['DOCUMENT_ROOT'] . $path;
        $this->content = ob_get_clean();
    }

    public function __toString() {
        return $this->content;
    }
}
