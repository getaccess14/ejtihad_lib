<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../CSS/styles.css">
    <link rel="stylesheet" type="text/css" href="../CSS/status.css">
    <link rel="stylesheet" type="text/css" href="../CSS/status_drop.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
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

				// Pass the username to JavaScript
				//echo "<script>const loggedUser = '" . $username . "';</script>";
								
				
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
    <main class="main">
		<?php
		// file2.php
		include 'delete.php';

		// Code in file1.php will be executed here.
		?>
    </main>

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
	<script>
		function toggleDropdown() {
		  var dropdown = document.getElementById("dropdown");
		  if (dropdown.style.display === "block") {
			dropdown.style.display = "none";
		  } else {
			dropdown.style.display = "block";
		  }
		}
	</script>
</body>

</html>