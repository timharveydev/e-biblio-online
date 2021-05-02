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
  $title = str_replace("'", "&#39;", $_POST['title']);
  $author = str_replace("'", "&#39;", $_POST['author']);
  $category = str_replace("'", "", $_POST['category']); // Apostrophies removed alltogether as categories are hard coded - when referring to categories in the database use "Childrens" instead of "Children's"
  $price = str_replace("'", "&#39;", $_POST['price']);
  $summary = str_replace("'", "&#39;", $_POST['summary']);
  $additionalInfo = str_replace("'", "&#39;", $_POST['additional-info']);

  // Set DB query based on whether Featured checkbox is set
  if (isset($_POST['featured'])) {
    mysqli_query($connection, "UPDATE books SET title='$title', author='$author', category='$category', price='$price', summary='$summary', additional_info='$additionalInfo', featured='featured' WHERE ID='$_POST[id]'");
  }
  else {
    mysqli_query($connection, "UPDATE books SET title='$title', author='$author', category='$category', price='$price', summary='$summary', additional_info='$additionalInfo', featured=NULL WHERE ID='$_POST[id]'");
  }

  // Reload page with success alert
  header("Location: " . $_SESSION['redirect'] . "?success=success");
}


// Delete from database when Delete button is pressed
if (isset($_POST['delete'])) {
  mysqli_query($connection, "DELETE FROM books WHERE ID='$_POST[id]'");

  // Remove image file from folder
  $file = 'img/book_covers/' . $_POST['imageName'];
  if (file_exists($file)) {
    chmod($file, 0777);
    unlink($file);
  }

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
  <title>E-Biblio | Change & Remove Books</title>

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
    <h1 class="page-banner__title">Change / Remove Books</h1>
  </div>





  <!-- Page Content
  ------------------------------------->
  <section class="admin-change-books">
    <div class="admin-change-books__container container">

      <h3 class="admin-change-books__description">Use this table to update book details and delete books as required.</h3>

      <!-- Search bar component -->
      <form class="admin-change-books__search-bar search-bar" action="admin_change_books.php" method="POST">
        <label for="searchbox" hidden>Search for a book</label>
        <input type="text" name="searchTerm" class="search-bar__input" id="searchbox" placeholder="Search book details ...">

        <!-- Search button for large devices -->
        <button type="submit" name="search" class="search-bar__button button--positive"><i class="fas fa-search"></i> Search</button>

        <!-- Search button for phones -->
        <button type="submit" name="search" class="search-bar__button--mobile button--primary"><i class="fas fa-search"></i></button>
      </form>


      <!-- Instruction -->
      <p class="admin-change-books__instruction">Run an empty search to refresh the book list.</p>


      <!-- PHP shows success confirmation when user details changed -->
      <?php

      if (isset($_GET['success']) && $_GET['success'] == 'success') {
        echo '<span class="admin-change-books__success">Changes successful</span>';
      }

      ?>
      

      <!-- Books table (data table component) -->
      <div class="admin-change-books__data-table data-table">

        <!-- Table headings -->
        <form class="data-table__form">
          <label for="cover-image" hidden>cover-image</label>
          <input type="text" id="cover-image" class="data-table__heading narrow" value="Cover Image" readonly>

          <label for="title" hidden>title</label>
          <input type="text" id="title" class="data-table__heading" value="Title" readonly>

          <label for="author" hidden>author</label>
          <input type="text" id="author" class="data-table__heading" value="Author" readonly>

          <label for="category" hidden>category</label>
          <input type="text" id="category" class="data-table__heading narrow" value="Category" readonly>

          <label for="price" hidden>price</label>
          <input type="text" id="price" class="data-table__heading narrow" value="Price (£)" readonly>

          <label for="summary" hidden>summary</label>
          <input type="text" id="summary" class="data-table__heading" value="Summary" readonly>

          <label for="additional-info" hidden>additional-info</label>
          <input type="text" id="additional-info" class="data-table__heading" value="Additional Info" readonly>

          <label for="featured" hidden>featured</label>
          <input type="text" id="featured" class="data-table__heading narrow" value="Featured?" readonly>

          <input type="submit" class="data-table__button--hidden button--primary" value="Update">
          <button type="submit" class="data-table__button--hidden data-table__remove-icon" value="Delete"><i class='fas fa-trash-alt'></i></button>
        </form>

        <hr class="data-table__hr admin-change-books__hr">


        <!-- Table content -> PHP creates separate form for each book, taking info from DB -->
        <?php

        // If search term exists, show requested content only
        if ($searchTerm != '') {
          $query = mysqli_query($connection, "SELECT * FROM books WHERE (title LIKE '%$searchTerm%' OR author LIKE '%$searchTerm%' OR category LIKE '%$searchTerm%' OR price LIKE '%$searchTerm%') ORDER BY title");
        }
        // Else if search term isn't set, show all content from DB
        else {
          $query = mysqli_query($connection, "SELECT * FROM books ORDER BY title");
        }

        while ($row = mysqli_fetch_array($query)) {
          extract($row);
          echo "<form class='data-table__form' action='admin_change_books.php' method='POST'>";

          // Cover Image
          echo "<a href='admin_change_cover_image.php?id=$ID' class='data-table__img-anchor'><img class='data-table__img narrow' src='img/book_covers/$cover_image' alt='$title'>Change Image</a>";

          // Title
          echo "<label for='$title' hidden>title</label>";
          echo "<input name='title' type='text' id='$title' class='data-table__input' value='$title' maxlength='60' required>";

          // Author
          echo "<label for='$author' hidden>author</label>";
          echo "<input name='author' type='text' id='$author' class='data-table__input' value='$author' maxlength='25' required>";

          // Category
          echo "<label for='$category' hidden>category</label>";
          echo "<select name='category' id='$category' class='data-table__select narrow' required>";
          echo "  <option value='$category'>$category</option>";
          echo "  <option value='Adventure'>Adventure</option>";
          echo "  <option value='Animals'>Animals</option>";
          echo "  <option value='Art'>Art</option>";
          echo "  <option value='Biographies'>Biographies</option>";
          echo "  <option value='Business'>Business</option>";
          echo "  <option value='Children's'>Children's</option>";
          echo "  <option value='Classics'>Classics</option>";
          echo "  <option value='Crime'>Crime</option>";
          echo "  <option value='Computing'>Computing</option>";
          echo "  <option value='Education'>Education</option>";
          echo "  <option value='Fantasy'>Fantasy</option>";
          echo "  <option value='Food & Drink'>Food & Drink</option>";
          echo "  <option value='History'>History</option>";
          echo "  <option value='Horror'>Horror</option>";
          echo "  <option value='Lifestyle'>Lifestyle</option>";
          echo "  <option value='Philosohpy'>Philosohpy</option>";
          echo "  <option value='Popular Science'>Popular Science</option>";
          echo "  <option value='Romance'>Romance</option>";
          echo "  <option value='Sci-Fi'>Sci-Fi</option>";
          echo "  <option value='Space'>Space</option>";
          echo "  <option value='Sports'>Sports</option>";
          echo "  <option value='Travel'>Travel</option>";
          echo "</select>";

          // Price
          echo "<label for='$price' hidden>price</label>";
          echo "<input name='price' type='text' id='$price' class='data-table__input narrow' value='$price' required>";

          // Summary
          echo "<label for='$summary' hidden>summary</label>";
          echo "<textarea name='summary' id='$summary' class='data-table__textarea' maxlength='1000' required>$summary</textarea>";

          // Additional Info
          echo "<label for='$additional_info' hidden>additional-info</label>";
          echo "<textarea name='additional-info' id='$additional_info' class='data-table__textarea' maxlength='1000'>$additional_info</textarea>";

          // Featured -> if statement adds 'checked' attribute if book is a featured title
          echo "<label for='$featured' hidden>featured</label>";
          if ($featured == 'featured') {
            echo "<input name='featured' type='checkbox' id='$featured' class='data-table__checkbox narrow' value='featured' checked>";
          }
          else {
            echo "<input name='featured' type='checkbox' id='$featured' class='data-table__checkbox narrow' value='featured'>";
          }

          // ID (hidden -> used to locate DB row to remove when Delete clicked)
          echo "<input name='id' type='hidden' class='data-table__input' value='$ID'>";

          // Cover Image Name (hidden -> used to remove image from folder when Delete clicked)
          echo "<input name='imageName' type='hidden' class='data-table__input' value='$cover_image'>";

          // Update & Delete buttons
          echo "<input name='update' type='submit' class='data-table__button button--primary' value='Update'>";
          echo "<button name='delete' type='submit' class='data-table__button data-table__remove-icon' value='Delete'><i class='fas fa-trash-alt'></i></button>";
          echo "</form>";
        }

        ?>

      </div>

    </div>
  </section>
  




  <!-- Back to Top Button
  ------------------------------------->
  <a href="#top" class="back-to-top-button"><i class="fas fa-chevron-up back-to-top-button__arrow"></i></a>





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