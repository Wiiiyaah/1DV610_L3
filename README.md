# Login application in PHP
Made as assignment no. 3 in course 1DV610

## Hardcoded credentials

Username and Password:
(Same as default in assignment 2)

## Installation instructions

- Install WAMP/LAMP/MAMP/XAMPP with support of Apache, FTP and PHP
- (Alternatively get a web hosting account from a web hotel with above given requirements)
- Upload the files in this project to the chosen server (either local or to the web hotel)
- Open up the uploaded directory/URL in your browser
- VOILA! Everythign should be ready to try!

## Extra Use-Cases

**UC1 – Save a note in Notepad**

Precondition: User is logged in

Postcondition: The note is saved

**Main scenario**

1. The user clicks the notepad-looking textarea
2. The user enters some text in the textarea
3. The text is visible in the textarea
4. The user clicks on the “Save”-button
5. The entered text remains in the textarea saved

**UC2 – Clear/Remove the note in Notepad**

Precondition: User is logged in with a saved note in the textarea

Postcondition: The note is cleared and the textarea empty of text

**Main scenario**

1. The user clicks the “Clear”-button
2. The text that was visible before in the textarea disappears

**UC3 – Edit existing note**

Precondition: User is logged in with a saved note in the textarea

Postcondition: The note is changed to what the user added/edited

**Main scenario**

1. The user clicks on the textarea
2. The user edits/removes text already entered
3. The edited text is visible in the textarea
4. The user clicks on the “Save”-button
5. The edited text remains in the textarea saved

## Manual Test-Cases

**TC1 – Save of note succesful**

Precondition: User is logged in

Use-Case: UC1 - Save a note in Notepad

Scenario: Saving of note succesful

**Test steps**

1. The user clicks on the notepad-looking textarea
2. The user enters some text in the textarea
3. The text is visible in the textarea
4. The user clicks on the “Save”-button
5. The user logs out
6. The user logs back in again

**Expected**

*   The text entered into the textarea is remaining when logging back in again (on the same computer and browser)

**TC2 – Clearing/Removal of note succesful**

Precondition: User is logged in with a saved note in the textarea

Use-Case: UC2 - Clear/Remove the note in Notepad

Scenario: Clearing of note succesful

**Main scenario**

1. The user clicks the “Clear”-button
2. The text that was visible before in the textarea disappears

**Expected**

*   The textarea is empty from text

**TC3 – Edit existing note succesful**

Precondition: User is logged in with a saved note in the textarea

Use-Case: UC3 - Edit existing note

Scenario: Editing of existing note succesful

**Main scenario**

1. The user clicks on the textarea
2. The user edits/removes text already entered
3. The user clicks on the “Save”-button
4. The user logs out
6. The user logs back in again

**Expected**

*   The edited text is still remaining in the textarea (on the same computer and browser)