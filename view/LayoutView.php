<?php

class LayoutView {

  /**
   * Renders the main page HTML with dynamic content depending on
   * if a user is logged in or not, the view, date and time.
   */
  public function render($isLoggedIn, $view, DateTimeView $dtv) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
          <link rel="stylesheet" href="style.css">
        </head>
        <body>
          <a href="."><h1>Assignment 2</h1></a>
          '. $this->addRegisterLink() . '

          ' . $this->renderIsLoggedIn($isLoggedIn) . '

          <div class="container">
              ' . $view->response() . '

              ' . $dtv->show() . '
          </div>
         </body>
      </html>
    ';
  }

  /**
   * Renders the logged in heading of the page depending
   * on if logged in or not
   * @return - The HTML-heading of the logged in-status
   */
  private function renderIsLoggedIn($isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }

  /**
   * Adds a register or back to login link depending on GET-parameter in URL
   * @return - The back- or register link
   */
  private function addRegisterLink() {
    if (isset($_GET['register'])) {
      return '<a href="./">Back to login</a>';
    } else if (!isset($_SESSION['loggedIn'])) {
      return '<a href="?register">Register a new user</a>';
    }
  }
}
