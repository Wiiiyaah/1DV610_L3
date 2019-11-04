<?php

class LoginController {
    public $loginView;
    private $loginModel;

    function __construct($loginView) {
        $this->loginView = $loginView;
        // $this->loginModel = $loginModel;
    }

    public function start() {
        $this->loginView->listenPOST();
    }
}