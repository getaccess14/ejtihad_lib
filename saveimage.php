<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
  $targetDirectory = __DIR__ . '/thumbnails/';
  $targetFile = $targetDirectory . basename($_FILES['file']['name']);

  // Create the thumbnails directory if it doesn't exist
  if (!is_dir($targetDirectory)) {
    mkdir($targetDirectory, 0755, true);
  }

  if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
    // Image saved successfully
    $imageName = basename($_FILES['file']['name']);
    $imageUrl = 'thumbnails/' . $imageName;

    // Pass the image name and URL to x.php using a GET request
    $redirectUrl = 'store_thumb.php?image=' . urlencode($imageName) . '&url=' . urlencode($imageUrl);
    header('Location: ' . $redirectUrl);
    exit();
  } else {
    // Error saving image
    echo 'Error saving image';
  }
} else {
  // Invalid request
  echo 'Invalid request';
}
?>