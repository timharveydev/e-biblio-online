<?php

session_start();


// If previous URL not admin_new_book.php, redirect to index.php
if ($_SESSION['redirect'] != '/e-biblio-online/admin_new_book.php') {
  header("Location: index.php");
  exit();
}


// Connection
include 'connection.php';


// Form input variables
// Apostrophes replaced in strings to avoid SQL errors
$title = str_replace("'", "&#39;", $_POST['title']);
$author = str_replace("'", "&#39;", $_POST['author']);
$category = str_replace("'", "", $_POST['category']); // Remove apostrophies alltogether as categories are hard coded - when refering to categories in the database e.g. "Children's", instead use "Childrens"
$price = str_replace("'", "&#39;", $_POST['price']);
$summary = str_replace("'", "&#39;", $_POST['summary']);
$additionalInfo = str_replace("'", "&#39;", $_POST['additional-info']);
$image = $_FILES['image']['name'];


// Move uploaded image file to 'img/book_covers' directory
move_uploaded_file($_FILES['image']['tmp_name'], "img/book_covers/$image");


// Insert data into DB (only adding featured attribute if checkbox selected)
if (empty($_POST['featured'])) {
  mysqli_query($connection, "INSERT INTO books (title, author, category, price, summary, additional_info, cover_image) VALUES ('$title', '$author', '$category', '$price', '$summary', '$additionalInfo', '$image')");
}
else {
  mysqli_query($connection, "INSERT INTO books (title, author, category, price, summary, additional_info, cover_image, featured) VALUES ('$title', '$author', '$category', '$price', '$summary', '$additionalInfo', '$image', 'featured')");
}


// Redirect with success alert
header("Location: " . $_SESSION['redirect'] . "?success=success");

?>