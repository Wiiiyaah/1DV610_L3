<?php

class NotepadView {
	private static $login = 'NotepadView::Login';
	private static $logout = 'NotepadView::Logout';
	private static $name = 'NotepadView::UserName';
	private static $password = 'NotepadView::Password';
	public static $cookieName = 'NotepadView::CookieName';
	public static $cookiePassword = 'NotepadView::CookiePassword';
	private static $keep = 'NotepadView::KeepMeLoggedIn';
	private static $messageId = 'NotepadView::Message';
	private static $notes = 'NotepadView::Notes';
	private $message = '';
	public static $correctCookie = true;
	public static $savedUserName = '';

	/**
	 * Creates HTTP response depending on if logged in or out
	 * @return - The requested HTML-response (either a login form or logout button)
	 */
	public function response() {
		return $this->generateNotepadHTML($this->message);
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return - The HTML of the logout button
	*/
	private function generateNotepadHTML($message) {
		$this->listenNotes();

		if(isset($_SESSION['notes'])) {
			self::$notes = $_SESSION['notes'];
		}

		return '
			<h3>Your personal notepad</h3>

			<form method="post" id="notepad">
				<textarea id="notes" name="notes" value="' . self::$notes . '" rows="10" cols="40"></textarea>
				<br/>
				<input type="submit" name="save" value="Save" />
			</form>
		';
	}

	/**
	 * Listens for POSTs from the login form or logout button
	 */
	public function listenNotes() {
		if (isset($_POST['save'])) {
			self::$notes = $_POST['notes'];
			$this->saveNotes();
		}
	}

	/**
	 * Logs the user in
	 */
	public function saveNotes() {
		// Adds saved notepad to session
		$_SESSION['notes'] = self::$notes;
	}
}