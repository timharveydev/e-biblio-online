<?php

session_start();


// Connection
include 'connection.php';


// If previous URL not basket.php, redirect to index.php
if ($_SESSION['redirect'] != '/~HNCWEBMR4/e-biblio-online/basket.php') {
  header("Location: index.php");
  exit();
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
  // If purchase history IS empty, set purchaseHistory = empty array
  else {
    $_SESSION['purchaseHistory'] = [];
  }

  // Merge current basket contents with purchaseHistory array
  $_SESSION['purchaseHistory'] = array_merge($_SESSION['purchaseHistory'], $_SESSION['basketContents']);
  
  // Serialize purchaseHistory array and store in DB
  $contents = serialize($_SESSION['purchaseHistory']);
  mysqli_query($connection, "UPDATE users SET purchase_history='$contents' WHERE username='$_SESSION[currentUser]'");

  // Remove purchased items from wishlist
  include 'fetch_wishlist.php';
  $_SESSION['wishlistContents'] = array_diff($_SESSION['wishlistContents'], $_SESSION['basketContents']);
  // Serialize wishlistContents and update in DB
  $contents = serialize($_SESSION['wishlistContents']);
  mysqli_query($connection, "UPDATE users SET wishlist='$contents' WHERE username='$_SESSION[currentUser]'");
}


// Add current basket contents to currentPurchases variable for use on payment confirmation page
$_SESSION['currentPurchases'] = $_SESSION['basketContents'];


// Remove IDs from basketContents and update in DB
$_SESSION['basketContents'] = [];
$contents = serialize($_SESSION['basketContents']);
mysqli_query($connection, "UPDATE users SET basket='$contents' WHERE username='$_SESSION[currentUser]'");


// Proceed to payment_confirmation.php
header("Location: payment_confirmation.php");

?>