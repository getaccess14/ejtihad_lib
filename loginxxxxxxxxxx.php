<?php
session_start();

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
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Validate the login data
  $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
  $result = $conn->query($sql);

  if ($result->num_rows == 1) {
    // Login successful
    $_SESSION['username'] = $username;
    header("Location: ../index.php");
    exit();
  } else {
    // Incorrect username or password
    $error_message = "Incorrect username or password";
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <title> Login</title>
  <link rel="stylesheet" type="text/css" href="../CSS/login_style.css">
</head>
<body>

  <main>
    <h2>Login</h2>
    <form action="login.php" method="POST">
      <label for="username">Username:</label>
      <input type="text" name="username" required>
      <label for="password">Password:</label>
      <input type="password" name="password" required>
      <input type="submit" value="Login">
    </form>
    <div class="signup-button">
      <a href="signup.php">Don't have an account yet? Sign Up</a>
    </div>
    <?php if (isset($error_message)): ?>
      <p><?php echo $error_message; ?></p>
    <?php endif; ?>
  </main>

</body>
</html>