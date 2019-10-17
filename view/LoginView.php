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


	/**
	 * Creates HTTP response depending on if logged in or out
	 * @return - The requested HTML-response (either a login form or logout button)
	 */
	public function response() {
		if (isset($_SESSION['loggedIn']) && $_SESSION == true)
		{
			$response = $this->generateLogoutButtonHTML($this->message);
		} else {
			$response = $this->generateLoginFormHTML($this->message);
		}
		return $response;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return - The HTML of the logout button
	*/
	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}

	/**
	* Generate HTML code on the output buffer for the login form
	* @param $message, String output message
	* @return - The HTML of the login form
	*/
	private function generateLoginFormHTML($message) {
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
	public function listenPost() {
		if (isset($_POST['LoginView::Login'])) {
			$this->logInUser();
		} else if (isset($_POST['LoginView::Logout'])) {
			$this->logOutUser();
		}
	}

	/**
	 * Logs the user in
	 */
	public function logInUser() {
		// If there is a cookie saved with correct credentials
		if (isset($_COOKIE[self::$cookieName]) && isset($_COOKIE[self::$cookiePassword])) {
			if ($_COOKIE[self::$cookieName] == 'Admin' && $_COOKIE[self::$cookiePassword] == 'Password') {
				self::$correctCookie = true;
				if (!isset($_SESSION['username']) && !isset($_SESSION['password'])) {
					$this->message = "Welcome back with cookie";
				}
				// Creates a session with the credentials
				$_SESSION['loggedIn'] = true;
				$_SESSION['username'] = $_COOKIE[self::$cookieName];
				$_SESSION['password'] = $_COOKIE[self::$cookiePassword];
			} else {
				// When false or incorrect cookie credentials
				self::$correctCookie = false;
				$this->message = "Wrong information in cookies";
				unset($_COOKIE[self::$cookieName]);
				unset($_COOKIE[self::$cookiePassword]);
				setcookie(self::$cookieName, '', time()-3600);
				setcookie(self::$cookiePassword, '', time()-3600);
			}
		// If already logged in (by session)
		} else if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true) {
			$this->message = "";
		// If no cookie or session is set
		} else if (isset($_POST['LoginView::Login'])) {
			if ($_POST[self::$name] == '') {
				$this->message = "Username is missing";
			} else if ($_POST[self::$password] == '') {
				$this->getRequestUserName();
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
	}

	/**
	 * Logs the user out
	 */
	private function logOutUser() {
		// If there is a session set
		if (isset($_SESSION['loggedIn']) && $_SESSION == true) {
			session_unset();
			session_destroy();
			$this->message = "Bye bye!";
		}
		// Removes and unsets cookies with credentials
		unset($_COOKIE[self::$cookieName]);
		unset($_COOKIE[self::$cookiePassword]);
		setcookie(self::$cookieName, '', time()-3600);
		setcookie(self::$cookiePassword, '', time()-3600);
	}

	/**
	 * Gets requested username and makes it saved
	 * @return - The saved username
	 */
	private function getRequestUserName() {
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