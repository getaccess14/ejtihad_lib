<?php
if (isset($_GET['image']) && isset($_GET['url'])) {
  $imageName = $_GET['image'];
  $imageUrl = $_GET['url'];

  // Perform necessary database operations to upload the image information
  // Assuming you are using MySQLi, you can modify the code as per your database connection and table structure
  
  // Database connection
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "ejtihad_lib";

  $conn = new mysqli($servername, $username, $password, $database);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Get the latest row ID from the vid table
  $latestRowId = 0;
  $latestRowQuery = "SELECT MAX(item_id) AS latest_id FROM vid";
  $latestRowResult = $conn->query($latestRowQuery);

  if ($latestRowResult->num_rows > 0) {
    $latestRow = $latestRowResult->fetch_assoc();
    $latestRowId = $latestRow['latest_id'];
  }

  // Prepare and execute the SQL statement to update the latest row with the image URL
  $stmt = $conn->prepare("UPDATE vid SET img = ? WHERE item_id = ?");
  $stmt->bind_param("si", $imageUrl, $latestRowId);
  $stmt->execute();

  // Check if the update was successful
  if ($stmt->affected_rows > 0) {
    echo "Image uploaded successfully to the latest row in the database.";
  } else {
    echo "Error uploading image to the latest row in the database.";
  }

  $stmt->close();
  $conn->close();
} else {
  echo "Invalid request.";
}
?>