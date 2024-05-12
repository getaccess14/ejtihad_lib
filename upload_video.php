<?php
// upload.php

// Database connection settings
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

session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $loggedUser = $_SESSION['username'];
    // Use the $loggedUser variable as needed
    //echo "Logged User: " . $loggedUser;
}

// Check if the form was submitted and a file was selected
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["videoFile"]["name"])) {
    $file = $_FILES["videoFile"];
    $title = $_POST["title"];
    $author = $_POST["author"];
    $major = $_POST["major"];
    $educationLevel = $_POST["education_level"];
    $description = $_POST["description"];
    if (empty($description)) {
        $description = 'For more information about this video, click the "View" button or download it using the "Download" button.';
    } else {
        $description = substr($description, 0, 100) . '... For more information about this video, click the "View" button or download it using the "Download" button.';
    }
    $uploadDate = date("Y-m-d");
    // Rest of the code...
    // Get the current date

    // Move the uploaded file to a directory on the server
    $targetDir = "Videos/"; // Specify the directory where you want to store the uploaded videos
    $targetFile = $targetDir . basename($file["name"]);

    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        // File upload successful, insert the file details into the database
        $filePath = $targetFile;

        // Prepare and execute the SQL statement to insert the file details into the 'videos' table
        $sql = "INSERT INTO vid (file, title, author, major, education_level, description, username_upload, upload_date) VALUES ('$filePath', '$title', '$author', '$major', '$educationLevel', '$description', '$loggedUser', '$uploadDate')";
        if ($conn->query($sql) === true) {
            echo "Video uploaded and saved to the database.";

            // Redirect to pdfimg.php with the uploaded file path
            header("Location: vidimg.php?file=" . urlencode($filePath));
            exit();
        } else {
            echo "Error inserting video into the database: " . $conn->error;
        }
    } else {
        echo "Error uploading video: " . $_FILES["videoFile"]["error"];
    }
} else {
    // Display the HTML form for uploading a video
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Upload Video</title>
		<link rel="stylesheet" type="text/css" href="../CSS/upload_material.css">

    </head>
    <body>
    </br></br></br></br>
    <div class="form-container">
        <h2>Enter Video Details</h2>
        <form action="upload_video.php" method="post" enctype="multipart/form-data">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required><br>

            <label for="author">Author:</label>
            <input type="text" name="author" id="author" required><br>

			<label for="major">Major:</label>
			<select name="major" id="major" required>
				<option value="">Select Major</option>
				<option value="Computer Science">Computer Science</option>
				<option value="Information Management">Information Management</option>
				<option value="Information Systems">Information Systems</option>
				<option value="Information Technology">Information Technology</option>
			</select><br>

			<label for="education_level">Education Level:</label>
			<select name="education_level" id="education_level" required>
				<option value="">Select Education Level</option>
				<option value="First Level">First Level</option>
				<option value="Second Level">Second Level</option>
				<option value="Third Level">Third Level</option>
				<option value="Fourth Level">Fourth Level</option>
			</select><br>

            <label for="description">Description:</label><br>
            <textarea name="description" id="description" rows="4" cols="50"></textarea><br>

            <input type="file" name="videoFile" accept="video/*" required> <br> <br>
            <input type="submit" value="Upload">
        </form>
    </div>
	</br></br></br>
    </body>
    </html>

    <?php

}

// Close the connection
$conn->close();
?>