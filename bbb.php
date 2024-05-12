<!DOCTYPE html>
<html>
<head>
  <title>View Video Data</title>
  <link rel="stylesheet" type="text/css" href="../CSS/viewid.css">
  <link rel="stylesheet" type="text/css" href="../CSS/pop_up.css">
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>

	.apply-button {
	  border: none;
	  background-color: #4caf50;
	  color: #fff;
	  padding: 10px 15px;
	  font-size: 14px;
	  margin-left: 1px;
	  margin-right: 0px;
	  cursor: pointer;
	  border-radius: 30px;
	}

	.search_box {
	  border-radius: 30px;
	  background-color: white;
	  border: 1px solid black;
	}

	.form-container {
	  display: flex;

	  align-items: center;
	  margin-bottom: 20px;
	  margin-top: 20px;
	}

	form {
	  margin: 0;
	}

	input {
	  border: none;
	  margin: 2px 2px 2px 2px;
	  font-size: 14px;
	  outline: none;
	  color: #17202A;

	}

	.search_box button i {
	  font-size: 16px;
	  margin: 0px 5px;
	  color: #0063D4;
	}

	button {
	  background: transparent;
	  border: none;
	  outline: none;
	}

  </style>
</head>
<body>
<script src="../JS/viewjs.js"></script>
  <div class="left-column">
      <div class="filter-category">
        <div class="form-container">
          <div class="search_box">
            <form id="searchForm" action="search.php" method="POST"> <!-- Add action and method attributes to the form -->
              <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
              <input type="text" name="search_term" id="searchInput" placeholder="Search...">
              <button type="submit" id="micButton"><i class="fa fa-microphone" onclick="startVoiceSearch() aria-hidden="true"></i></button>
			<button class="apply-button" id="applyButton" onclick="window.location.href='PHP/viewid.php';">Go</button>
            </form>
          </div>
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

// Retrieve the passed item_id
$item_id = isset($_GET['item_id']) ? $_GET['item_id'] : '';

if (!empty($item_id)) {
    // Prepare SQL statement to fetch video data by item_id
    $sql = "SELECT * FROM vid WHERE item_id = '$item_id'";

    // Execute the SQL statement
    $result = $conn->query($sql);

    // Check if any rows are returned
    if ($result->num_rows > 0) {
        // Display video data
        $row = $result->fetch_assoc();
        echo '<div class="video-details">';
        echo '<img src="' . $row['img'] . '" alt="Video Image" width="200">';
        echo "<p><strong>Title: " . $row['title'] . "</strong></p>";
        echo "<p><strong>Author:</strong> " . $row['author'] . "</p>";
        echo "<p><strong>Major:</strong> " . $row['major'] . "</p>";
        echo "<p><strong>Date Added:</strong> " . $row['upload_date'] . "</p>";
        echo "<p><strong>Description:</strong> " . $row['description'] . "</p>";
        if ($loggedUser) {
            echo '<div class="button-container">';
            echo '<button class="download-button" onclick="DownloadMaterial(' . $item_id . ')">Download</button>';
            echo '<button class="favorites-button" onclick="showPopup(\'' . $row['title'] . '\', \'' . $item_id . '\', \'' . $loggedUser . '\')">Add Favorite</button>';
            echo '<button class="share-button" onclick="ShareMaterial()">Share</button>';
            echo '</div>'; // closing div for button-container
        }
        echo '</div>'; // closing div for video-details
    } else {
        // No results found for item_id
        echo '<div class="no-materials">';
        echo '<p>No Material Found</p>';
        echo '<img src="../Images/noresult.png" alt="No Result Image">';
        echo '</div>';
    }
} else {
    // Retrieve the passed search term
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    if (!empty($search)) {
        // Prepare SQL statement to fetch video data by search term
        $sql = "SELECT * FROM vid WHERE title LIKE '%$search%' OR author LIKE '%$search%' OR major LIKE '%$search%' OR description LIKE '%$search%' OR item_id LIKE '%$search%'";

        // Execute the SQL statement
        $result = $conn->query($sql);

        // Check if any rows are returned
        if ($result->num_rows > 0) {
            // Display video data in cards
            while ($row = $result->fetch_assoc()) {
                $item_id = $row["item_id"];
                $title = $row["title"];
                echo '<div class="video-card">';
                echo '<img src="' . $row['img'] . '" alt="Video Image" width="200">';
                echo "<p><strong>Title: " . $row['title'] . "</strong></p>";
                echo "<p><strong>Author:</strong> " . $row['author']. "</p>";
                echo "<p><strong>Major:</strong> " . $row['major'] . "</p>";
                echo "<p><strong>Date Added:</strong> " . $row['upload_date'] . "</p>";
                echo "<p><strong>Description:</strong> " . $row['description'] . "</p>";
                if ($loggedUser) {
                    echo '<div class="button-container">';
                    echo '<button class="download-button" onclick="DownloadMaterial(' . $item_id . ')">Download</button>';
                    echo '<button class="favorites-button" onclick="showPopup(\'' . $row['title'] . '\', \'' . $item_id . '\', \'' . $loggedUser . '\')">Add Favorite</button>';
                    echo '<button class="share-button" onclick="ShareMaterial()">Share</button>';
                    echo '</div>'; // closing div for button-container
                }
                echo '</div>'; // closing div for video-card
            }
        } else {
            // No results found for the search term
            echo '<div class="no-materials">';
			echo '<p>No Material Found</p>';
			echo '<img src="../Images/noresult.png" alt="No Result Image">';
			echo '</div>';
		}
	}
}
	$conn->close();
	?>