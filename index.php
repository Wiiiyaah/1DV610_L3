<?php

// Require of needed files
require_once('view/LoginView.php');
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/RegisterView.php');
require_once('view/NotepadView.php');

// Error handling and debugging (inactivated for public server)
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// Object creation of views
$dateTimeVw = new DateTimeView();
$layoutVw = new LayoutView();
$registerVw = new RegisterView();
$notepadVw = new NotepadView();
$loginVw = new LoginView($notepadVw);

// Start session
session_start();

// When POST (of Login-form)
$loginVw->listenPost();
// When POST (of saved note)
$notepadVw->listenNoteSave();

// Renders registration page if clicked on "Register a new user"
if (isset($_GET['register'])) {
	$layoutVw->render(false, $registerVw, $dateTimeVw);
// Renders main page logged in if cookies exist
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

/* // Listens for button press to go to notepad
if (isset($_POST['goToNotepad'])) {
	$layoutVw->render(true, $notepadVw, $dateTimeVw);
} */