<?php

class NotepadView {
	private static $note = '';
	private static $saveNote = 'NotepadView::SaveNote';
	private static $clearNote = 'NotepadView::ClearNote';

	/**
	* Creates a HTTP response with the Notepad HTML and a POST-listener
	* @return - The HTML-response of a Notepad
	*/
	public function response() {
		$this->listenPOST(); // Listener for note changes
		return $this->getNotepadHTML();
	}

	/**
	* Gets the Notepad's HTML
	* @return - The HTML of the logout button
	*/
	private function getNotepadHTML() {
		$note = $this->getSavedNote();
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
	* Listens for POSTs from the Notepad-buttons
	*/
	public function listenPOST() {
		// On Save-click
		if (isset($_POST['NotepadView::SaveNote'])) {
			$this->saveNote();
			header("Refresh:0"); // Refreshes the page
		// On Clear-click
		} else if (isset($_POST['NotepadView::ClearNote'])) {
			$this->clearNote();
		}
	}

	/**
	* Saves the note to session and cookie
	*/
	private function saveNote() {
		$_SESSION['note'] = $_POST['note']; // Saves to session
		setcookie('note', $_POST['note'], time()+3600); // Saves to cookie (for eventual log out)
	}

	/**
	* Clears the currently saved note
	*/
	private function clearNote() {
		// Unsets and clears the cookie
		unset($_COOKIE['note']);
		setcookie('note', '', time()-3600);
		// Clears the session
		$_SESSION['note'] = '';
	}

	/**
	 * Gets the eventually saved note
	 */
	private function getSavedNote() {
		if (isset($_COOKIE['note'])) {
			return $_COOKIE['note']; // from cookie
		} else if (isset($_SESSION['note'])) {
			return $_SESSION['note']; // from session
		} else {
			return ''; // if none
		}
	}
}