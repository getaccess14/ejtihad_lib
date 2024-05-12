<?php
// Retrieve the item_id from the query string
$item_id = $_GET['item_id'];

// Perform the database query to get the PDF file URL
// Assuming you have a vid table with appropriate columns, you can use a prepared statement to retrieve the URL
// Replace 'your_db_host', 'your_db_name', 'your_db_user', 'your_db_password' with your database credentials

try {
  $pdo = new PDO('mysql:host=localhost;dbname=ejtihad_lib', 'root', '');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $stmt = $pdo->prepare("SELECT file, title FROM vid WHERE item_id = ?");
  $stmt->execute([$item_id]);

  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  
  if ($result) {
    $pdfUrl = $result['file'];
    $title = $result['title'];
    
    // Set the response as a JSON object with the PDF URL and title
    $response = array('pdfUrl' => $pdfUrl, 'title' => $title);
    header('Content-Type: application/json');
    echo json_encode($response);
  } else {
    echo "PDF file not found";
  }
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>