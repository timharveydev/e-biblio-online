<?php

session_start();

// Stores current URL minus arguments
$_SESSION['redirect'] = strtok($_SERVER['REQUEST_URI'], '?');

?>

<!DOCTYPE html>
<html lang="en">
<head>

  <!-- METAS & TITLE
  --------------------------------------------------------->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Tim Harvey">
  <meta name="description" content="A dynamic e-commerce website specializing in e-books, created for my HND Web Development course.">
  <title>E-Biblio | Register & Login</title>

  <!-- CSS
  --------------------------------------------------------->
  <link rel="stylesheet" href="css/main.css">

  <!-- FONTS
  --------------------------------------------------------->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- FONT AWESOME
  --------------------------------------------------------->
  <script src="https://kit.fontawesome.com/e9d2f03cce.js" crossorigin="anonymous"></script>

  <!-- FAVICON
  --------------------------------------------------------->
  <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
  <link rel="manifest" href="img/favicon/site.webmanifest">

</head>
<body id="top">

  <!-- MAIN CONTENT
  --------------------------------------------------------->

  <!-- Navigation
  ------------------------------------->
  <nav class="nav">
    <div class="nav__container">

      <!-- Logo -->
      <div class="nav__logo">
        <img src="img/logo.png" alt="E-Biblio Logo">
      </div>

      <!-- Nav Links -->
      <ul class="nav__list">
        <li class="nav__item"><a href="index.php" class="nav__link">Home</a></li>
        <li class="nav__item"><a href="books.php" class="nav__link">Books</a></li>
        <li class="nav__item"><a href="about.php" class="nav__link">About</a></li>
        <li class="nav__item"><a href="contact.php" class="nav__link">Contact</a></li>
      </ul>

      <!-- Basket & Account Icons -->
      <ul class="nav__icons">
        <li class="nav__item"><a href="basket.php" class="nav__icon basketIcon"><i class="fas fa-shopping-basket"></i></a></li>
        <li class="nav__item"><a class="nav__icon userIcon" onclick="toggleDropdownMenu()"><i class="fas fa-user-circle"></i></a></li>
        <!-- Account Dropdown -->
        <ul class="nav__dropdown">
          <li class="nav__dropdown-item"><a class="nav__dropdown-link username"><strong>username</strong></a></li>
          <li class="nav__dropdown-item"><a href="login_register.php?section=login" class="nav__dropdown-link">Sign In</a></li>
          <li class="nav__dropdown-item"><a href="login_register.php?section=register" class="nav__dropdown-link">Create an Account</a></li>
          <hr>
          <li class="nav__dropdown-item"><a href="wishlist.php" class="nav__dropdown-link disabled">Wishlist</a></li>
          <li class="nav__dropdown-item"><a href="purchase_history.php" class="nav__dropdown-link disabled">Purchase History</a></li>
          <hr>
          <li class="nav__dropdown-item"><a href="logout.php" class="nav__dropdown-link warning">Logout</a></li>
        </ul>
      </ul>

      <!-- Burger Menu (mobile only) -->
      <div class="nav__burger" onclick="toggleBurgerMenu()"><span class="fas fa-bars"></span></div>

    </div>
  </nav>





  <!-- Page Banner
  ------------------------------------->
  <div class="page-banner">
    <!-- Page Banner BG Image Overlay -->
    <div class="page-banner__bg-overlay"></div>

    <!-- Page Banner Title (PHP determines text based on where user came from) -->
    <?php
      if (isset($_GET['section']) && $_GET['section'] == 'login') {
        echo '<h1 class="page-banner__title">Login</h1>';
      } 
      elseif (isset($_GET['section']) && $_GET['section'] == 'register') {
        echo '<h1 class="page-banner__title">Register</h1>';
      }
      else {
        echo '<h1 class="page-banner__title">Welcome</h1>';
      }
    ?>
  </div>





  <!-- Page Content
  ------------------------------------->
  <section class="login-register">
    <div class="login-register__container container">

      <!-- LOGIN FORM -->
      <div class="login-register__column">

        <!-- Heading -->
        <h3 class="login-register__heading">Login</h3>

        <!-- Form Component (PHP ads 'focus' class depending on where the user came from) -->
        <div class="login-register__form-box <?php if (isset($_GET['section']) && $_GET['section'] == 'login') { echo 'focus'; } ?> ">
          <form class="login-register-form form" action="login_request.php" method="POST">

            <!-- Username (PHP displays error if user details not found in DB) -->
            <label for="login-username" class="form__label">Username</label>
            <?php if(isset($_GET['error']) && $_GET['error'] == 'user_details_not_found') { echo '<span class="form__error">Details not found - you need to register before you can login</span>';} ?>
            <input name="username" id="login-username" type="text" class="form__text-input" maxlength="20" required>
    
            <!-- Password -->
            <label for="login-password" class="form__label">Password</label>
            <input name="password" id="login-password" type="password" class="form__text-input" minlength="8" maxlength="20" required>
    
            <!-- Submit Button -->
            <input name="submit" type="submit" value="Login" class="form__button <?php if (isset($_GET['section']) && $_GET['section'] == 'login') { echo 'button--primary'; } else { echo 'button--positive'; } ?> ">
            <input name="submit" type="submit" value="Login" class="form__button--mobile <?php if (isset($_GET['section']) && $_GET['section'] == 'login') { echo 'button--primary'; } else { echo 'button--positive'; } ?> ">
          </form>
        </div>
      </div>


      <!-- REGISTRATION FORM -->
      <div class="login-register__column">
        
        <!-- Heading -->
        <h3 class="login-register__heading">Register</h3>

        <!-- Form Component (PHP ads 'focus' class depending on where the user came from) -->
        <div class="login-register__form-box <?php if (isset($_GET['section']) && $_GET['section'] == 'register') { echo 'focus'; } ?> ">
          <form class="login-register-form form" action="register_request.php" method="POST">

            <!-- Username (PHP displays error message) -->
            <label for="register-username" class="form__label">Username <span class="subtle">(max. 20 characters)</span></label>
            <?php if (isset($_GET['error']) && $_GET['error'] == 'usernameError') { echo '<span class="form__error">Sorry, this username already exists</span>'; } ?>
            <input name="username" id="register-username" type="text" class="form__text-input" maxlength="20" required>
    
            <!-- Password -->
            <label for="register-password" class="form__label">Password <span class="subtle">(8-20 characters)</span></label>
            <input name="password" id="register-password" type="password" class="form__text-input" minlength="8" maxlength="20" required>

            <!-- Confirm Password (PHP displays error message) -->
            <label for="register-confirm-password" class="form__label">Confirm Password</label>
            <?php if (isset($_GET['error']) && $_GET['error'] == 'passwordError') { echo '<span class="form__error">Password does not match</span>'; } ?>
            <input name="confirm-password" id="register-confirm-password" type="password" class="form__text-input" minlength="8" maxlength="20" required>

            <!-- Set $_SESSION['admin'] = empty string -->
            <input type="hidden" name="admin" value="">
    
            <!-- Submit Button -->
            <input name="submit" type="submit" value="Register" class="form__button <?php if (isset($_GET['section']) && $_GET['section'] == 'register') { echo 'button--primary'; } else { echo 'button--positive'; } ?> ">
            <input name="submit" type="submit" value="Register" class="form__button--mobile <?php if (isset($_GET['section']) && $_GET['section'] == 'register') { echo 'button--primary'; } else { echo 'button--positive'; } ?> ">
          </form>
        </div>
      </div>

    </div>
  </section>





  <!-- Footer
  ------------------------------------->
  <section class="footer">
    <div class="footer__container container">

      <!-- Logo -->
      <div class="footer__logo">
        <img src="img/logo.png" alt="E-Biblio Logo">
      </div>

      <!-- Message -->
      <p class="footer__message">Didn't find what you were looking for? Be sure to check back regularly as new titles are uploaded every week. You can also request new titles via our social media!</p>

      <!-- Social Media -->
      <div class="footer__social">
        <a class="footer__icon facebook"><i class="fab fa-facebook-f"></i></a>
        <a class="footer__icon twitter"><i class="fab fa-twitter"></i></a>
        <a class="footer__icon youtube"><i class="fab fa-youtube"></i></i></a>
      </div>

      <!-- Nav Links -->
      <ul class="footer__list">
        <li class="footer__item"><a href="index.php" class="footer__link">Home</a></li>
        <li class="footer__item"><a href="books.php" class="footer__link">Books</a></li>
        <li class="footer__item"><a href="about.php" class="footer__link">About</a></li>
        <li class="footer__item"><a href="contact.php" class="footer__link">Contact</a></li>
        <li class="footer__item"><a href="basket.php" class="footer__link">Basket</a></li>
      </ul>

    </div>

    <!-- Copyright & Payment Info -->
    <div class="footer__bottom-wrapper container">
      <p class="footer__copyright-text">&copy; 2021 E-Biblio Online. All Rights Reserved.</p>
      <div class="footer__payment-info">
        <div class="footer__icon mastercard"><i class="fab fa-cc-mastercard"></i></div>
        <div class="footer__icon visa"><i class="fab fa-cc-visa"></i></div>
        <div class="footer__icon paypal"><i class="fab fa-cc-paypal"></i></i></div>
      </div>
    </div>
  </section>





  <!-- JAVASCRIPT
  --------------------------------------------------------->
  <script type='text/javascript' src="js/navDropdown.js"></script>
  <script type='text/javascript' src="js/navScrollBackground.js"></script>
  <script type='text/javascript' src="js/burgerMenu.js"></script>


  <!-- END DOCUMENT
  --------------------------------------------------------->

</body>
</html>