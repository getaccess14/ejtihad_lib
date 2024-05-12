<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Connect to the database
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "ejtihad_lib";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Retrieve the form data
  $step = isset($_POST['step']) ? $_POST['step'] : '';

  if ($step === '1') {
    // Step 1: First Name and Last Name
    $firstName = $_POST['firstname'];
    $lastName = $_POST['lastname'];
	$gender = $_POST['gender'];
    // Store the values in session for the next step
    session_start();
    $_SESSION['step1'] = [
      'firstName' => $firstName,
      'lastName' => $lastName,
	  'gender' => $gender
    ];
  } elseif ($step === '2') {
    // Step 2: Email, Username, and Password
    // Retrieve the values from the session
    session_start();
    $firstName = $_SESSION['step1']['firstName'];
    $lastName = $_SESSION['step1']['lastName'];
	$gender = $_SESSION['step1']['gender'];
	
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username already exists
    $checkUsernameQuery = "SELECT * FROM users WHERE username = '$username'";
    $checkUsernameResult = $conn->query($checkUsernameQuery);

    // Check if the email already exists
    $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
    $checkEmailResult = $conn->query($checkEmailQuery);

    if ($checkUsernameResult->num_rows > 0) {
      // Username already exists, display error message
      $error_message = "Username already exists. Please choose a different username.";
    } elseif ($checkEmailResult->num_rows > 0) {
      // Email already exists, display error message
      $error_message = "Email already exists. Please choose a different email.";
    } else {
      // Insert the user into the database
      $sql = "INSERT INTO users (first_name, last_name, gender, email, username, password) VALUES ('$firstName', '$lastName', '$gender', '$email', '$username', '$password')";
      if ($conn->query($sql) === TRUE) {
        // Signup successful, redirect to index.php
        header("Location: login.php");
        exit();
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }

    // Clear the session values
    unset($_SESSION['step1']);
  }

  $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Library Signup</title>
  <link rel="stylesheet" type="text/css" href="../CSS/signup_login_form.css">
</head>
<body>
  <main>
  
	<h2>Sign Up</h2>
	<?php if (!isset($_SESSION['step1'])): ?>
	  <!-- Step 1: First Name, Last Name, and Gender -->
	  <form action="signup.php" method="POST">
		<input type="hidden" name="step" value="1">
		<div class="form-group">
		  <label for="firstname">First Name:</label>
		  <input type="text" name="firstname" required>
		</div>
		<div class="form-group">
		  <label for="lastname">Last Name:</label>
		  <input type="text" name="lastname" required>
		</div>
		<div class="form-group">
		  <label for="gender">Gender:</label>
		  <select class = "gender" name="gender" required>
			<option value="">Select Gender</option>
			<option value="male">Male</option>
			<option value="female">Female</option>
			<option value="other">Other</option>
		  </select>
		</div>
		<input type="submit" value="Next">
	  </form>
	<?php else: ?>
	  <!-- Step 2: Email, Username, and Password -->
	  <form action="signup.php" method="POST">
		<input type="hidden" name="step" value="2">
		<div class="form-group">
		  <label for="email">Email:</label>
		  <input type="email" name="email" required>
		</div>
		<div class="form-group">
		  <label for="username">Username:</label>
		  <input type="text" name="username" required>
		</div>
		<div class="form-group">
		  <label for="password">Password:</label>
		  <input type="password" name="password" required>
		</div>
		<input type="submit" value="Sign Up">
		<?php if (isset($error_message)): ?>
		  <p><?php echo $error_message; ?></p>
		<?php endif; ?>
	  </form>
	<?php endif; ?>
	<div class="login-button">
	  <a href="login.php">Already have an account? Log in</a>
	</div>
  </main>
</body>
</html>