<!DOCTYPE html>
<html>
<head>
  <title>View Video Data</title>
  <link rel="stylesheet" type="text/css" href="../CSS/viewid.css">
  <link rel="stylesheet" type="text/css" href="../CSS/pop_up.css">
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
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
	.material-symbols-outlined {
	  font-variation-settings:
	  'FILL' 0,
	  'wght' 400,
	  'GRAD' 0,
	  'opsz' 24
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
	  margin: 0px 0px;
	  color: #0063D4;
	  padding: 3px 0px;
	}

	.voice-icon {
	  font-size: 20px;
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
            <form id="searchForm" method="GET"> <!-- Add action and method attributes to the form -->
              <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
              <input type="text" name="search" id="search-input" placeholder="Search...">
             <span class="voice-icon" onclick="startVoiceSearch()" ><i class="fa fa-microphone"  aria-hidden="true"></i></span>
			<button class="apply-button" id="applyButton" type = "submit" >Go</button>
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

    // Prepare and execute the SQL statement to fetch all video data
    $stmt = $conn->prepare("SELECT * FROM vid");
    $stmt->execute();
    $result = $stmt->get_result();

//kkkkkkkkkk
	$loggedUser = isset($_GET['loggedUser']) ? $_GET['loggedUser'] : '';
	//echo $loggedUser;
//ddddddddddddddddddddddd
	$sql = "SELECT * FROM vid";
	if (isset($_GET['search'])) {
	  $search = $_GET['search'];
	  $sql .= " WHERE title LIKE '%$search%' OR author LIKE '%$search%' OR major LIKE '%$search%' OR description LIKE '%$search%' OR item_id LIKE '%$search%'";
	}

	$result = $conn->query($sql);
//gggggggggggggggggggggggggggg

    // Check if any rows are returned
	if ($result->num_rows > 0) {
		// Display video data in cards
		while ($row = $result->fetch_assoc()) {
			$item_id = $row["item_id"];
			$title = $row["title"];
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
			if ($loggedUser) {
				echo '<div class="button-container">';
				echo '<button class="view-button" onclick="ViewMaterial(' . $item_id . ')">View</button>';
				echo '<div class="other-buttons">';
				echo '<span class="material-symbols-outlined"> visibility </span>';
				echo '<span class="material-symbols-outlined"> download </span>';
				echo '<span class="material-symbols-outlined"> thumb_up </span>';
				echo '<span class="material-symbols-outlined"> thumb_down </span>';
				echo '</div>'; // closing div for other-buttons
				echo '</div>'; // closing div for button-container
			}
			echo '</div>'; // closing div for video-card
		}
	} else {
		echo '<div class="no-materials">';
		echo '<p>No Materials Found</p>';
		echo '<img src="../Images/noresult.png" alt="No Results Image">';
		echo '</div>';
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

	function ViewMaterial(item_id) {
	  // Send an AJAX request to retrieve the PDF file URL and title
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

	function DownloadMaterial(item_id) {
	  // Send an AJAX request to retrieve the PDF file URL and title
	  var xhr = new XMLHttpRequest();
	  xhr.open("GET", "get_pdf_url.php?item_id=" + item_id, true);
	  
	  xhr.onreadystatechange = function() {
		if (xhr.readyState === 4 && xhr.status === 200) {
		  // Request succeeded, handle the response
		  var response = JSON.parse(xhr.responseText);
		  var pdfUrl = response.pdfUrl;
		  var title = response.title;
		  
		  // Initiate the download by creating a hidden link and simulating a click
		  var link = document.createElement("a");
		  link.href = pdfUrl;
		  link.download = title + ".pdf"; // Set the downloaded file name as the title
		  link.style.display = "none";
		  document.body.appendChild(link);
		  link.click();
		  document.body.removeChild(link);
		}
	  };
	  
	  xhr.send();
	}


	var itemId;
	var loggedUser;

	function showPopup(title, id, user) {
	  document.getElementById("popup").style.display = "block";
	  document.getElementById("fileTitle").innerText = title;
	  itemId = id;
	  loggedUser = user;
	}

	function closePopup() {
	  document.getElementById("popup").style.display = "none";
	}

	function addToFavorites() {
	  // Show a prompt with the item_id and loggedUser values
	  //var message = "Adding item with ID: " + itemId + "\nLogged User: " + loggedUser;
	  //alert(message);

	  // Send an AJAX request to add the item to favorites
	  var xhr = new XMLHttpRequest();
	  xhr.open("POST", "addfavorite.php", true);
	  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

	  xhr.onreadystatechange = function() {
		if (xhr.readyState === 4 && xhr.status === 200) {
		  // Request succeeded, do something (if needed)
		  console.log(xhr.responseText);
		}
	  };

	  var data = "item_id=" + itemId + "&loggedUser=" + loggedUser;
	  xhr.send(data);

	  closePopup();
	}
	

	  function applyFilter(filter) {
		document.querySelector('.search-form input[name="search"]').value = filter;
		document.querySelector('.search-form').submit();
	  }
	  
	  


	function startVoiceSearch() {
	  const recognition = new webkitSpeechRecognition() || new SpeechRecognition();
	  recognition.lang = 'en-US';

	  recognition.onresult = function(event) {
		const result = event.results[0][0].transcript;
		const searchInput = document.getElementById('search-input');
		searchInput.value = result;
		performSearch(event);
	  };

	  recognition.start();
	}
	
  </script>

<div id="popup" class="popup">
  <div class="popup-content">
    <span class="close" onclick="closePopup()">&times;</span>
    <p class = "pop-txt" >Add '<span id="fileTitle"></span>' to Your Favorites?</p>
    <button class = "add-button" onclick="addToFavorites()">Add</button>
    <button class = "cancel-button" onclick="closePopup()">Cancel</button>
  </div>
</div>

</body>
</html>
