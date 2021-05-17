<?php

session_start();


// Connection
include 'connection.php';


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
  <title>E-Biblio | Home</title>

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
        <li class="nav__item"><a href="#top" class="nav__link">Home</a></li>
        <li class="nav__item"><a href="books.php" class="nav__link">Books</a></li>
        <li class="nav__item"><a href="about.php" class="nav__link">About</a></li>
        <li class="nav__item"><a href="contact.php" class="nav__link">Contact</a></li>
        <!-- Show link to admin panel when admin user logged in -->
        <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'admin') { echo '<li class="nav__item"><a href="admin_home.php" class="nav__link">Admin Panel</a></li>'; } ?>
      </ul>

      <!-- Basket & Account Icons -->
      <ul class="nav__icons">
        <li class="nav__item"><a href="basket.php" class="nav__icon basketIcon" aria-label="Shopping basket"><i class="fas fa-shopping-basket"></i></a></li>
        <li class="nav__item"><a class="nav__icon userIcon" onclick="toggleDropdownMenu()" aria-label="User icon"><i class="fas fa-user-circle"></i></a></li>
        <!-- Account Dropdown (contents shown dynamically using PHP) -->
        <li>
          <ul class="nav__dropdown">
            <?php if (isset($_SESSION['currentUser'])) {
              // If user logged in ...
              echo "<li class='nav__dropdown-item'><a class='nav__dropdown-link username'><strong>$_SESSION[currentUser]</strong></a></li>";
              echo '<li class="hr"></li>';
              echo '<li class="nav__dropdown-item"><a href="wishlist.php" class="nav__dropdown-link">Wishlist</a></li>';
              echo '<li class="nav__dropdown-item"><a href="purchase_history.php" class="nav__dropdown-link">Purchase History</a></li>';
              echo '<li class="hr"></li>';
              echo '<li class="nav__dropdown-item"><a href="logout.php" class="nav__dropdown-link warning">Logout</a></li>';
            }
            else {
              // If no user logged in ...
              echo '<li class="nav__dropdown-item"><a href="login_register.php?section=login" class="nav__dropdown-link">Login</a></li>';
              echo '<li class="nav__dropdown-item"><a href="login_register.php?section=register" class="nav__dropdown-link">Create an Account</a></li>';
              echo '<li class="hr"></li>';
              echo '<li class="nav__dropdown-item"><a class="nav__dropdown-link disabled">Wishlist</a></li>';
              echo '<li class="nav__dropdown-item"><a class="nav__dropdown-link disabled">Purchase History</a></li>';
            } ?>
          </ul>
        </li>
      </ul>

      <!-- Burger Menu (mobile only) -->
      <div class="nav__burger" onclick="toggleBurgerMenu()"><span class="fas fa-bars"></span></div>

    </div>
  </nav>





  <!-- Hero Screen
  ------------------------------------->
  <section class="hero">
    <div class="hero__container container">

      <!-- Hero BG Image Overlay-->
      <div class="hero__bg-overlay"></div>

      <!-- Hero Titles -->
      <div class="hero__titles">
        <h1 class="hero__h1">Welcome to<br><span>E-Biblio </span>Online</h1>
        <a class="hero__link" href="books.php">Shop now</a>
      </div>

    </div>
  </section>





  <!-- Featured Titles
  ------------------------------------->
  <section class="featured">
    <div class="featured__container container">

      <!-- Heading -->
      <div class="featured__titles">
        <h2 class="featured__heading">Featured Titles</h2>
        <p class="featured__description">Looking for something new to read? Check out some of our staff's top picks for this month for some inspiration.</p>
      </div>


      <!-- Book Grid -->
      <div class="featured__book-grid book-grid">


        <!-- Individual book tiles created dynamically by PHP -->
        <?php

          // Get featured books from DB
          $query = mysqli_query($connection, "SELECT * FROM books WHERE featured='featured' ORDER BY author");

          // Create book tiles for each title found
          while ($row = mysqli_fetch_array($query)) {
            extract($row);

            // Replace space in author name with underscore for use in URL
            $authorURL = str_replace(" ", "_", $author);

            echo "<!-- Book Grid Item -->";
            echo "<div class='book-grid__item'>";
            echo "  <a href='book_details.php?id=$ID' class='book-grid__link'>";
            echo "    <img class='book-grid__img' src='img/book_covers/$cover_image' alt='$title'>";
            echo "    <h4 class='book-grid__title'>$title</h4>";
            echo "  </a>";
            echo "  <div class='book-grid__flex-wrapper'>";
            echo "    <a href='books.php?author=$authorURL' class='book-grid__link'>";
            echo "      <h5 class='book-grid__author'>$author</h5>";
            echo "    </a>";
            echo "    <h5 class='book-grid__price'>£$price</h5>";
            echo "  </div>";
            echo "</div>";
          }

        ?>

      </div>

    </div>
  </section>





  <!-- Registration Prompt
  ------------------------------------->
  <section class="reg-prompt">
    <div class="reg-prompt__container container">

      <!-- Content -->
      <div class="reg-prompt__content">
        <h2 class="reg-prompt__heading">Become A Member Today</h2>
        <p class="reg-prompt__description">Found a book you like, but don't want to buy it right away? Become a member and get your own personal wishlist where you can save titles for later. You'll also gain access to your purchase history, where you can download previously purchased titles on demand.</p>
        <a href="login_register.php?section=register" class="reg-prompt__button button--primary button--large">Register</a>
      </div>

    </div>
  </section>





  <!-- Back to Top Button
  ------------------------------------->
  <a href="#top" class="back-to-top-button" aria-label="Back to top button"><i class="fas fa-chevron-up back-to-top-button__arrow"></i></a>





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
        <a class="footer__icon youtube"><i class="fab fa-youtube"></i></a>
      </div>

      <!-- Nav Links -->
      <ul class="footer__list">
        <li class="footer__item"><a href="#top" class="footer__link">Home</a></li>
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
        <div class="footer__icon paypal"><i class="fab fa-cc-paypal"></i></div>
      </div>
    </div>
  </section>





  <!-- Success alert - shown on successful registration -->
  <?php

  if (isset($_SESSION['registrationSuccess']) && $_SESSION['registrationSuccess'] == true) {
    echo '<script>alert("Registration successful!\nYou are now logged in.");</script>';
    unset($_SESSION['registrationSuccess']);
  }

  ?>





  <!-- JAVASCRIPT
  --------------------------------------------------------->
  <script type='text/javascript' src="js/navDropdown.js"></script>
  <script type='text/javascript' src="js/navScrollBackground.js"></script>
  <script type='text/javascript' src="js/burgerMenu.js"></script>


  <!-- END DOCUMENT
  --------------------------------------------------------->

</body>
</html>