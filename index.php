<?php

// Require of needed files
require_once('view/RegisterView.php');
require_once('controller/RegisterController.php');
require_once('view/NotepadView.php');
require_once('view/LoginView.php');
require_once('controller/LoginController.php');
require_once('controller/MainController.php');

// Object creation of views
$registerVw = new RegisterView();
$registerController = new RegisterController($registerVw);
$notepadVw = new NotepadView();
$loginVw = new LoginView($notepadVw);
$loginController = new LoginController($loginVw);
$mainController = new MainController($loginController, $registerController);

// Start session
session_start();

$mainController->start();
