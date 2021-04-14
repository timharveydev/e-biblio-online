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
      </ul>

      <!-- Basket & Account Icons -->
      <ul class="nav__icons">
        <li class="nav__item"><a href="basket.php" class="nav__icon basketIcon"><i class="fas fa-shopping-basket"></i></a></li>
        <li class="nav__item"><a class="nav__icon userIcon" onclick="toggleDropdownMenu()"><i class="fas fa-user-circle"></i></a></li>
        <!-- Account Dropdown -->
        <ul class="nav__dropdown">
          <li class="nav__dropdown-item"><a class="nav__dropdown-link username"><strong>username</strong></a></li>
          <li class="nav__dropdown-item"><a href="login_register.php" class="nav__dropdown-link">Sign In</a></li>
          <li class="nav__dropdown-item"><a href="login_register.php" class="nav__dropdown-link">Create an Account</a></li>
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

    <!-- Page Banner Title -->
    <h1 class="page-banner__title">All Books</h1>
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
        <form class="books__search-bar search-bar" method="POST">
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
          <a class="books__category-item">
            <p class="books__category-name">Category</p>
            <p class="books__category-number">(10)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="books__category-name">Category</p>
            <p class="books__category-number">(10)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="books__category-name">Category</p>
            <p class="books__category-number">(10)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="books__category-name">Category</p>
            <p class="books__category-number">(10)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="books__category-name">Category</p>
            <p class="books__category-number">(10)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="books__category-name">Category</p>
            <p class="books__category-number">(10)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="books__category-name">Category</p>
            <p class="books__category-number">(10)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="books__category-name">Category</p>
            <p class="books__category-number">(10)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="books__category-name">Category</p>
            <p class="books__category-number">(10)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="books__category-name">Category</p>
            <p class="books__category-number">(10)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="books__category-name">Category</p>
            <p class="books__category-number">(10)</p>
          </a>
          <!-- Category Item -->
          <a class="books__category-item">
            <p class="books__category-name">Category</p>
            <p class="books__category-number">(10)</p>
          </a>
        </div>
      </div>

      <!-- Book Grid -->
      <div class="books__column--wide">
        <div class="books__book-grid book-grid">

          <!-- Book Grid Item -->
          <div class="book-grid__item">
            <a href="book_details.php" class="book-grid__link">
              <img class="book-grid__img" src="img/book_covers/placeholder.jpg" alt="placeholder">
              <h4 class="book-grid__title">Harry Potter and the Philosopher's Stone</h4>
            </a>
            <a href="books.php" class="book-grid__link">
              <h5 class="book-grid__author">J K Rowling</h5>
            </a>
            <h5 class="book-grid__price">£7.99</h5>
          </div>

          <!-- Book Grid Item -->
          <div class="book-grid__item">
            <a href="book_details.php" class="book-grid__link">
              <img class="book-grid__img" src="img/book_covers/placeholder.jpg" alt="placeholder">
              <h4 class="book-grid__title">Harry Potter and the Philosopher's Stone</h4>
            </a>
            <a href="books.php" class="book-grid__link">
              <h5 class="book-grid__author">J K Rowling</h5>
            </a>
            <h5 class="book-grid__price">£7.99</h5>
          </div>

          <!-- Book Grid Item -->
          <div class="book-grid__item">
            <a href="book_details.php" class="book-grid__link">
              <img class="book-grid__img" src="img/book_covers/placeholder.jpg" alt="placeholder">
              <h4 class="book-grid__title">Harry Potter and the Philosopher's Stone</h4>
            </a>
            <a href="books.php" class="book-grid__link">
              <h5 class="book-grid__author">J K Rowling</h5>
            </a>
            <h5 class="book-grid__price">£7.99</h5>
          </div>

          <!-- Book Grid Item -->
          <div class="book-grid__item">
            <a href="book_details.php" class="book-grid__link">
              <img class="book-grid__img" src="img/book_covers/placeholder.jpg" alt="placeholder">
              <h4 class="book-grid__title">Harry Potter and the Philosopher's Stone</h4>
            </a>
            <a href="books.php" class="book-grid__link">
              <h5 class="book-grid__author">J K Rowling</h5>
            </a>
            <h5 class="book-grid__price">£7.99</h5>
          </div>

          <!-- Book Grid Item -->
          <div class="book-grid__item">
            <a href="book_details.php" class="book-grid__link">
              <img class="book-grid__img" src="img/book_covers/placeholder.jpg" alt="placeholder">
              <h4 class="book-grid__title">Harry Potter and the Philosopher's Stone</h4>
            </a>
            <a href="books.php" class="book-grid__link">
              <h5 class="book-grid__author">J K Rowling</h5>
            </a>
            <h5 class="book-grid__price">£7.99</h5>
          </div>

          <!-- Book Grid Item -->
          <div class="book-grid__item">
            <a href="book_details.php" class="book-grid__link">
              <img class="book-grid__img" src="img/book_covers/placeholder.jpg" alt="placeholder">
              <h4 class="book-grid__title">Harry Potter and the Philosopher's Stone</h4>
            </a>
            <a href="books.php" class="book-grid__link">
              <h5 class="book-grid__author">J K Rowling</h5>
            </a>
            <h5 class="book-grid__price">£7.99</h5>
          </div>

          <!-- Book Grid Item -->
          <div class="book-grid__item">
            <a href="book_details.php" class="book-grid__link">
              <img class="book-grid__img" src="img/book_covers/placeholder.jpg" alt="placeholder">
              <h4 class="book-grid__title">Harry Potter and the Philosopher's Stone</h4>
            </a>
            <a href="books.php" class="book-grid__link">
              <h5 class="book-grid__author">J K Rowling</h5>
            </a>
            <h5 class="book-grid__price">£7.99</h5>
          </div>

          <!-- Book Grid Item -->
          <div class="book-grid__item">
            <a href="book_details.php" class="book-grid__link">
              <img class="book-grid__img" src="img/book_covers/placeholder.jpg" alt="placeholder">
              <h4 class="book-grid__title">Harry Potter and the Philosopher's Stone</h4>
            </a>
            <a href="books.php" class="book-grid__link">
              <h5 class="book-grid__author">J K Rowling</h5>
            </a>
            <h5 class="book-grid__price">£7.99</h5>
          </div>

          <!-- Book Grid Item -->
          <div class="book-grid__item">
            <a href="book_details.php" class="book-grid__link">
              <img class="book-grid__img" src="img/book_covers/placeholder.jpg" alt="placeholder">
              <h4 class="book-grid__title">Harry Potter and the Philosopher's Stone</h4>
            </a>
            <a href="books.php" class="book-grid__link">
              <h5 class="book-grid__author">J K Rowling</h5>
            </a>
            <h5 class="book-grid__price">£7.99</h5>
          </div>

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