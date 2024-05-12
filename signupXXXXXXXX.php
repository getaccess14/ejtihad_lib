<?php
session_start(); // Start the session

// Check if the form is submitted (Step 1)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['step'])) {
  // Retrieve the form data
  $firstName = $_POST['firstname'];
  $lastName = $_POST['lastname'];
  $gender = $_POST['gender'];

  // Store the data in session variables
  $_SESSION['step1'] = array(
    'firstname' => $firstName,
    'lastname' => $lastName,
    'gender' => $gender
  );

  // Redirect to Step 2
  header("Location: signup.php?step=2");
  exit();
}

// Check if the form is submitted (Step 2)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['step']) && $_POST['step'] === '2') {
  // Connect to the database
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "ejtihad_lib";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Retrieve the data from session variables
  $firstName = $_SESSION['step1']['firstname'];
  $lastName = $_SESSION['step1']['lastname'];
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
    $sql = "INSERT INTO users (first_name, last_name, email, username, password, gender) VALUES ('$firstName', '$lastName', '$email', '$username', '$password', '$gender')";
    if ($conn->query($sql) === TRUE) {
      // Signup successful, redirect to index.php or display success message
      // Redirect to index.php
      header("Location: ../index.php");
      exit();
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }

  $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Library Signup</title>
  <link rel="stylesheet" type="text/css" href="../CSS/signup_style.css">
  <link rel="stylesheet" type="text/css" href="../CSS/form.css">
  <style>
    /* CSS for the popup modal */
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 400px; /* Set the width as per your requirement */
    }

    /* CSS for the "Next" button */
    .form-group .next-button {
      display: inline-block;
      background-color: #4CAF50;
      color: white;
      padding: 8px 16px;
      text-align: center;
      text-decoration: none;
      border-radius: 4px;
      cursor: pointer;
    }

    /* CSS for the gender field */
    .form-group select[name="gender"] {
      width: 100%;
      padding: 8px;
      border-radius: 4px;
      border: 1px solid #ccc;
      box-sizing: border-box;
      font-size: 16px;
    }
  </style>
</head>

<body onload="openModal()">
  <main>
    <!-- Popup Modal -->
    <div id="myModal" class="modal">
      <div class="modal-content">
        <?php if (!isset($_GET['step']) || $_GET['step'] === '1') { ?>
          <h2>Sign Up - Step 1</h2>
          <form method="POST" action="signup.php">
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
              <select name="gender" required>
                <option value="">Select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
            <input type="button" value="Next" class="next-button" onclick="nextStep(2)">
            <input type="hidden" name="step" value="1">
          </form>
        <?php } elseif ($_GET['step'] === '2') { ?>
          <h2>Sign Up - Step 2</h2>
          <form method="POST" action="signup.php">
            <?php if (isset($error_message)) { ?>
              <p class="error"><?php echo $error_message; ?></p>
            <?php } ?>
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
            <input type="submit" value="Submit" class="next-button">
            <input type="hidden" name="step" value="2">
          </form>
        <?php } ?>
      </div>
    </div>
    <!-- End of Popup Modal -->
  </main>

  <script>
    // JavaScript to open the popup modal
    function openModal() {
      var modal = document.getElementById("myModal");
      modal.style.display = "block";
    }

    // Close the modal when user clicks outside of it
    window.onclick = function(event) {
      var modal = document.getElementById("myModal");
      if (event.target == modal) {
        modal.style.display = "none";
      }
    };

    // JavaScript function to navigate to the next step
    function nextStep(step) {
      window.location.href = 'signup.php?step=' + step;
    }
  </script>
</body>
</html>