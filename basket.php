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
  <title>E-Biblio | Basket</title>

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
        <li class="nav__item"><a href="#top" class="nav__icon basketIcon"><i class="fas fa-shopping-basket"></i></a></li>
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
    <h1 class="page-banner__title">Basket</h1>
  </div>





  <!-- Page Content
  ------------------------------------->
  <section class="basket">
    <div class="basket__container container">

      <!-- Alert Message (only shown when user not logged in) -->
      <?php

      if (!isset($_SESSION['currentUser'])) {
        echo '<p class="basket__alert"><strong>Please note - </strong>you are currently checking out as a guest. Upon completion of your order you will receive a one-time download link to download your e-book(s). If you would like to have the option to download your selected titles again in the future, please <a href="login_register.php?section=register">register as a member</a> before checking out.</p>';
      }

      ?>


      <!-- Allows basket contents to overflow with scroll on mobile devices -->
      <div class="basket__mobile-scroll-wrapper">

        <!-- Table Headings -->
        <div class="basket__headings">
          <h4 class="basket__headings--cover">Cover</h4>
          <h4 class="basket__headings--title">Title</h4>
          <h4 class="basket__headings--price">Price</h4>
          <h4 class="basket__headings--remove">Remove</h4>
        </div>


        <!-- Basket Item -->
        <div class="basket__item">

          <!-- Cover Image --> <!-- HREF NEEDS TO BE FILLED IN WITH ID ARGUMENT FOR IMG AND TITLE -->
          <a href="book_details.php" class="basket__item--img-wrapper">
            <img class="basket__item--img" src="img/book_covers/placeholder.jpg" alt="placeholder">
          </a>

          <!-- Book Title -->
          <a href="book_details.php" class="basket__item--title">Harry Potter and the Philosopher's Stone</a>

          <!-- Price -->
          <p class="basket__item--price">£7.99</p>

          <!-- Remove -->
          <form class="basket__item--remove">
            <button name="delete" type="submit" class="basket__item--remove-icon"><i class="fas fa-trash-alt"></i></button>
          </form>
        </div>


        <!-- Basket Item -->
        <div class="basket__item">

          <!-- Cover Image -->
          <a href="book_details.php" class="basket__item--img-wrapper">
            <img class="basket__item--img" src="img/book_covers/placeholder.jpg" alt="placeholder">
          </a>

          <!-- Book Title -->
          <a href="book_details.php" class="basket__item--title">Harry Potter and the Philosopher's Stone</a>

          <!-- Price -->
          <p class="basket__item--price">£7.99</p>

          <!-- Remove -->
          <form class="basket__item--remove">
            <button name="delete" type="submit" class="basket__item--remove-icon"><i class="fas fa-trash-alt"></i></button>
          </form>
        </div>
      </div>


      <!-- Basket Buttons -->
      <div class="basket__buttons">

        <!-- Continue Shopping Button -->
        <div class="basket__button-wrapper">
          <a href="books.php" class="basket__button button--positive button--large">Continue Shopping</a>
        </div>

        <!-- PayPal Checkout Button -->
        <div id="paypal-button-container" class="basket__button-wrapper"></div>

        <!-- PayPal JavaScript SDK -->
        <script src="https://www.paypal.com/sdk/js?client-id=AXCZiHEvIy82yFT5Clo2kg9XV01kDE1hIvsdN2JCbbD_bJ1-0BswedXCkgkyvpRUIcWXjELIDfrPowc_&currency=GBP&disable-funding=credit,card,sofort"></script>

        <script>
          paypal.Buttons({

            // Button Styling
            style: {
              height: 49,
              label: 'checkout'
            },

            // Set up the transaction
            createOrder: function(data, actions) {
              return actions.order.create({
                purchase_units: [{
                  amount: {
                    value: '7.99' // The total value of the shopping cart contents
                  }
                }]
              });
            },

            // Finalize the transaction
            onApprove: function(data, actions) {
              return actions.order.capture().then(function(details) {
                // Show a success message to the buyer then redirect to order confirmation
                alert('Transaction completed by ' + details.payer.name.given_name + '!');
                window.location.replace("payment_confirmation.php");
              });
            }

          // Render the PayPal button into #paypal-button-container
          }).render('#paypal-button-container');
        </script>
      </div>


      <!-- Basket Total -->
      <div class="basket__total">
        <h3>Total</h3>
        <h3>£7.99</h3>
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
        <li class="footer__item"><a href="#top" class="footer__link">Basket</a></li>
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