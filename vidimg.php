<!DOCTYPE html>
<html>
<head>
  <title>Video to Square Image</title>
</head>
<body>
  <script>
    // Replace 'videoFilePath' with the actual file path passed from 'upload.php'
    var urlParams = new URLSearchParams(window.location.search);
    var videoFilePath = urlParams.get('file');

    function convertToImage() {
      var video = document.createElement('video');
      video.preload = 'metadata';

      video.onloadedmetadata = function() {
        video.currentTime = 2; // Set the time to 2 seconds
      };

      video.onseeked = function() {
        var canvas = document.createElement('canvas');
        var context = canvas.getContext('2d');
        var videoWidth = video.videoWidth;
        var videoHeight = video.videoHeight;
        var squareSize = Math.min(videoWidth, videoHeight);
        canvas.width = squareSize;
        canvas.height = squareSize;
        context.drawImage(video, 0, 0, squareSize, squareSize);

        canvas.toBlob(function(blob) {
          var fileName = videoFilePath.split('/').pop().replace('.mp4', '') + '.png'; // Use video file name as the image name

          var formData = new FormData();
          formData.append('file', blob, fileName);

          var saveImageRequest = new XMLHttpRequest();
          saveImageRequest.open('POST', 'saveimage.php', true);
          saveImageRequest.onreadystatechange = function() {
            if (saveImageRequest.readyState === XMLHttpRequest.DONE && saveImageRequest.status === 200) {
              console.log('Image saved successfully');
              window.location.href = 'success.php'; // Redirect to success.php
            }
          };
          saveImageRequest.send(formData);
        }, 'image/png');

        video.remove(); // Clean up: remove the video element
      };

      video.src = videoFilePath;
      document.body.appendChild(video); // Append the video element to trigger the metadata loading
    }

    convertToImage();
  </script>
</body>
</html>