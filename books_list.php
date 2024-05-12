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
  <h1 class = "h1" >Materials and Resources</h1>

  <div class="grid-container">
    <div class="filter-section">
      <div class="filter-category">
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

		// Prepare and execute the SQL statement to fetch all video data
		$stmt = $conn->prepare("SELECT * FROM vid");
		$stmt->execute();
		$result = $stmt->get_result();
		
	//ddddddddddddddddddddddd
		$sql = "SELECT * FROM vid";
		if (isset($_GET['search'])) {
		  $search = $_GET['search'];
		  $sql .= " WHERE title LIKE '%$search%' OR author LIKE '%$search%' OR major LIKE '%$search%' OR description LIKE '%$search%'";
		}

		$result = $conn->query($sql);
	//gggggggggggggggggggggggggggg

		// Check if any rows are returned
		if ($result->num_rows > 0) {
		  // Display video data in cards
		  while ($row = $result->fetch_assoc()) {
			echo '<div class="video-card">';
			echo '<img src="' . $row['img'] . '" alt="Video Image" width="200">';
			echo "<p><strong>Title: " . $row['title'] . "</strong></p>";
			echo "<p><strong>Author:</strong> " . $row['author'] . "</p>";
			echo "<p><strong>Major:</strong> " . $row['major'] . "</p>";
			echo "<p><strong>Date Added:</strong> " . $row['upload_date'] . "</p>";
			echo "<p><strong>Description:</strong> " . substr($row['description'], 0, 100);
			if (strlen($row['description']) > 100) {
				echo "...";
			}
			echo "</p>";
			echo '<div class="button-container">';
			echo '<button class="view-button" onclick="ViewMaterial()">View</button>';
			echo '<div class="other-buttons">';
			echo '<button class="download-button" onclick="DownloadMaterial()"> Download</button>';
			echo '<button class="favorites-button" onclick="AddFavoriteMaterial()"> Add Favorite</button>';
			echo '<button class="share-button" onclick="ShareMaterial()"> Share</button>';
			echo '</div>'; // closing div for other-buttons
			echo '</div>'; // closing div for button-container
			echo '</div>'; // closing div for video-card
		  }
		}
		else {
		  echo "<p>No videos found.</p>";
		}

		// Close the database connection
		$stmt->close();
		$conn->close();
		?>
		
		
		</div>
		</div>
		<script>
			function applyFilter(filter) {
				document.querySelector('.search-form input[name="search"]').value = filter;
				document.querySelector('.search-form').submit();
			}
			function addToFavorites(item_id, loggedUser) {
			  // Display a prompt to show the item_id and loggedUser
			  var promptMessage = "Add item with ID: " + item_id + " to favorites for user: " + loggedUser + "?";
			  var confirmation = confirm(promptMessage);
			  
			  if (confirmation) {
				// Send an AJAX request to the server to add the item to favorites
				var xhr = new XMLHttpRequest();
				xhr.open("POST", "add_to_favorites.php", true);
				xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				xhr.onreadystatechange = function() {
				  if (xhr.readyState === 4 && xhr.status === 200) {
					// Request succeeded, handle the response if needed
					console.log(xhr.responseText);
				  }
				};

				var params = "item_id=" + item_id + "&logged_user=" + loggedUser;
				xhr.send(params);
			  }
			}

		</script>
</body>
</html>