<?php
// Retrieve the search term from the query parameter
$searchTerm = $_GET['search'];
$isLogged = isset($_GET['isLogged']) ? $_GET['isLogged'] : false;

// Connect to the database (replace with your database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ejtihad_lib";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL query to search in the 'vid' table
$sql = "SELECT * FROM vid WHERE ";
$columns = ['title', 'description', 'author', 'major', 'education_level', 'img', 'item_id'];

// Construct the WHERE clause to search in all columns
$searchClauses = [];
foreach ($columns as $column) {
    $searchClauses[] = "$column LIKE '%$searchTerm%'";
}
$sql .= implode(" OR ", $searchClauses);

// Execute the query
$result = $conn->query($sql);

// Process the search results
$count = 0; // Initialize a counter variable
if ($result->num_rows > 0) {
    // Display the search results
    while ($row = $result->fetch_assoc()) {
        if ($count >= 3) {
            break; // Exit the loop if we have already displayed four results
        }
        // Display the search result

		$item_id = $row["item_id"];
		$file_path = $row["file"];
		// Construct the PDF URL based on the image name
// Get the item_id from the image URL

        echo '<div class="search-result">';
		echo '<a href="' . $file_path . '" target="_blank"><img src="' . $row['img'] . '" class="result-image"></a>';

        echo '<div class="result-details">';
		if ($isLogged) {
			// Add the "View" button for logged-in users
			echo '<div class="result-title-container">';
			echo '<p class="result-title">' . $row['title'] . '</p>';
			echo '<button class="view-button" onclick="x()">View</button>';
			echo '</div>';
		} else {
			echo '<p class="result-title">' . $row['title'] . '</p>';
		}
        
        echo '<p class="result-author">Author: ' . $row['author'] . '</p>';
        echo '<p class="result-major">Major: ' . $row['major'] . '</p>';
        echo '<p class="result-description">' . substr($row['description'], 0, 120) . (strlen($row['description']) > 120 ? "..." : "") . '</p>';
        //echo $item_id;
		echo '</div>';
        echo '</div>';
        echo '<hr>';

        $count++; // Increment the counter
    }
} else {
    echo "No results found.";
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
</head>
<body>
<script>
function x() {
    // Display the item_id in a prompt dialog
    window.prompt("Item ID:");
}


function ViewMaterial(item_id) {
    // Display the item_id in a prompt dialog
    window.prompt("Item ID:", item_id);
}
	
function xxxViewMaterial(item_id) {
		// Send an AJAX request to retrieve the PDF file URL and title
		console.log("Item ID:", item_id);
		var xhr = new XMLHttpRequest();
		xhr.open("GET", "get_pdf_url.php?item_id=" + item_id, true);

		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4 && xhr.status === 200) {
				// Request succeeded, handle the response
				var response = JSON.parse(xhr.responseText);
				var pdfUrl = response.pdfUrl;
				var title = response.title;

				// Open the PDF file in a new tab
				window.open(pdfUrl, "_blank");
			}
		};

		xhr.send();
	}
</script>

</body>
</html>