<?php
$item_id = $_POST['item_id'];
$loggedUser = $_POST['loggedUser'];

try {
  $pdo = new PDO('mysql:host=localhost;dbname=ejtihad_lib', 'root', '');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare("SELECT * FROM vid WHERE item_id = ?");
  $stmt->execute([$item_id]);

  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($row) {
    $stmt = $pdo->prepare("INSERT INTO fav (item_id, file, img, title, author, major, description, username_upload, upload_date, loggedUser) VALUES (:item_id, :file, :img, :title, :author, :major, :description, :username_upload, :upload_date, :loggedUser)");

    $stmt->bindParam(':item_id', $row['item_id']);
    $stmt->bindParam(':file', $row['file']);
    $stmt->bindParam(':img', $row['img']);
    $stmt->bindParam(':title', $row['title']);
    $stmt->bindParam(':author', $row['author']);
    $stmt->bindParam(':major', $row['major']);
    $stmt->bindParam(':description', $row['description']);
    $stmt->bindParam(':username_upload', $row['username_upload']);
    $stmt->bindParam(':upload_date', $row['upload_date']);
    $stmt->bindParam(':loggedUser', $loggedUser);

    $stmt->execute();

    $rowCount = $stmt->rowCount();

    if ($rowCount > 0) {
      echo "Item added to favorites";
    } else {
      echo "Unable to add item to favorites";
    }
  } else {
    echo "Item not found in vid table";
  }
} catch (PDOException $e) {
  error_log('Error: ' . $e->getMessage());
  echo "An error occurred. Please check the server logs for more details.";
}
?>