<?php

class RegisterView {
	private static $register = 'RegisterView::Register';
    private static $name = 'RegisterView::UserName';
    private static $keptUserName = '';
    private static $password = 'RegisterView::Password';
	private static $passwordRepeat = 'RegisterView::PasswordRepeat'; 
    private static $messageId = 'RegisterView::Message';
    private $message = '';

    /**
     * Creates and returns the registration form
     * @return $registerForm - The registration form
     */
	public function response() {
        $this->listenRegister();

        $registerForm =
        '
        <h3>Register new user</h3>

        <form method="post" id="registration">
            <fieldset>
                <legend>Register - enter Username and password</legend>
                <p id="' . self::$messageId . '">' . $this->message . '</p>

                <label for="' . self::$name . '">Username :</label>
                <input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . self::$keptUserName . '" /><br>

                <label for="' . self::$password . '">Password :</label>
                <input type="password" id="' . self::$password . '" name="' . self::$password . '" /><br>

                <label for="' . self::$passwordRepeat . '">Confirm password :</label>
                <input type="password" id="' . self::$passwordRepeat . '" name="' . self::$passwordRepeat . '" /><br>

                <input type="submit" name="' . self::$register . '" value="Register" />
            </fieldset>
        </form>
        ';

        return $registerForm;
    }

    /**
     * Listens to POSTs on the registration form and then registers an user
     */
	public function listenRegister() {
		if (isset($_POST['RegisterView::Register'])) {
			$this->registerUser();
		}
	}

    /**
     * Registers a new user after controlling the credentials provided
     * (Doesn't save to any database yet)
     */
	private function registerUser() {
        if (strlen($_POST[self::$name]) < 3) {
            $this->message .= "Username has too few characters, at least 3 characters.<br>";
            $this->keepUserName();
        }
        if (strlen($_POST[self::$password]) < 6) {
            $this->message .= "Password has too few characters, at least 6 characters.<br>";

            if (strlen($_POST[self::$name]) > 3) {
                $this->keepUserName();
            }
        }
        if ($_POST[self::$password] != $_POST[self::$passwordRepeat]) {
            $this->message .= "Passwords do not match.<br>";
            $this->keepUserName();
        }
        if ($_POST[self::$name] == 'Admin') {
            $this->message .= "User exists, pick another username.<br>";
            $this->keepUserName();
        }
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST[self::$name])) {
            $this->message .= "Username contains invalid characters.";
            $this->keepUserName();
        }
    }

    /**
     * Removes special characters from a string
     * @return - The string cleaned from special characters
     */
    private function removeSpecChars($string) {
        $string= strip_tags($string);

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
     }

    /**
     * Keeps the username
     */
    private function keepUserName() {
        $nameInput = $this->removeSpecChars($_POST[self::$name]);

        self::$keptUserName = $nameInput;

        return self::$keptUserName;
    }
}