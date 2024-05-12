<!DOCTYPE html>
<html>
<head>
  <title>PDF Viewer</title>
  <link rel="stylesheet" type="text/css" href="../CSS/pdf.css">
  <link rel="stylesheet" type="text/css" href="../CSS/search.css">

  <style>
    .grid-container {
      display: grid;
      grid-template-columns: 25% 75%; /* Two columns, the left column takes 25%, the right column takes 75% */
      grid-gap: 20px; /* Gap between grid items */
    }

  </style>
</head>
<body>


  <div class="grid-container">
    <div class="filter-section">
      <div class="filter-category">
		<h1> My Favorites </h1>
        <h3>Filter by Major:</h3>
        <div class="filter-options">
          <a href="#" class="filter-option" onclick="applyFilter('Computer Science')">Computer Science</a>
          <a href="#" class="filter-option" onclick="applyFilter('Information Management')">Information Management</a>
          <a href="#" class="filter-option" onclick="applyFilter('Information Systems')">Information Systems</a>
          <a href="#" class="filter-option" onclick="applyFilter('Information Technology')">Information Technology</a>
        </div>
      </div>

      <div class="filter-category">
        <h3>Filter by Subject:</h3>
        <div class="filter-options">
          <a href="#" class="filter-option" onclick="applyFilter('Artificial intelligence')">Artificial intelligence</a>
          <a href="#" class="filter-option" onclick="applyFilter('Databases')">Databases</a>
          <a href="#" class="filter-option" onclick="applyFilter('Design and analysis of algorithms')">Design and analysis of algorithms</a>
          <a href="#" class="filter-option" onclick="applyFilter('Ethics and responsible innovation')">Ethics and responsible innovation</a>
          <a href="#" class="filter-option" onclick="applyFilter('Human-computer interaction')">Human-computer interaction</a>
          <a href="#" class="filter-option" onclick="applyFilter('Imperative programming')">Imperative programming</a>
          <a href="#" class="filter-option" onclick="applyFilter('Information systems')">Information systems</a>
          <a href="#" class="filter-option" onclick="applyFilter('Introduction to computer architecture')">Introduction to computer architecture</a>
        </div>
      </div>
    </div>

    <div class="pdf-card-section">
      <form class="search-form" method="GET">
        <input type="text" name="search" placeholder="Search by title, author, or major" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button class="voice-button" type="submit">Search</button>
        <button type="button" class="voice-button">
          <img src="../Images/voice.png" alt="Voice Search Icon" class="voice-icon">
          <span class="voice-text">Voice Search</span>
        </button>
      </form>
	  

<?php
	//session_start(); // Start the session

	// Retrieve the PDF files from the database
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

	$loggedUser = isset($_GET['loggedUser']) ? $_GET['loggedUser'] : '';


	// Retrieve the logged-in user's favorite item_ids from the "favorites" table
	$favoriteItems = array(); // Array to store favorite item_ids
	$favoritesSql = "SELECT item_id FROM favorites WHERE username = '$loggedUser'";
	$favoritesResult = $conn->query($favoritesSql);
	if ($favoritesResult->num_rows > 0) {
		while ($favoritesRow = $favoritesResult->fetch_assoc()) {
			$favoriteItems[] = $favoritesRow["item_id"];
		}
	}
    echo $loggedUser; 
	// Print the favorite item_ids
	if (!empty($favoriteItems)) {
		echo "Favorite Item IDs: ";
		foreach ($favoriteItems as $itemID) {
			echo $itemID . " ";
		}
	} else {
		echo "No favorite items found.";
	}


	// Use the $username variable as needed in your code

	// Prepare the SQL statement with search functionality
	$sql = "SELECT item_id, title, author, major, description, file, DATE_FORMAT(upload_date, '%Y-%m-%d') AS upload_date FROM materials WHERE item_id IN (" . implode(",", $favoriteItems) . ")";

	if (isset($_GET['search'])) {
		$search = $_GET['search'];
		$sql .= " AND (title LIKE '%$search%' OR author LIKE '%$search%' OR major LIKE '%$search%' OR description LIKE '%$search%')";
	}

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		// Output data of each row
		$count = 0; // Counter for arranging files in a row
		while ($row = $result->fetch_assoc()) {
			$item_id = $row["item_id"];
			$title = $row["title"];
			$author = $row["author"];
			$major = $row["major"];
			$description = $row["description"];
			$uploadDate = $row["upload_date"];
			$pdfData = $row["file"];
			// Generate a unique filename for each PDF file
			$filename = uniqid() . ".pdf";
			// Save the PDF data to a file
			file_put_contents($filename, $pdfData);
			// Limit the description to 170 characters
			$limitedDescription = strlen($description) > 170 ? substr($description, 0, 167) . "..." : $description;
			// Check if the current item_id is in the array of favorite items
			$isFavorite = in_array($item_id, $favoriteItems);
			// Display the PDF preview for the first page and add a favorite class if it's a favorite item
			if ($isFavorite) {
				echo '<div class="pdf-preview favorite">
						<embed src="' . $filename . '#page=1&toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" />
						<p><b>Title</b>: ' . $title . '</p>
						<p><b>Author</b>: ' . $author . '</p>
						<p><b>Major</b>: ' . $major . '</p>
						<p><b>Date added</b>: ' . $uploadDate . '</p>
						<p><b>Description</b>: ' . $limitedDescription . '</p>';


				echo '<div class="button-wrapper">
						<button class="view-button" onclick="window.location.href=\'viewpdf.php?filename=' . $filename . '\'">View</button>
						<button class="download-button" onclick="window.location.href=\'download_pdf.php?filename=' . $filename . '\'">Download</button>
						<button class="favorite-button" onclick="RemoveFromFavorites(' . $item_id . ', \'' . $loggedUser . '\')">Remove Favorite</button>
						<button class="share-button">Share</button>
						 </div>';
				

				echo '</div>';
				$count++;

				// Start a new row after displaying three files
				if ($count % 3 == 0) {
					echo '<div style="clear:both;"></div>';
				}
			}
		}
	} else {
		echo "No favorite PDF files found.";
	}

	$conn->close();
?>
		</div>
		</div>
		<script>
			function applyFilter(filter) {
				document.querySelector('.search-form input[name="search"]').value = filter;
				document.querySelector('.search-form').submit();
			}
			function RemoveFromFavorites(item_id, loggedUser) {
			  // Display a prompt to show the item_id and loggedUser
			  var promptMessage = "Remove item with ID: " + item_id + " from favorites for user: " + loggedUser + "?";
			  var confirmation = confirm(promptMessage);

			  if (confirmation) {
				// Send an AJAX request to the server to remove the item from favorites
				var xhr = new XMLHttpRequest();
				xhr.open("POST", "remove_from_favorites.php", true);
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.onreadystatechange = function() {
				  if (xhr.readyState === 4 && xhr.status === 200) {
					// Request succeeded, handle the response if needed
					console.log(xhr.responseText);
					// Reload the page after removing the item from favorites
					location.reload();
				  }
				};

				var params = "item_id=" + item_id + "&logged_user=" + loggedUser;
				xhr.send(params);
			  }
			}

		</script>
		<p>Logged User: <?php echo $loggedUser; ?></p>
</body>
</html>