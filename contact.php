<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../CSS/styles.css">
    <link rel="stylesheet" type="text/css" href="../CSS/status.css">
    <link rel="stylesheet" type="text/css" href="../CSS/status_drop.css">
    <link rel="stylesheet" type="text/css" href="../CSS/contact.css">

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
                        <a href="../index.php" class="list1">Home</a>
                    </li>
                    <li class="lists">
                        <a href="" class="list2">Materials</a>
                    </li>
                    <li class="lists">
                        <a href="" class="list3">About us</a>
                    </li>
                    <li class="lists">
                        <a href="" class="list4">Contact</a>
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
	  <h1 class="row1-title">Contact Us</h1>
	  <p class="row1-description">We are happy to receive your questions and feedback</p>
	</div>



	<div class="row row2">
	<div class="column left-column">
	  <h1> Mailing Details </h1>
	  <h2>EJTIHAD Platform</h2>
	  <p>Address: 123 Main Street, City, Country</p>
	  <p>Phone: +1 234 567 890</p>
	  <p>Email: example@example.com</p>
	</div>
	
	  <div class="column right-column">
		<form action="send_messsage.php" method="POST">
		  <label for="message-about">What is your message about?</label>
		  <select id="message-about" name="message_about">
			<option value="General">General</option>
			<option value="EJTIHAD resources">EJTIHAD resources</option>
			<option value="Uploading Files">Uploading Files</option>
			<option value="Viewing and downloading resources">Viewing and downloading resources</option>
			<option value="Registering and logging in">Registering and logging in</option>
			<option value="Other issues">Other issues</option>
		  </select>
		  
		  <label for="your-name">Your Name</label>
		  <input type="text" id="your-name" name="your_name" required>
		  
		  <label for="email-address">Email Address</label>
		  <input type="email" id="email-address" name="email_address" required>
		  
		  <label for="your-message">Your Message</label>
		  <textarea id="your-message" name="your_message" required></textarea>
		  
		  <input type="submit" value="Submit">
		</form>
	  </div>
		<?php
			if (isset($successMessage)) {
				echo "<p>$successMessage</p>";
			} elseif (isset($errorMessage)) {
				echo "<p>$errorMessage</p>";
			}
		?>
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
</body>

</html>