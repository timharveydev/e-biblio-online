<?php

session_start();


// If previous URL not login_register.php, redirect to index.php
if ($_SESSION['redirect'] != '/e-biblio-online/login_register.php') {
  header("Location: index.php");
  exit();
}


// Connection
include 'connection.php';


// User input variables
// Apostrophes replaced in strings to avoid SQL errors
$_SESSION['username'] = str_replace("'", "&#39;", $_POST['username']);
$_SESSION['password'] = str_replace("'", "&#39;", $_POST['password']);
$_SESSION['confirm-password'] = str_replace("'", "&#39;", $_POST['confirm-password']);
$_SESSION['admin'] = $_POST['admin'];


// Check username is not already taken - if it is, return to previous page with error
$query = mysqli_query($connection, "SELECT * FROM users WHERE username='$_SESSION[username]'");

if (mysqli_num_rows($query) > 0) {
  header("Location: " . $_SESSION['redirect'] . "?section=register&error=usernameError");
  exit();
}


// Check password matches confirm-password - if it doesn't, return to previous page with error
elseif ($_SESSION['password'] != $_SESSION['confirm-password']) {
  header("Location: " . $_SESSION['redirect'] . "?section=register&error=passwordError");
  exit();
}


// If above checks ok, insert data into DB
mysqli_query($connection, "INSERT INTO users (username, password, admin) VALUES ('$_SESSION[username]', '$_SESSION[password]', '$_SESSION[admin]')");


// Set reg-success variable to true - used to provide success alert following successful login
// Not applicable to admins adding new users
if ($_SESSION['admin'] != 'admin') {
  $_SESSION['registrationSuccess'] = true;
  header("Location: login_request.php");
}
else {
  header("Location: " . $_SESSION['redirect'] . "?success=success");
}

?>