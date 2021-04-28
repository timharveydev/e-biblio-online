<?php

session_start();


// Connection
include 'connection.php';


// If user not admin send alert and redirect to index.php
if ($_SESSION['admin'] != 'admin') {
  echo '<script type="text/javascript">'; 
  echo 'alert("You do not have permission to view this page");';
  echo 'window.location.href = "index.php";';
 echo '</script>';
}


// Stores current URL minus arguments
$_SESSION['redirect'] = strtok($_SERVER['REQUEST_URI'], '?');


// Store search term from search bar
// Replace apostrophe in string to avoid SQL errors
if (isset($_POST['search'])) {
  $searchTerm = str_replace("'", "&#39;", $_POST['searchTerm']);
}
else {
  $searchTerm = '';
}


// Update database when Update button is pressed
// Replace apostrophes in strings to avoid SQL errors
if (isset($_POST['update'])) {
  $username = str_replace("'", "&#39;", $_POST['username']);
  $password = str_replace("'", "&#39;", $_POST['password']);

  mysqli_query($connection, "UPDATE users SET username='$username', password='$password' WHERE ID='$_POST[id]'");

  // Reload page with success alert
  header("Location: " . $_SESSION['redirect'] . "?success=success");
}


// Delete from database when Delete button is pressed
if (isset($_POST['delete'])) {
  mysqli_query($connection, "DELETE FROM users WHERE ID='$_POST[id]'");

  // Reload page with success alert
  header("Location: " . $_SESSION['redirect'] . "?success=success");
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
  <title>E-Biblio | Change & Remove Users</title>

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
    <h1 class="page-banner__title">Change / Remove Users</h1>
  </div>





  <!-- Page Content
  ------------------------------------->
  <section class="admin-change-users">
    <div class="admin-change-users__container container">

      <h3 class="admin-change-users__description">Use this grid to update user details and delete users as required.</h3>

      <!-- Search bar component -->
      <form class="admin-change-users__search-bar search-bar" action="admin_change_users.php" method="POST">
        <label for="searchbox" hidden>Search for a user</label>
        <input type="text" name="searchTerm" class="search-bar__input" id="searchbox" placeholder="Search user details ...">

        <!-- Search button for large devices -->
        <button type="submit" name="search" class="search-bar__button button--positive"><i class="fas fa-search"></i> Search</button>

        <!-- Search button for phones -->
        <button type="submit" name="search" class="search-bar__button--mobile button--primary"><i class="fas fa-search"></i></button>
      </form>


      <!-- Instruction -->
      <p class="admin-change-users__instruction">Run an empty search to refresh the user list.</p>


      <!-- PHP shows success confirmation when user details changed -->
      <?php

      if (isset($_GET['success']) && $_GET['success'] == 'success') {
        echo '<span class="admin-change-users__success">Changes successful</span>';
      }

      ?>
      

      <!-- Users table (data table component) -->
      <div class="admin-change-users__data-table data-table">

        <!-- Table headings -->
        <form class="data-table__form">
          <label for="username" hidden>username</label>
          <input type="text" id="username" class="data-table__heading" value="Username" readonly>

          <label for="password" hidden>password</label>
          <input type="text" id="password" class="data-table__heading" value="Password" readonly>

          <input type="submit" class="data-table__button--hidden button--primary" value="Update">
          <button type="submit" class="data-table__button--hidden data-table__remove-icon" value="Delete"><i class='fas fa-trash-alt'></i></button>
        </form>

        <hr>

        <!-- Table content -> PHP creates separate form for each user, taking info from DB -->
        <?php

        // If search term exists, show requested content only
        if ($searchTerm != '') {
          $query = mysqli_query($connection, "SELECT * FROM users WHERE (NOT admin <=> 'admin') AND (username LIKE '%$searchTerm%' OR password LIKE '%$searchTerm%') ORDER BY username");
        }
        // Else if search term isn't set, show all content from DB
        else {
          $query = mysqli_query($connection, "SELECT * FROM users WHERE NOT admin <=> 'admin' ORDER BY username");
        }

        while ($row = mysqli_fetch_array($query)) {
          extract($row);
          echo "<form class='data-table__form' action='admin_change_users.php' method='POST'>";

          echo "<label for='$username' hidden>username</label>";
          echo "<input name='username' type='text' id='$username' class='data-table__input' value='$username' maxlength='20' required>";

          echo "<label for='$ID$password' hidden>password</label>";
          echo "<input name='password' type='password' id='$ID$password' class='data-table__input' value='$password' minlength='8' maxlength='20' required>";

          echo "<input name='id' type='hidden' class='data-table__input' value='$ID'>";

          echo "<input name='update' type='submit' class='data-table__button button--primary' value='Update'>";
          echo "<button name='delete' type='submit' class='data-table__button data-table__remove-icon' value='Delete'><i class='fas fa-trash-alt'></i></button>";
          echo "</form>";
        }

        ?>

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