<?php
// remove_from_favorites.php

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the item_id and logged_user from the POST parameters
    $item_id = $_POST["item_id"];
    $loggedUser = $_POST["logged_user"];

    // Example code: Remove the item from the favorites table
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ejtihad_lib";

    // Create a new connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL statement to remove the item from the favorites table
    $sql = "DELETE FROM favorites WHERE item_id = '$item_id' AND username = '$loggedUser'";
    if ($conn->query($sql) === true) {
        echo "Item removed from favorites for user: " . $loggedUser;
    } else {
        echo "Error removing item from favorites: " . $conn->error;
    }

    // Close the connection
    $conn->close();
} else {
    // Return an error response for invalid requests
    echo "Invalid request method.";
}
?>