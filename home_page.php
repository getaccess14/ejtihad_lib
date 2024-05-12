<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../CSS/styles.css">
    <link rel="stylesheet" type="text/css" href="../CSS/status.css">
    <link rel="stylesheet" type="text/css" href="../CSS/status_drop.css">
    <link rel="stylesheet" type="text/css" href="../CSS/home_page.css">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../CSS/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <style>
		body {
			background-color: #F5F5F5;
		}
        iframe {
            width: 100%;
            height: 100vh;
            border: none;
        }
    </style>
    <title>EIJTIHAD PLATFORM</title>
</head>

<body>
    <header class="header">
        <div class="container">
            <div class="area_logo_header">
                <a class="logo" href="home_page.php">
                    <img src="../Images/logo1.png" alt="Logo">
                </a>
            </div>

            <nav class="area_nav_header">
                <ul class="list_nav_header">
                    <li class="lists">
                        <a href="home_page.php" class="list1">Home</a>
                    </li>
                    <li class="lists">
                        <a href="materials_page.php" class="list2">Materials</a>
                    </li>
                    <li class="lists">
                        <a href="aboutus.php" class="list3">About us</a>
                    </li>
                    <li class="lists">
                        <a href="contact.php" class="list4">Contact</a>
                    </li>
                </ul>
            </nav>

<!-- ... -->
			<!-- ... -->
			<!-- ... -->
			<div class="status">
				<?php
				session_start();

				// Check if the user is logged in
				if (isset($_SESSION['username'])) {
				  // User is logged in, perform desired actions
				  $username = $_SESSION['username'];
				  echo "<div class='user-box' onclick='toggleDropdown()'>
					  <span class='username'>" . $username . "</span>
					  <img src='../Images/user.png' alt='User Icon' class='user-thumbnail'>
					  <div class='popup' id='dropdown'>
						<ul class='dropdown-content'>
						  <li>
							<a href='profile_info.php'>Profile information</a>
						  </li>
						  <li>
							<a href='my_uploads.php'>My Items</a>
						  </li>
						  <li>
							<a href='my_favorites.php'>Favorite Items</a>
						  </li>
						  <li>
							<a href='delete_account.php'>Delete Account</a>
						  </li>
						  <li>
							<a href='logout.php'>Logout</a>
						  </li>
						</ul>
					  </div>
					</div>";
				// Pass the username to JavaScript
				echo "<script>const loggedUser = '" . $username . "';</script>";
				} else {
				  // User is not logged in
				  echo '<p><a href="login.php" class="signin-link">Sign in</a></p>';
				}

				$isLogged = isset($_SESSION['username']);			
				echo $isLogged;
				?>
			</div>
			<!-- ... -->

			<script>
			document.addEventListener("DOMContentLoaded", function() {
			  const userBox = document.querySelector(".user-box");
			  const dropdown = document.getElementById("dropdown");

			  userBox.addEventListener("click", function(event) {
				event.stopPropagation();
				dropdown.classList.toggle("active");
			  });

			  document.addEventListener("click", function() {
				dropdown.classList.remove("active");
			  });
			});
			</script>
