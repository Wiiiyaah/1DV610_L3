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
          <title>1DV610 - L3</title>
          <link rel="stylesheet" href="style.css">
        </head>
        <body>
          <a href="."><h1>Assignment 3</h1></a>
          '. $this->getLinkHTML($isLoggedIn) . '

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

  private function isRegistration() {
    if (isset($_GET['register'])) {
      return true;
    } else {
      return false;
    }
  }

  private function getLinkHTML($isLoggedIn) {
    if ($this->isRegistration()) {
      return $this->addRegLink
    } else if ($isLoggedIn) {
      return '';
    } else {
      return $this->getBackLink;
    }
  }

  /**
   * Adds a register or back to login link depending on GET-parameter in URL
   * @return - The back- or register link
   */
  private function getRegLink() {
    if (isset($_GET['register'])) {
      return '<a href="./">Back to login</a>';
    } else if (!isset($_SESSION['loggedIn'])) {
      return '<a href="?register">Register a new user</a>';
    }
  }

  /**
   * Returns a back to login link as HTML
   * @return - The back link HTML
   */
  private function getBackLink() {
      return '<a href="./">Back to login</a>';
  }
}
