<?php

session_start();


// If user not admin send alert and redirect to index.php
if ($_SESSION['admin'] != 'admin') {
  echo '<script type="text/javascript">'; 
  echo 'alert("You do not have permission to view this page");';
  echo 'window.location.href = "index.php";';
 echo '</script>';
}


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
  <title>E-Biblio | Add New Book</title>

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
        <li class="nav__item"><a href="admin_home.php" class="nav__link">Admin Panel</a></li>
      </ul>

      <!-- Basket & Account Icons -->
      <ul class="nav__icons">
        <li class="nav__item"><a href="basket.php" class="nav__icon basketIcon"><i class="fas fa-shopping-basket"></i></a></li>
        <li class="nav__item"><a class="nav__icon userIcon" onclick="toggleDropdownMenu()"><i class="fas fa-user-circle"></i></a></li>
        <!-- Account Dropdown (contents shown dynamically using PHP) -->
        <ul class="nav__dropdown">
          <?php if (isset($_SESSION['currentUser'])) {
            // If user logged in ...
            echo "<li class='nav__dropdown-item'><a class='nav__dropdown-link username'><strong>$_SESSION[currentUser]</strong></a></li>";
            echo '<hr>';
            echo '<li class="nav__dropdown-item"><a href="wishlist.php" class="nav__dropdown-link">Wishlist</a></li>';
            echo '<li class="nav__dropdown-item"><a href="purchase_history.php" class="nav__dropdown-link">Purchase History</a></li>';
            echo '<hr>';
            echo '<li class="nav__dropdown-item"><a href="logout.php" class="nav__dropdown-link warning">Logout</a></li>';
          }
          else {
            // If no user logged in ...
            echo '<li class="nav__dropdown-item"><a href="login_register.php?section=login" class="nav__dropdown-link">Login</a></li>';
            echo '<li class="nav__dropdown-item"><a href="login_register.php?section=register" class="nav__dropdown-link">Create an Account</a></li>';
            echo '<hr>';
            echo '<li class="nav__dropdown-item"><a class="nav__dropdown-link disabled">Wishlist</a></li>';
            echo '<li class="nav__dropdown-item"><a class="nav__dropdown-link disabled">Purchase History</a></li>';
          } ?>
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

    <!-- Page Banner Title -->
    <h1 class="page-banner__title">Add New Book</h1>
  </div>





  <!-- Page Content
  ------------------------------------->
  <section class="admin-new-book">
    <div class="admin-new-book__container container">

      <h3 class="admin-new-book__description">Use this form to add a new book to the system.</h3>


      <!-- PHP shows success confirmation when new book added -->
      <?php

      if (isset($_GET['success']) && $_GET['success'] == 'success') {
        echo '<span class="admin-new-book__success">Book added successfully</span>';
      }

      ?>
      

      <!-- Book details form -->
      <form class="admin-new-book__form form" action="new_book_request.php" method="POST" enctype="multipart/form-data">

        <!-- Title -->
        <label for="title" class="form__label">Title</label>
        <input name="title" id="title" type="text" class="form__text-input" maxlength="40" required>

        <!-- Author -->
        <label for="author" class="form__label">Author</label>
        <input name="author" id="author" type="text" class="form__text-input" maxlength="25" required>

        <!-- Category -->
        <label for="category" class="form__label">Category</label>
        <select name="category" class="form__select" id="category" >
          <option value="">Select category ...</option>
          <option value="Adventure">Adventure</option>
          <option value="Animals">Animals</option>
          <option value="Art">Art</option>
          <option value="Biographies">Biographies</option>
          <option value="Business">Business</option>
          <option value="Children's">Children's</option>
          <option value="Classics">Classics</option>
          <option value="Crime">Crime</option>
          <option value="Computing">Computing</option>
          <option value="Education">Education</option>
          <option value="Fantasy">Fantasy</option>
          <option value="Food & Drink">Food & Drink</option>
          <option value="History">History</option>
          <option value="Horror">Horror</option>
          <option value="Lifestyle">Lifestyle</option>
          <option value="Philosohpy">Philosohpy</option>
          <option value="Popular Science">Popular Science</option>
          <option value="Romance">Romance</option>
          <option value="Sci-Fi">Sci-Fi</option>
          <option value="Space">Space</option>
          <option value="Sports">Sports</option>
          <option value="Travel">Travel</option>
        </select>

        <!-- Price -->
        <label for="price" class="form__label">Price <span class="subtle">(format x.xx)</span></label>
        <input name="price" id="price" type="text" class="form__text-input" maxlength="6" required>

        <!-- Summary -->
        <label for="summary" class="form__label">Summary <span class="subtle">(limit 1000 characters)</span></label>
        <textarea name="summary" id="summary" cols="50" rows="5" class="form__text-area" maxlength="1000" required></textarea>

        <!-- Additional Info. -->
        <label for="additional-info" class="form__label">Additional Info <span class="subtle">(limit 1000 characters)</span> - optional</label>
        <textarea name="additional-info" id="additional-info" cols="50" rows="5" class="form__text-area" maxlength="1000"></textarea>

        <!-- Cover Image -->
        <!-- File name can't include apostrophies as they mess with SQL -->
        <label for="image" class="form__label"><u>Upload Cover Image</u>
        <br>
        <span class="subtle">Files should be in .jpg, .jpeg or .png format and file names should only include characters a-z, A-Z and 0-9.</span></label>
        <input name="image" id="image" type="file" class="form__file-upload-button" required>

        <!-- Featured -->
        <label for="featured" class="form__label">Featured? <span class="subtle">(homepage can display max. 5 featured titles at once)</span></label>
        <p class="form__checkbox-description">Feature this title?</p>
        <input name="featured" id="featured" type="checkbox" class="form__checkbox">

        <br>

        <!-- Submit / Reset -->
        <input name="submit" type="submit" value="Add Book" class="form__button button--positive">
        <input name="reset" type="reset" value="Reset" id="reset" class="form__button button--negative">
        <label for="reset" hidden>Reset</label>
        
      </form>

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
        <!-- Show link to wishlist when user logged in -->
        <?php if (isset($_SESSION['currentUser'])) { echo '<li class="footer__item"><a href="wishlist.php" class="footer__link">Wishlist</a></li>'; } ?>
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