<?php
// Get the signed-in username
$loggedUser = isset($_GET['loggedUser']) ? $_GET['loggedUser'] : '';

// Database connection parameters
$host = 'localhost';
$dbname = 'ejtihad_lib';
$user = 'root';
$password = '';

// Mapping of database field names to labels
$fieldLabels = array(
    'first_name' => 'First Name',
    'email' => 'Email',
    'age' => 'Age',
    'location' => 'Location'
    // Add more field labels as needed
);

// Variable to store any update status message
$updateStatus = '';

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle form submission

        // Prepare the UPDATE query
        $updateQuery = "UPDATE users SET ";

        // Prepare the parameters array
        $parameters = array();

        foreach ($_POST as $field => $value) {
            // Exclude the submit button from the update query
            if ($field !== 'submit') {
                $updateQuery .= "$field = :$field, ";
                $parameters[":$field"] = $value;
            }
        }

        // Remove the trailing comma and space from the update query
        $updateQuery = rtrim($updateQuery, ', ');

        // Add the WHERE clause for the specific user
        $updateQuery .= " WHERE username = :loggedUser";
        $parameters[':loggedUser'] = $loggedUser; // Fix the parameter name

        // Prepare and execute the update query
        $updateStatement = $pdo->prepare($updateQuery);
        $updateStatement->execute($parameters);

        // Check if the update was successful
        if ($updateStatement->rowCount() > 0) {
            $updateStatus = "Profile updated successfully.";
        } else {
            $updateStatus = "No changes were made.";
        }
    }

    // Prepare the SELECT query
    $selectQuery = "SELECT * FROM users WHERE username = :loggedUser";

    // Prepare the statement
    $statement = $pdo->prepare($selectQuery);

    // Bind the username parameter
    $statement->bindParam(':loggedUser', $loggedUser); // Fix the parameter name

    // Execute the query
    $statement->execute();

    // Fetch the user profile data
    $userProfileData = $statement->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle database connection errors
    echo "Database connection failed: " . $e->getMessage();
    exit();
}

// Close the database connection
$pdo = null;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profile Information</title>
    <link rel="stylesheet" href="../CSS/prof_info.css">
</head>
<body>
    <div class="container-info">
        <h2>Profile Information</h2>
        <?php if (!empty($updateStatus)) : ?>
            <p class="update-status"><?php echo $updateStatus; ?></p>
        <?php endif; ?>
        <form method="post" action="">
            <div class="profile-info">
                <?php
                if (is_array($userProfileData)) {
                    foreach ($userProfileData as $field => $value) {
                        if ($field !== 'id') {
                            $label = isset($fieldLabels[$field]) ? $fieldLabels[$field] : ucfirst(str_replace('_', ' ', $field));
                            ?>
                            <p>
                                <label><?php echo $label; ?>:</label>
                                <input type="text" name="<?php echo $field; ?>" value="<?php echo $value; ?>">
                            </p>
                            <?php
                        }
                    }
                } else {
                    echo "User profile data not found.";
                }
                ?>
            </div>
            <div class="form-button">
                <input type="submit" name="submit" value="Save">
            </div>
        </form>
    </div>

</body>
</html>