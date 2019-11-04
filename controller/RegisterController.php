<?php

class RegisterController {
    public $registerView;
    private $registerModel;

    function __construct($registerView) {
        $this->registerView = $registerView;
        // $this->registerModel = $registerModel;
    }

    public function start() {
        $this->registerView->listenPOST();
    }
}