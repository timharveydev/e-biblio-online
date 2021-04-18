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
  <title>E-Biblio | Book Details</title>

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
        <!-- Show link to admin panel when admin user logged in -->
        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'admin') { echo '<li class="nav__item"><a href="admin_home.php" class="nav__link">Admin Panel</a></li>'; } ?>
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
    <h1 class="page-banner__title">J K Rowling</h1>
  </div>





  <!-- Page Content
  ------------------------------------->
  <section class="book-details">
    <div class="book-details__container container">

      <!-- Book Image -->
      <div class="book-details__column--narrow">
        <img class="book-details__img" src="img/book_covers/placeholder.jpg" alt="placeholder">
      </div>


      <!-- Text Content -->
      <div class="book-details__column--wide">
        <!-- Book Title -->
        <h3 class="book-details__heading">Harry Potter and the Philosopher's Stone</h3>
        <!-- Author -->
        <h5 class="book-details__author">J K Rowling</h5>
        <!-- Price -->
        <h4 class="book-details__price">£7.99</h4>

        <!-- Dividing Line -->
        <hr class="book-details__dividing-line">

        <!-- Book Summary -->
        <p class="book-details__summary">Harry Potter has never even heard of Hogwarts when the letters start dropping on the doormat at number four, Privet Drive. Addressed in green ink on yellowish parchment with a purple seal, they are swiftly confiscated by his grisly aunt and uncle. Then, on Harry's eleventh birthday, a great beetle-eyed giant of a man called Rubeus Hagrid bursts in with some astonishing news: Harry Potter is a wizard, and he has a place at Hogwarts School of Witchcraft and Wizardry. An incredible adventure is about to begin!</p>

        <!-- Additional Info -->
        <p class="book-details__additional-info">Having now become classics of our time, the Harry Potter ebooks never fail to bring comfort and escapism to readers of all ages. With its message of hope, belonging and the enduring power of truth and love, the story of the Boy Who Lived continues to delight generations of new readers.</p>

        <!-- Buttons -->
        <div class="book-details__button-wrapper">
          <a href="basket.php" class="book-details__button button--primary">Add to Basket</a>
          <a href="wishlist.php" class="book-details__button button--positive">Add to Wishlist</a>
        </div>
      </div>


      <!-- Categories Sidebar -->
      <div class="book-details__column--narrow">

        <!-- Categories Heading -->
        <h3 class="book-details__heading">Categories</h3>

        <!-- Dividing Line -->
        <hr class="book-details__dividing-line">

        <div class="book-details__categories-list">
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="book-details__category-name">All Books</p>
            <p class="book-details__category-number">(10)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="book-details__category-name">Adventure</p>
            <p class="book-details__category-number">(0)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="book-details__category-name">Animals</p>
            <p class="book-details__category-number">(0)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="book-details__category-name">Art</p>
            <p class="book-details__category-number">(0)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="book-details__category-name">Biographies</p>
            <p class="book-details__category-number">(0)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="book-details__category-name">Business</p>
            <p class="book-details__category-number">(0)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="book-details__category-name">Children's</p>
            <p class="book-details__category-number">(0)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="book-details__category-name">Classics</p>
            <p class="book-details__category-number">(0)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="book-details__category-name">Crime</p>
            <p class="book-details__category-number">(0)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="book-details__category-name">Computing</p>
            <p class="book-details__category-number">(0)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="book-details__category-name">Education</p>
            <p class="book-details__category-number">(0)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="book-details__category-name">Fantasy</p>
            <p class="book-details__category-number">(0)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="book-details__category-name">Food & Drink</p>
            <p class="book-details__category-number">(0)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="book-details__category-name">History</p>
            <p class="book-details__category-number">(0)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="book-details__category-name">Horror</p>
            <p class="book-details__category-number">(0)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="book-details__category-name">Lifestyle</p>
            <p class="book-details__category-number">(0)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="book-details__category-name">Philosophy</p>
            <p class="book-details__category-number">(0)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="book-details__category-name">Popular Science</p>
            <p class="book-details__category-number">(0)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="book-details__category-name">Romance</p>
            <p class="book-details__category-number">(0)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="book-details__category-name">Sci-Fi</p>
            <p class="book-details__category-number">(0)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="book-details__category-name">Space</p>
            <p class="book-details__category-number">(0)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="book-details__category-name">Sports</p>
            <p class="book-details__category-number">(0)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="book-details__category-name">Travel</p>
            <p class="book-details__category-number">(0)</p>
          </a>
        </div>
      </div>
    </div>


    <!-- Instructions For Use -->
    <div class="book-details__container container">
      <div class="book-details__instructions">
        <h5>Download Instructions</h5>
        <p>After you have completed your order, you will be taken to the payment confirmation screen where you will find the download link to your e-book. If you have registered as a member with us, you will also receive an email containing the download link. All of our e-books are provided in EPUB format. If you have an Amazon Kindle device, you can convert your EPUB file into a Kindle file <a href="https://epub2kindle.com/">here</a>.</p>
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