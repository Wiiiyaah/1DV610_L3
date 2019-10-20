<?php

class NotepadView {
	private static $note = '';
	private static $saveNote = 'NotepadView::SaveNote';
	private static $clearNote = 'NotepadView::ClearNote';
	private $message = '';

	/**
	 * Creates HTTP response depending on if logged in or out
	 * @return - The requested HTML-response (either a login form or logout button)
	 */
	public function response() {
		// Listens for POST (of note changes)
		$this->listenNotePOST();

		return $this->generateNotepadHTML();
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return - The HTML of the logout button
	*/
	private function generateNotepadHTML() {
		if (isset($_COOKIE['note'])) {
			self::$note = $_COOKIE['note'];
		} else if (isset($_SESSION['note'])) {
			// self::$note = $_SESSION['note'];
		}

		$note = self::$note;
		$saveNote = self::$saveNote;
		$clearNote = self::$clearNote;

		return "
			<h3>Your personal notepad</h3>

			<form method='post' id='notepad'>
				<textarea id='note' name='note' rows='10' cols='40'>$note</textarea>
				<br/>
				<input type='submit' name='$saveNote' value='Save' />
				<input type='submit' name='$clearNote' value='Clear' />
			</form>
		";
	}

	/**
	 * Listens for POSTs from the login form or logout button
	 */
	public function listenNotePOST() {
		if (isset($_POST['NotepadView::SaveNote'])) {
			$_SESSION['note'] = $_POST['note'];
			setcookie('note', $_POST['note'], time()+3600);
			header("Refresh:0");
			// $this->saveNote();
		} else if (isset($_POST['NotepadView::ClearNote'])) {
			unset($_COOKIE['note']);
			setcookie('note', '', time()-3600);
			$_SESSION['note'] = '';
		}
	}

	/**
	 * Logs the user in
	 */
	public function saveNote() {
		// Adds saved notepad to session
		$_SESSION['note'] = self::$note;
	}
}