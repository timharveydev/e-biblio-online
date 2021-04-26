<?php

session_start();


// Connection
include 'connection.php';

// Fetch wishlist contents
include 'fetch_wishlist.php';


// If user tries to access page without logging in, redirect to index.php
if (!isset($_SESSION['currentUser'])) {
  echo '<script type="text/javascript">'; 
  echo 'alert("You must be logged in to view this page.");';
  echo 'window.location.href = "index.php";';
 echo '</script>';
}


// Stores current URL minus arguments
$_SESSION['redirect'] = strtok($_SERVER['REQUEST_URI'], '?');


// ADD TO BASKET
// Append book ID to basketContents array when 'Add to Basket' button clicked
if (isset($_POST['addToBasket'])) {
  $_SESSION['basketContents'][] = $_GET['id'];

  // Serialize basketContents array and store in DB
  $contents = serialize($_SESSION['basketContents']);
  mysqli_query($connection, "UPDATE users SET basket='$contents' WHERE username='$_SESSION[currentUser]'");
}


// DELETE FROM WISHLIST
// Remove book ID from wishlistContents array when 'Delete' icon clicked
if (isset($_POST['delete'])) {
  // Search wishlistContents array for book id - if found, unset that key
  if (($key = array_search($_GET['removeID'], $_SESSION['wishlistContents'])) !== false) {
    unset($_SESSION['wishlistContents'][$key]);
  }

  // If user logged in, serialize wishlistContents array and store in DB
  if (isset($_SESSION['currentUser'])) {
    $contents = serialize($_SESSION['wishlistContents']);
    mysqli_query($connection, "UPDATE users SET wishlist='$contents' WHERE username='$_SESSION[currentUser]'");
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
  <title>E-Biblio | Wishlist</title>

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
    <h1 class="page-banner__title">Wishlist</h1>
  </div>





  <!-- Page Content
  ------------------------------------->
  <section class="wishlist">
    <div class="wishlist__container container">

      <!-- Allows wishlist contents to overflow with scroll on mobile devices -->
      <div class="wishlist__mobile-scroll-wrapper">

        <!-- Table Headings -->
        <div class="wishlist__headings">
          <h4 class="wishlist__headings--cover">Cover</h4>
          <h4 class="wishlist__headings--title">Title</h4>
          <h4 class="wishlist__headings--price">Price</h4>
          <h4 class="wishlist__headings--add-to-basket"></h4>
          <h4 class="wishlist__headings--remove"></h4>
        </div>


        <!-- Wishlist Items (displayed by PHP) -->
        <?php

        // If wishlistContents array not set or is empty, display 'Wishlist empty' message
        if (!isset($_SESSION['wishlistContents']) || empty($_SESSION['wishlistContents'])) {
          echo '<p class="wishlist__empty-alert">Wishlist is empty</p>';
        }
        // If wishlistContents array contains items, create and populate 'Wishlist Item' div for each
        else {
          // Get IDs from wishlistContents array and extract results
          foreach ($_SESSION['wishlistContents'] as $id) {
            $query = mysqli_query($connection, "SELECT * FROM books WHERE ID=$id");
            $result = mysqli_fetch_array($query);
            extract($result);

            // Echo wishlist Item div
            echo "<!-- Wishlist Item -->";
            echo "<div class='wishlist__item'>";

            echo "  <!-- Cover Image -->";
            echo "  <a href='book_details.php?id=$id' class='wishlist__item--img-wrapper'>";
            echo "    <img class='wishlist__item--img' src='img/book_covers/$cover_image' alt='$title'>";
            echo "  </a>";

            echo "  <!-- Book Title -->";
            echo "  <a href='book_details.php?id=$id' class='wishlist__item--title'>$title</a>";

            echo "  <!-- Price -->";
            echo "  <p class='wishlist__item--price'>£$price</p>";


            // ADD TO BASKET BUTTON
            // If book ID is already in basketContents array, display 'Added to basket' text and disable 'Add to Basket' button
            if (isset($_SESSION['basketContents']) && in_array($id, $_SESSION['basketContents'])) {
              echo '<p class="wishlist__item--add-to-basket button--success-text">Added to basket</p>';
            }
            // If book ID is NOT in basketContents array, display 'Add to Basket' button
            else {
              echo "  <!-- Add to Basket -->";
              echo "  <form class='wishlist__item--add-to-basket' action='wishlist.php?id=$id' method='POST'>";
              echo "    <button name='addToBasket' type='submit' class='wishlist__item--add-to-basket-button button--primary'>Add to Basket</button>";
              echo "  </form>";
            }


            echo "  <!-- Remove Icon -->";
            echo "  <form class='wishlist__item--remove' action='wishlist.php?removeID=$id' method='POST'>";
            echo "    <button name='delete' type='submit' class='wishlist__item--remove-icon'><i class='fas fa-trash-alt'></i></button>";
            echo "  </form>";

            echo "</div>";
          }
        }

        ?>

      </div>

      <!-- Continue Shopping -->
      <div class="wishlist__continue-shopping">
        <a href="books.php" class="wishlist__button button--positive button--large">Continue Browsing</a>
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