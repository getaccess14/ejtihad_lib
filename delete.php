<?php
// delete_account.php


// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to the login page if not logged in
    exit;
}

// Establish database connection
$host = 'localhost';
$dbname = 'ejtihad_lib';
$username = 'root';
$password = '';

try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set PDO error mode to exception
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user confirmed the account deletion
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
        // Delete the user account from the database
        $username = $_SESSION['username'];

        try {
            // Prepare and execute the DELETE statement
            $stmt = $dbh->prepare("DELETE FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            // Check if any rows were affected
            if ($stmt->rowCount() > 0) {
                // Account deleted successfully
                session_destroy(); // Destroy the session
                header("Location: ../index.php"); // Redirect to the account deleted page
                exit;
            } else {
                // No rows affected, display an error message or redirect
                header("Location: profile.php"); // Redirect to the profile page
                exit;
            }
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    } else {
        // User did not confirm the account deletion, redirect or display a message
        header("Location: profile.php"); // Redirect to the profile page
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Account</title>
		<link rel="stylesheet" type="text/css" href="../CSS/delete_account.css">
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete your account?");
        }
    </script>
</head>
<body>
    <div class="container-delete">
        <h2>Delete Account</h2>
        <p>Are you sure you want to delete your account?</p>
        <form method="post" action="" onsubmit="return confirmDelete();">
            <input type="hidden" name="confirm" value="yes">
            <button type="submit">Delete Account</button>
        </form>
    </div>
</body>
</html>