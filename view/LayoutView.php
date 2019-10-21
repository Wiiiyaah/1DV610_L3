<?php

class LayoutView {

  /**
   * Renders the main page HTML with dynamic content depending on
   * if a user is logged in or not, the view, date and time.
   */
  public function render(bool $isLoggedIn, $view, DateTimeView $dtv) {
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

          ' . $this->getIsLoggedIn($isLoggedIn) . '

          <div class="container">
              ' . $view->response() . '

              ' . $dtv->get() . '
          </div>
         </body>
      </html>
    ';
  }

  /**
   * Gets the heading of the page depending
   * on if logged in or not
   * @return - The HTML-heading of the logged in-status
   */
  private function getIsLoggedIn($isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }

  /**
   * Gets if the user is on the registration page or not
   * @return - Boolean if the user is on the registration page
   */
  private function isRegistration() {
    if (isset($_GET['register'])) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Gets the correct link-HTML depending on which page user is on
   * @return - The correct link (if any) for the current page
   */
  private function getLinkHTML($isLoggedIn) {
    if ($this->isRegistration()) {
      return $this->getBackLink();
    } else if ($isLoggedIn) {
      return '';
    } else {
      return $this->getRegLink();
    }
  }

  /**
   * Gets the register new user link as HTML
   * @return - The register link as HTML
   */
  private function getRegLink() {
    return '<a href="?register">Register a new user</a>';
  }

  /**
   * Returns a back to login link as HTML
   * @return - The back link HTML
   */
  private function getBackLink() {
      return '<a href="./">Back to login</a>';
  }
}
