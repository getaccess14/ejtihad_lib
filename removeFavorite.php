<?php
$item_id = $_POST['item_id'];
$loggedUser = $_POST['loggedUser'];

try {
  $pdo = new PDO('mysql:host=localhost;dbname=ejtihad_lib', 'root', '');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare("DELETE FROM fav WHERE item_id = ? AND loggedUser = ?");
  $stmt->execute([$item_id, $loggedUser]);

  $rowCount = $stmt->rowCount();

  if ($rowCount > 0) {
    echo "Item removed from favorites";
  } else {
    echo "Unable to remove item from favorites";
  }
} catch (PDOException $e) {
  error_log('Error: ' . $e->getMessage());
  echo "An error occurred. Please check the server logs for more details.";
}
?>