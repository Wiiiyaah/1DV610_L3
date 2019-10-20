<?php

class NotepadView {
	private static $note = '';
	private static $saveNote = 'NotepadView::SaveNote';
	private $message = '';

	/**
	 * Creates HTTP response depending on if logged in or out
	 * @return - The requested HTML-response (either a login form or logout button)
	 */
	public function response() {
		return $this->generateNotepadHTML();
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return - The HTML of the logout button
	*/
	private function generateNotepadHTML() {
		if(isset($_SESSION['note'])) {
			self::$note = $_SESSION['note'];
		}

		$note = self::$note;
		$saveNote = self::$saveNote;

		return "
			<h3>Your personal notepad</h3>

			<form method='post' id='notepad'>
				<textarea id='note' name='note' rows='10' cols='40'>$note</textarea>
				<br/>
				<input type='submit' name='$saveNote' value='Save' />
			</form>
		";
	}

	/**
	 * Listens for POSTs from the login form or logout button
	 */
	public function listenNoteSave() {
		if (isset($_POST['NotepadView::SaveNote'])) {
			$_SESSION['note'] = $_POST['note'];
			// $this->saveNote();
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