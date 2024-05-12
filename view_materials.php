<!DOCTYPE html>
<html>
<head>
  <title>View Video Data</title>
  <link rel="stylesheet" type="text/css" href="../CSS/viewid.css">
  <style>
    /* Paste the updated CSS code here */
  </style>
</head>
<body>
<div class="flex-container">
  <div class="left-column">
      <div class="filter-category">
		<div class="search-container">
		  <form class="search-form" method="GET"> <!-- Replace "search.php" with the actual file name and path for your server-side processing -->
			<input type="text" name="search" placeholder="Search by title, author, or major" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">

			<img src="../Images/voice.png" alt="Voice Search" class="search-icon" />
			<button type="submit">Search</button>
		  </form>
		</div>
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
  </div>
  
  <div class="right-column">

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

  <script>
    function applyFilter(filter) {
      // Update the filter value in the search form
      document.querySelector('input[name="search"]').value = filter;

      // Submit the search form
      document.querySelector('form').submit();
    }

    function ViewMaterial() {
      // Add your logic for viewing the material here
      console.log("View button clicked");
    }

    function DownloadMaterial() {
      // Add your logic for downloading the material here
      console.log("Download button clicked");
    }

    function AddFavoriteMaterial() {
      // Add your logic for adding the material to favorites here
      console.log("Add to favorites button clicked");
    }
	  function applyFilter(filter) {
		document.querySelector('.search-form input[name="search"]').value = filter;
		document.querySelector('.search-form').submit();
	  }
  </script>
</div>
</body>
</html>
