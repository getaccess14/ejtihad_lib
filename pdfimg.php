<!DOCTYPE html>
<html>
<head>
  <title>PDF to Square Image</title>
</head>
<body>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
  <script>
    // Replace 'pdfFilePath' with the actual file path passed from 'upload.php'
    var urlParams = new URLSearchParams(window.location.search);
    var pdfFilePath = urlParams.get('file');

    function convertToImage() {
      var xhr = new XMLHttpRequest();
      xhr.open('GET', pdfFilePath, true);
      xhr.responseType = 'arraybuffer';

      xhr.onload = function(e) {
        if (xhr.status === 200) {
          var typedArray = new Uint8Array(xhr.response);
          var pdfjsLib = window['pdfjs-dist/build/pdf'];
          pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.worker.min.js';

          pdfjsLib.getDocument(typedArray).promise.then(function(pdf) {
            return pdf.getPage(1);
          }).then(function(page) {
            var viewport = page.getViewport({ scale: 1 });
            var canvas = document.createElement('canvas');
            var context = canvas.getContext('2d');
            var squareSize = Math.min(viewport.width, viewport.height);
            canvas.width = squareSize;
            canvas.height = squareSize;

            var renderContext = {
              canvasContext: context,
              viewport: viewport
            };

            page.render(renderContext).promise.then(function() {
              canvas.toBlob(function(blob) {
                var fileName = pdfFilePath.split('/').pop().replace('.pdf', '') + '.png'; // Use PDF file name as the image name

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
            });
          });
        } else {
          console.error('Error loading PDF file.');
        }
      };

      xhr.send();
    }

    convertToImage();
  </script>
</body>
</html>