<?php

// Fetch user's wishlist contents from DB, if logged in
if (isset($_SESSION['currentUser'])) {
  $query = mysqli_query($connection, "SELECT wishlist FROM users WHERE username='$_SESSION[currentUser]'");
  $result = mysqli_fetch_array($query);

  // If wishlist not empty, unserialize contents and add to wishlistContents array, which stores book IDs
  if (!empty($result['wishlist'])) {
    $_SESSION['wishlistContents'] = unserialize($result['wishlist']);
  }
}

?>