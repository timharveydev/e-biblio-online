<?php

// Fetch user's shopping basket contents from DB, if logged in
if (isset($_SESSION['currentUser'])) {
  $query = mysqli_query($connection, "SELECT basket FROM users WHERE username='$_SESSION[currentUser]'");
  $result = mysqli_fetch_array($query);

  // If basket not empty, unserialize contents and add to basketContents array, which stores book IDs
  if (!empty($result['basket'])) {
    $_SESSION['basketContents'] = unserialize($result['basket']);
  }
}

?>