<!-- ... -->
        </div>
    </header>
	

    <div class="row row1">
        <div class="row1-content">
            <h1 class="row1-heading">Share, Learn and Excel</h1>
            <p class="row1-subheading">Ejtihad is a digital library of open educational resources for the majors of Computer Science department in Al Imam Mohammad Ibn Saud Islamic University.</p>

            <div class="form-container">
                <div class="container">
                    <div class="search_box">
                        <form id="searchForm" action="search.php" method="POST">
                            <!-- Add action and method attributes to the form -->
                            <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                            <input type="text" name="search_term" id="searchInput" placeholder="Search...">
                            <button onclick="startVoiceSearch(); return false;" id="micButton"><i class="fa fa-microphone" aria-hidden="true"></i></button>
                        </form>
                    </div>
                </div>

                <button class="apply-button" id="applyButton" onclick="performSearch(<?php echo $isLogged ? '1' : '0'; ?>);">Find</button>
            </div>
        </div>
    </div>


	<div class="row row6" style="background-color: #002469;">
		<?php if ($isLogged) { ?>
			<div class="image-container">
				<img src="../Images/h3.png" alt="Ejtihad Image" class="eijtihad-image">
				<div class="image-content">
					<h2 class="image-subtitle">What is EJTIHAD Platform?</h2>
					<p class="image-text">Ejtihad is a versatile online platform that aims to foster a dynamic community of learners and provide a platform for sharing resources related to the majors of the Computer Science department in Al Imam Mohammad Ibn Saud Islamic University. Whether you're a student, professional, or simply passionate about learning, Ejtihad offers a space to connect, collaborate, and expand your knowledge horizons.</p>
					<div class="button-containerd">
						<a href="signup.php" class="view-res-button">Contact Us</a>
						<a href="login.php" class="view-res-button">About Us</a>
					</div>
				</div>
			</div>
		<?php } else { ?>
			<div class="join-us-container">
				<h1 class="join-us-title">Join Us</h1>
				<p class="join-us-subtitle">Join the Ejtihad platform and be part of our community where<br> you can learn and share resources related to your studies.</p>
				<div class="button-container">
					<a href="signup.php" class="join-us-button">Sign up</a>
					<a href="login.php" class="join-us-button">Log in</a>
				</div>
			</div>
		<?php } ?>
	</div>






	<div class="row row2" style="background-color: #3A853A;">
		<div class="image-container">
			<div class="image-wrapper">
				<img src="../Images/upload1.png" alt="Image 1" class="horizontal-image">
				<div class="image-caption">Share</div>
			</div>
			<div class="image-wrapper">
				<img src="../Images/learn.jpg" alt="Image 2" class="horizontal-image">
				<div class="image-caption">Learn</div>
			</div>
			<div class="image-wrapper">
				<img src="../Images/excel.png" alt="Image 3" class="horizontal-image">
				<div class="image-caption">Excel</div>
			</div>
		</div>
	</div>

	<div class="row row3">
		<div class="content">
			<div class="text">
				<p>Explore and Find Textbooks and Video Resources For Your Studies</p>
				<a href="Materials_page.php" class="button">Explore Resources</a>
			</div>
			<img src="../Images/h2.png" class="aligned-image">
		</div>
	</div>

	<div class="row row4">
		<div class="section-header">
			<h2 class="section-title">New Resources</h2>
			<a class="explore-link" href="materials_page.php">Explore more</a>
		</div>
		<div class="card-container">
			<?php
			// Assuming you have a PHP script to fetch the data from the database
			$dbHost = 'localhost';
			$dbName = 'ejtihad_lib';
			$dbUser = 'root';
			$dbPass = '';

			// Create a PDO instance
			$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);

			// Fetch the latest five items from the vid table
			$stmt = $pdo->query("SELECT * FROM vid ORDER BY upload_date DESC LIMIT 5");
			$videos = $stmt->fetchAll(PDO::FETCH_ASSOC);

			// Loop through the videos and generate the card boxes dynamically
			foreach ($videos as $video) {
				$thumbnail = $video['img'];
				$title = $video['title'];
				$author = $video['author'];
				$description = $video['description'];

				echo '<div class="card">';
				echo '<img src="' . $thumbnail . '" alt="Thumbnail">';
				echo '<h2>' . $title . '</h2>';
				echo '<p>' . $author . '</p>';
				echo '<p>' . $description . '</p>';
				echo '</div>';
			}
			?>
		</div>
	</div>

    <!-- The modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Search Results</h2>
            <div id="searchResults"></div>
			<p style="text-align: center;"> For More Resources, Visit The Resources Page</p>
			<button class="go-to-resources-button">Go to Resources Page</button>
        </div>
    </div>


    <footer class="footer">
        <div class="social">
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="https://github.com/suzusou"><i class="fab fa-github"></i></a>
            <a href="#"><i class="fab fa-facebook"></i></a>
        </div>

        <ul class="list">
            <li>
                <a href="home_page.php">Home </a>
            </li>
            <li>
                <a href="materials_page.php">Materias </a>
            </li>
            <li>
                <a href="aboutus.php">About us </a>
            </li>
            <li>
                <a href="contact.php">Contact </a>
            </li>
            <p class="copyright">
                ejtihad_platform @ 2024
            </p>
        </ul>
    </footer>
    <script src="PHP/state.js"></script>
	<script src="home.js"></script>
	<script src="../JS/upload.js"></script>
	<script>

function startVoiceSearch() {
  // Check browser support for the Web Speech API
  if ('SpeechRecognition' in window || 'webkitSpeechRecognition' in window) {
    // Create a new instance of the SpeechRecognition object
    const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();

    // Set the desired language for speech recognition
    recognition.lang = 'en-US';

    // Start speech recognition
    recognition.start();

    // Event handler for when speech recognition results are available
    recognition.onresult = function(event) {
      const transcript = event.results[0][0].transcript;
      document.getElementById('recognizedText').textContent = transcript;
      console.log('Recognized Speech:', transcript);
    };

    // Event handler for errors in speech recognition
    recognition.onerror = function(event) {
      console.error('Speech Recognition Error:', event.error);
    };
  } else {
    console.error('Web Speech API is not supported in this browser.');
  }
}
</script>
</body>

</html>