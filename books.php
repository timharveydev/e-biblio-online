<?php

session_start();


// Connection
include 'connection.php';


// Stores current URL minus arguments
$_SESSION['redirect'] = strtok($_SERVER['REQUEST_URI'], '?');


// Declare search term and category variables
$searchTerm = '';
$category = '';


// Store search term from search bar, if set
if (isset($_POST['search'])) {
  // Replace apostrophe in string to avoid SQL errors
  $searchTerm = str_replace("'", "&#39;", $_POST['searchTerm']);
}


// Store author's name, if set (will overwrite searchTerm above)
if (isset($_GET['author'])) {
  $searchTerm = $_GET['author'];
}


// Store selected category, if set
if (isset($_GET['category'])) {
  $category = $_GET['category'];
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
  <title>E-Biblio | Books</title>

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
        <li class="nav__item"><a href="#top" class="nav__link">Books</a></li>
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
    <!-- Title changes dynamically based on category selected by user -->
    <?php

      // If category is set, set heading equal to category
      if ($category != '') {
        echo "<h1 class='page-banner__title'>$category</h1>";
      }
      // If category is not set, set heading equal to 'All Books'
      elseif ($category == '') {
        echo "<h1 class='page-banner__title'>All Books</h1>";
      }

    ?>
  </div>
  
  
  
  

  <!-- Page Content
  ------------------------------------->
  <section class="books">
    <div class="books__container container">

      <!-- Categories Heading -->
      <div class="books__column--narrow">
        <h3 class="books__sidebar-heading">Categories</h3>
      </div>


      <!-- Search Bar -->
      <div class="books__column--wide">

        <!-- Search bar component -->
        <form class="books__search-bar search-bar" action="books.php" method="POST">

          <label for="searchbox" hidden>Search for title or author</label>
          <input type="text" name="searchTerm" class="search-bar__input" id="searchbox" placeholder="Search title or author ...">

          <!-- Search button for large devices -->
          <button type="submit" name="search" class="search-bar__button button--positive"><i class="fas fa-search"></i> Search</button>

          <!-- Search button for phones -->
          <button type="submit" name="search" class="search-bar__button--mobile button--primary"><i class="fas fa-search"></i></button>
        </form>
      </div>
    </div>


    <!-- Dividing Line -->
    <div class="books__container container">
      <hr class="books__dividing-line">
    </div>


    <!-- Sidebar & Book Grid -->
    <div class="books__container--align-top container">

      <!-- Categories Sidebar -->
      <div class="books__column--narrow">
        <div class="books__categories-list">
          <!-- Category Item -->
          <a href="books.php" class="books__category-item"> 
            <p class="books__category-name">All Books</p>
            <?php $numberOfBooks = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM books")); ?>
            <p class="books__category-number">(<?php echo "$numberOfBooks"; ?>)</p>
          </a>
          <!-- Category Item -->
          <a href="books.php?category=Adventure" class="books__category-item">
            <p class="books__category-name">Adventure</p>
            <?php $numberOfBooks = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM books WHERE category='Adventure'")); ?>
            <p class="books__category-number">(<?php echo "$numberOfBooks"; ?>)</p>
          </a>
          <!-- Category Item -->
          <a href="books.php?category=Animals" class="books__category-item">
            <p class="books__category-name">Animals</p>
            <?php $numberOfBooks = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM books WHERE category='Animals'")); ?>
            <p class="books__category-number">(<?php echo "$numberOfBooks"; ?>)</p>
          </a>
          <!-- Category Item -->
          <a href="books.php?category=Art" class="books__category-item">
            <p class="books__category-name">Art</p>
            <?php $numberOfBooks = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM books WHERE category='Art'")); ?>
            <p class="books__category-number">(<?php echo "$numberOfBooks"; ?>)</p>
          </a>
          <!-- Category Item -->
          <a href="books.php?category=Biographies" class="books__category-item">
            <p class="books__category-name">Biographies</p>
            <?php $numberOfBooks = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM books WHERE category='Biographies'")); ?>
            <p class="books__category-number">(<?php echo "$numberOfBooks"; ?>)</p>
          </a>
          <!-- Category Item -->
          <a href="books.php?category=Business" class="books__category-item">
            <p class="books__category-name">Business</p>
            <?php $numberOfBooks = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM books WHERE category='Business'")); ?>
            <p class="books__category-number">(<?php echo "$numberOfBooks"; ?>)</p>
          </a>
          <!-- Category Item -->
          <!-- Categories with apostrophies should have the apostrophies removed before being used to search the DB, hence '?category=Childrens' in href -->
          <a href="books.php?category=Childrens" class="books__category-item">
            <p class="books__category-name">Children's</p>
            <?php $numberOfBooks = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM books WHERE category='Childrens'")); ?>
            <p class="books__category-number">(<?php echo "$numberOfBooks"; ?>)</p>
          </a>
          <!-- Category Item -->
          <a href="books.php?category=Classics" class="books__category-item">
            <p class="books__category-name">Classics</p>
            <?php $numberOfBooks = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM books WHERE category='Classics'")); ?>
            <p class="books__category-number">(<?php echo "$numberOfBooks"; ?>)</p>
          </a>
          <!-- Category Item -->
          <a href="books.php?category=Crime" class="books__category-item">
            <p class="books__category-name">Crime</p>
            <?php $numberOfBooks = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM books WHERE category='Crime'")); ?>
            <p class="books__category-number">(<?php echo "$numberOfBooks"; ?>)</p>
          </a>
          <!-- Category Item -->
          <a href="books.php?category=Computing" class="books__category-item">
            <p class="books__category-name">Computing</p>
            <?php $numberOfBooks = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM books WHERE category='Computing'")); ?>
            <p class="books__category-number">(<?php echo "$numberOfBooks"; ?>)</p>
          </a>
          <!-- Category Item -->
          <a href="books.php?category=Education" class="books__category-item">
            <p class="books__category-name">Education</p>
            <?php $numberOfBooks = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM books WHERE category='Education'")); ?>
            <p class="books__category-number">(<?php echo "$numberOfBooks"; ?>)</p>
          </a>
          <!-- Category Item -->
          <a href="books.php?category=Fantasy" class="books__category-item">
            <p class="books__category-name">Fantasy</p>
            <?php $numberOfBooks = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM books WHERE category='Fantasy'")); ?>
            <p class="books__category-number">(<?php echo "$numberOfBooks"; ?>)</p>
          </a>
          <!-- Category Item -->
          <a href="books.php?category=Food & Drink" class="books__category-item">
            <p class="books__category-name">Food & Drink</p>
            <?php $numberOfBooks = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM books WHERE category='Food & Drink'")); ?>
            <p class="books__category-number">(<?php echo "$numberOfBooks"; ?>)</p>
          </a>
          <!-- Category Item -->
          <a href="books.php?category=History" class="books__category-item">
            <p class="books__category-name">History</p>
            <?php $numberOfBooks = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM books WHERE category='History'")); ?>
            <p class="books__category-number">(<?php echo "$numberOfBooks"; ?>)</p>
          </a>
          <!-- Category Item -->
          <a href="books.php?category=Horror" class="books__category-item">
            <p class="books__category-name">Horror</p>
            <?php $numberOfBooks = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM books WHERE category='Horror'")); ?>
            <p class="books__category-number">(<?php echo "$numberOfBooks"; ?>)</p>
          </a>
          <!-- Category Item -->
          <a href="books.php?category=Lifestyle" class="books__category-item">
            <p class="books__category-name">Lifestyle</p>
            <?php $numberOfBooks = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM books WHERE category='Lifestyle'")); ?>
            <p class="books__category-number">(<?php echo "$numberOfBooks"; ?>)</p>
          </a>
          <!-- Category Item -->
          <a href="books.php?category=Philosophy" class="books__category-item">
            <p class="books__category-name">Philosophy</p>
            <?php $numberOfBooks = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM books WHERE category='Philosophy'")); ?>
            <p class="books__category-number">(<?php echo "$numberOfBooks"; ?>)</p>
          </a>
          <!-- Category Item -->
          <a href="books.php?category=Popular Science" class="books__category-item">
            <p class="books__category-name">Popular Science</p>
            <?php $numberOfBooks = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM books WHERE category='Popular Science'")); ?>
            <p class="books__category-number">(<?php echo "$numberOfBooks"; ?>)</p>
          </a>
          <!-- Category Item -->
          <a href="books.php?category=Romance" class="books__category-item">
            <p class="books__category-name">Romance</p>
            <?php $numberOfBooks = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM books WHERE category='Romance'")); ?>
            <p class="books__category-number">(<?php echo "$numberOfBooks"; ?>)</p>
          </a>
          <!-- Category Item -->
          <a href="books.php?category=Sci-Fi" class="books__category-item">
            <p class="books__category-name">Sci-Fi</p>
            <?php $numberOfBooks = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM books WHERE category='Sci-Fi'")); ?>
            <p class="books__category-number">(<?php echo "$numberOfBooks"; ?>)</p>
          </a>
          <!-- Category Item -->
          <a href="books.php?category=Space" class="books__category-item">
            <p class="books__category-name">Space</p>
            <?php $numberOfBooks = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM books WHERE category='Space'")); ?>
            <p class="books__category-number">(<?php echo "$numberOfBooks"; ?>)</p>
          </a>
          <!-- Category Item -->
          <a href="books.php?category=Sports" class="books__category-item">
            <p class="books__category-name">Sports</p>
            <?php $numberOfBooks = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM books WHERE category='Sports'")); ?>
            <p class="books__category-number">(<?php echo "$numberOfBooks"; ?>)</p>
          </a>
          <!-- Category Item -->
          <a href="books.php?category=Travel" class="books__category-item">
            <p class="books__category-name">Travel</p>
            <?php $numberOfBooks = mysqli_num_rows(mysqli_query($connection, "SELECT * FROM books WHERE category='Travel'")); ?>
            <p class="books__category-number">(<?php echo "$numberOfBooks"; ?>)</p>
          </a>
        </div>
      </div>


      <!-- Book Grid -->
      <div class="books__column--wide">
        <div class="books__book-grid book-grid">

        <!-- Individual book tiles created dynamically by PHP -->
        <?php

        // If search term is not set, fetch all books
        if ($searchTerm == '') {
          $query = mysqli_query($connection, "SELECT * FROM books ORDER BY author");
        }
        // If search term is set, fetch only relevant books
        elseif ($searchTerm != '') {
          $query = mysqli_query($connection, "SELECT * FROM books WHERE title LIKE '%$searchTerm%' OR author LIKE '%$searchTerm%' ORDER BY author");
        }


        // If category is set, fetch only books from that category
        if ($category != '') {
          $query = mysqli_query($connection, "SELECT * FROM books WHERE category='$category' ORDER BY author");
        }


        // Echo apology if no books found
        if (mysqli_num_rows($query) == 0) {
          echo "<p class='book-grid__no-results'>No books found - please check back again soon.</p>";
        }


        // Create book tiles for each title found
        while ($row = mysqli_fetch_array($query)) {
          extract($row);

          echo "<!-- Book Grid Item -->";
          echo "<div class='book-grid__item'>";
          echo "  <a href='book_details.php?id=$ID' class='book-grid__link'>";
          echo "    <img class='book-grid__img' src='img/book_covers/$cover_image' alt='$title'>";
          echo "    <h4 class='book-grid__title'>$title</h4>";
          echo "  </a>";
          echo "  <div class='book-grid__flex-wrapper'>";
          echo "    <a href='books.php?author=$author' class='book-grid__link'>";
          echo "      <h5 class='book-grid__author'>$author</h5>";
          echo "    </a>";
          echo "    <h5 class='book-grid__price'>£$price</h5>";
          echo "  </div>";
          echo "</div>";
        }

        ?>

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
        <li class="footer__item"><a href="#top" class="footer__link">Books</a></li>
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