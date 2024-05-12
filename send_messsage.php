<?php
// Database configuration
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "ejtihad_lib";

// Create a new MySQLi instance
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
	// Process the form submission
	if ($_SERVER["REQUEST_METHOD"] === "POST") {
		// Retrieve the form data
		$message_about = $_POST['message_about'];
		$your_name = $_POST['your_name'];
		$email_address = $_POST['email_address'];
		$your_message = $_POST['your_message'];


    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO contact_msg (message_about, your_name, email_address, your_message) VALUES (?, ?, ?, ?)");

    // Bind parameters and execute the statement
    $stmt->bind_param("ssss", $message_about, $your_name, $email_address, $your_message);
    $stmt->execute();

    // Check if the insertion was successful
	if ($stmt->affected_rows > 0) {
		header("Location: contact.php"); // Redirect to success page
		exit();
	} else {
		echo "Error sending message. Please try again.";
	}

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>