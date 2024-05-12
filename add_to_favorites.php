<?php
// Retrieve the values sent via POST
$item_id = $_POST['item_id'];
$loggedUser = $_POST['logged_user'];
$file = $_POST['file'];
$img = $_POST['img'];
$title = $_POST['title'];
$author = $_POST['author'];
$major = $_POST['major'];
$description = $_POST['description'];
$username_upload = $_POST['username_upload'];
$upload_date = $_POST['upload_date'];

// Perform the database insertion
// Assuming you have a favorites table with appropriate columns, you can use a prepared statement to insert the values
// Replace 'your_db_host', 'your_db_name', 'your_db_user', 'your_db_password' with your database credentials

try {
  $pdo = new PDO('mysql:host=localhost;dbname=ejtihad_lib', 'root', '');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare("INSERT INTO favorites (item_id, username, file, img, title, author, major, description, username_upload, upload_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->execute([$item_id, $loggedUser, $file, $img, $title, $author, $major, $description, $username_upload, $upload_date]);

  echo "Item added to favorites successfully";
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>