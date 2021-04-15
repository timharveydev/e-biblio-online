<?php

session_start();


// If previous URL not login_register.php, redirect to index.php
if ($_SESSION['redirect'] != '/e-biblio-online/login_register.php') {
  header("Location: index.php");
  exit();
}


// Connection
include 'connection.php';


// Automatically login if $_SESSION['username'] is already set - i.e. if the user has just completed the registration form
if (isset($_SESSION['username'])) {
  $_SESSION['currentUser'] = $_SESSION['username'];
  header("Location: index.php");
  exit();
}





// If $_SESSION['username'] not already set, standard log in process below:
// Apostrophes replaced in strings to avoid SQL errors
else {
  
  // User input variables
  $_SESSION['username'] = str_replace("'", "&#39;", $_POST['username']);
  $_SESSION['password'] = str_replace("'", "&#39;", $_POST['password']);

  // Check username and password exist in DB
  $query = mysqli_query($connection, "SELECT * FROM users WHERE username='$_SESSION[username]' AND password='$_SESSION[password]'");

  // If details not found, return to login form with error
  if (mysqli_num_rows($query) != 1) {
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    header("Location: login_register.php?section=login&error=user_details_not_found");
  }





  // If details found, set session variables
  else {

    // Set current user
    $_SESSION['currentUser'] = $_SESSION['username'];


    // Set admin status
    $query = mysqli_query($connection, "SELECT admin FROM users WHERE username='$_SESSION[username]'");
    $result = mysqli_fetch_array($query);

    $_SESSION['admin'] = $result['admin'];


    // Redirect to index page (regular users) or admin panel (admin users)
    if ($_SESSION['admin'] == 'admin') {
      header("Location: admin-home.php");
    }
    else {
      header("Location: index.php");
    }
  }
}

?>