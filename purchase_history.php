<?php

session_start();


// Connection
include 'connection.php';


// If user tries to access page without logging in, redirect to index.php
if (!isset($_SESSION['currentUser'])) {
  echo '<script type="text/javascript">'; 
  echo 'alert("You must be logged in to view this page.");';
  echo 'window.location.href = "index.php";';
  echo '</script>';
}


// Stores current URL minus arguments
$_SESSION['redirect'] = strtok($_SERVER['REQUEST_URI'], '?');


// Fetch user's purchase history from DB, if logged in
if (isset($_SESSION['currentUser'])) {
  $query = mysqli_query($connection, "SELECT purchase_history FROM users WHERE username='$_SESSION[currentUser]'");
  $result = mysqli_fetch_array($query);

  // If purchase history not empty, unserialize contents and add to purchaseHistory array, which stores book IDs
  if (!empty($result['purchase_history'])) {
    $_SESSION['purchaseHistory'] = unserialize($result['purchase_history']);
  }
}

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
  <title>E-Biblio | Purchase History</title>

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





  <!-- Page Banner
  ------------------------------------->
  <div class="page-banner">
    <!-- Page Banner BG Image Overlay -->
    <div class="page-banner__bg-overlay"></div>

    <!-- Page Banner Title -->
    <h1 class="page-banner__title">Purchase History</h1>
  </div>





  <!-- Page Content
  ------------------------------------->
  <section class="purchase-history">
    <div class="purchase-history__container container">

      <!-- Allows purchase-history contents to overflow with scroll on mobile devices -->
      <div class="purchase-history__mobile-scroll-wrapper">

        <!-- Table Headings -->
        <div class="purchase-history__headings">
          <h4 class="purchase-history__headings--cover">Cover</h4>
          <h4 class="purchase-history__headings--title">Title</h4>
          <h4 class="purchase-history__headings--download"></h4>
        </div>


        <!-- Purchase History Items (displayed by PHP) -->
        <?php

        // If purchaseHistory array not set or is empty display 'You haven't purchased anything yet' message
        if (!isset($_SESSION['purchaseHistory']) || empty($_SESSION['purchaseHistory'])) {
          echo '<p class="purchase-history__empty-alert">You haven\'t purchased anything yet</p>';
        }
        // If purchaseHistory array contains items, create and populate 'Purchased Item' div for each
        else {
          // Get IDs from purchaseHistory array and extract results
          foreach ($_SESSION['purchaseHistory'] as $id) {
            $query = mysqli_query($connection, "SELECT * FROM books WHERE ID=$id");
            $result = mysqli_fetch_array($query);
            extract($result);

            // Echo Purchased Item div
            echo "<!-- Purchased Item -->";
            echo "<div class='purchase-history__item'>";

            echo "  <!-- Cover Image -->";
            echo "  <a href='book_details.php?id=$id' class='purchase-history__item--img-wrapper'>";
            echo "    <img class='purchase-history__item--img' src='img/book_covers/$cover_image' alt='$title'>";
            echo "  </a>";

            echo "  <!-- Book Title -->";
            echo "  <a href='book_details.php?id=$id' class='purchase-history__item--title'>$title</a>";

            echo "  <!-- Download Button -->";
            echo "  <form class='purchase-history__item--download'>";
            echo "    <button class='purchase-history__item--download-button button--primary'>Download</button>";
            echo "  </form>";

            echo "</div>";
          }
        }

        ?>

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
        <div class="footer__icon paypal"><i class="fab fa-cc-paypal"></i></div>
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