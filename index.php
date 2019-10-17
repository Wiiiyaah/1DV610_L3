<?php

// Require of needed files
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');

// Error handling and debugging (inactivated for public server)
// error_reporting(E_ALL);
// ini_set('display_errors', 'On');

// Object creation of views
$loginVw = new LoginView();
$dateTimeVw = new DateTimeView();
$layoutVw = new LayoutView();
$registerVw = new RegisterView();

// Start session
session_start();

// When POST (of Login-form)
$loginVw->listenPost();

// Renders registration page if clicked on "Register a new user"
if (isset($_GET['register'])) {
	$layoutVw->render(false, $registerVw, $dateTimeVw);
// Renders main page logged in if cookoies exist
} else if (isset($_COOKIE[LoginView::$cookieName]) && isset($_COOKIE[LoginView::$cookiePassword])) {
	$loginVw->logInUser();
	$layoutVw->render(LoginView::$correctCookie, $loginVw, $dateTimeVw);
// Renders main page logged in if session exists
} else if (isset($_SESSION['loggedIn'])) {
	$layoutVw->render(true, $loginVw, $dateTimeVw);
// Renders main page logged out if none of above
} else {
	$layoutVw->render(false, $loginVw, $dateTimeVw);
}
