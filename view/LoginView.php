<?php

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	public static $cookieName = 'LoginView::CookieName';
	public static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private $message = '';
	public static $correctCookie = true;
	public static $savedUserName = '';
	protected static $currView;

	/**
	 * Constructor with a partial view as parameter
	 */
	function __construct($view) {
			self::$currView = $view;
	}

	/**
	 * Creates HTTP response depending on if logged in or out
	 * @return - The requested HTML-response (either a login form or logout button with content logged in)
	 */
	public function response() {
		// When POST (of Login-form)
		$this->listenPOST(); // Listener for login/log out buttons

		if (isset($_SESSION['loggedIn']) && $_SESSION == true)
		{
			$response = $this->getLoggedInHTML($this->message);
		} else {
			$response = $this->getLoginFormHTML($this->message);
		}
		return $response;
	}

	/**
	* Gets the HTML code for the logout button and logged in content
	* @param $message, String output message
	* @return - The HTML of the logout button and page content
	*/
	private function getLoggedInHTML($message) {
		return '
			<p id="' . self::$messageId . '">' . $message .'</p>

			' . self::$currView->response() . '

			<form  method="post" >
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}

	/**
	* Gets the  HTML code for the login form
	* @param $message, String output message
	* @return - The HTML of the login form
	*/
	private function getLoginFormHTML($message) {
		return '
			<form method="post" >
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>

					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . self::$savedUserName . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />

					<input type="submit" name="' . self::$login . '" value="Login" />
				</fieldset>
			</form>
		';
	}

	/**
	 * Listens for POSTs from the login form or logout button
	 */
	public function listenPOST() {
		if (isset($_POST['LoginView::Login'])) {
			$this->loginUser();
		} else if (isset($_POST['LoginView::Logout'])) {
			$this->logOutUser();
		}
	}

	/**
	 * Logs the user in
	 */
	public function loginUser() {
		// If there is a cookie saved
		if (isset($_COOKIE[self::$cookieName]) && isset($_COOKIE[self::$cookiePassword])) {
			$this->loginByCookies();
		// If already logged in (by session)
		} else if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
			$this->message = "";
		// If no cookie or session is set, by click on login button
		} else if (isset($_POST['LoginView::Login'])) {
			$this->loginByPOST();
		}
	}

	/**
	 * Logs the user in by saved cookies
	 */
	private function loginByCookies() {
		if ($_COOKIE[self::$cookieName] == 'Admin' && $_COOKIE[self::$cookiePassword] == 'Password') {
			self::$correctCookie = true;
			if (!isset($_SESSION['username']) && !isset($_SESSION['password'])) {
				$this->message = "Welcome back with cookie";
			}
			// Creates a session with the cookies credentials
			$this->sessionFromCookies();
		} else {
			// When false or incorrect cookie credentials
			self::$correctCookie = false;
			$this->message = "Wrong information in cookies";
			// Clears the users log-in cookies
			$this->clearCookies();
		}
	}

	/**
	 * Logs in by the submit-button in the login-form
	 */
	private function loginByPOST() {
		if ($_POST[self::$name] == '') {
			$this->message = "Username is missing";
		} else if ($_POST[self::$password] == '') {
			$this->keepUsername();
			$this->message = "Password is missing";
		} else if ($_POST[self::$name] == 'Admin' && $_POST[self::$password] != 'Password') {
			$this->message = "Wrong name or password";
		} else if ($_POST[self::$name] != 'Admin' && $_POST[self::$password] == 'Password') {
			$this->message = "Wrong name or password";
		} else if ($_POST[self::$name] == 'Admin' && $_POST[self::$password] == 'Password') {
			if (isset($_POST[self::$keep])) {
				$this->message = "Welcome and you will be remembered";
				$this->keepLoggedIn();
			} else {
				$this->message = "Welcome";
			}
			$this->setSession();
		}
	}

	/**
	 * Creates a session with the cookies credentials
	 */
	private function sessionFromCookies() {
		$_SESSION['loggedIn'] = true;
		$_SESSION['username'] = $_COOKIE[self::$cookieName];
		$_SESSION['password'] = $_COOKIE[self::$cookiePassword];
	}

	/**
	 * Clears the current session
	 */
	private function clearSession() {
		session_unset();
		session_destroy();
	}

	/**
	 * Clears the login-cookies
	 */
	private function clearCookies() {
		unset($_COOKIE[self::$cookieName]);
		unset($_COOKIE[self::$cookiePassword]);
		setcookie(self::$cookieName, '', time()-3600);
		setcookie(self::$cookiePassword, '', time()-3600);
	}

	/**
	 * Logs the user out
	 */
	private function logOutUser() {
		// If there is a session set
		if (isset($_SESSION['loggedIn']) && $_SESSION == true) {
			$this->clearSession();
			$this->message = "Bye bye!";
		}
		// Clears the users log-in cookies
		$this->clearCookies();
	}

	/**
	 * Keeps and returns the username
	 * @return - The saved username
	 */
	private function keepUsername() {
		$nameInput = $_POST[self::$name];
		self::$savedUserName = $nameInput;

		return self::$savedUserName;
	}

	/**
	 * Keeps a user logged in by setting a cookie with the credentials
	 */
	private function keepLoggedIn() {
		setcookie('LoginView::CookieName', $_POST[self::$name], time()+3600);
		setcookie('LoginView::CookiePassword', $_POST[self::$password], time()+3600);
	}

	/**
	 * Sets a logged in session for the user with credentials from the POST
	 * of the login form
	 */
	private function setSession() {
		$_SESSION['loggedIn'] = true;
		$_SESSION['username'] = $_POST[self::$name];
		$_SESSION['password'] = $_POST[self::$password];
	}
}