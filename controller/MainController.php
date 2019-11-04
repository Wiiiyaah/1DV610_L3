<?php

require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');

class MainController {
    private $loginController;
    private $registerController;
    private $loginVw;
    private $registerVw;
    private $dateTimeVw;
    private $layoutVw;

    function __construct($loginController, $registerController) {
        $this->loginController = $loginController;
        $this->registerController = $registerController;

        $this->loginVw = $this->loginController->loginView;
        $this->registerVw = $this->registerController->registerView;

        $this->dateTimeVw = new DateTimeView();
        $this->layoutVw = new LayoutView();
    }

    public function start() {

        $this->loginController->start();
        $this->registerController->start();

        // Renders registration page if clicked on "Register a new user"
        if (isset($_GET['register'])) {
            $this->renderRegistration();
        // Renders main page logged in if cookies exist
        } else if (isset($_COOKIE[LoginView::$cookieName]) && isset($_COOKIE[LoginView::$cookiePassword])) {
            $this->loginVw->loginUser();
            $this->layoutVw->render(LoginView::$correctCookie, $this->loginVw, $this->dateTimeVw);
        // Renders main page logged in if session exists
        } else if (isset($_SESSION['loggedIn'])) {
            $this->layoutVw->render(true, $this->loginVw, $this->dateTimeVw);
        // Renders main page logged out if none of above
        } else {
            $this->layoutVw->render(false, $this->loginVw, $this->dateTimeVw);
        }
    }

    private function renderRegistration() {
        $this->layoutVw->render(false, $this->registerVw, $this->dateTimeVw);
    }

}