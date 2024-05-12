		function toggleDropdown() {
		  var dropdown = document.getElementById("dropdown");
		  if (dropdown.style.display === "block") {
			dropdown.style.display = "none";
		  } else {
			dropdown.style.display = "block";
		  }
		}

		function performSearch(isLogged) {
			var searchTerm = document.getElementById('searchInput').value;

			// Construct the URL with query parameters
			var url = 'search.php?search=' + encodeURIComponent(searchTerm) + '&isLogged=' + isLogged;

			// Fetch the search results asynchronously
			fetch(url)
				.then(response => response.text())
				.then(data => {
					// Update the content of the modal with the search results
					document.getElementById('searchResults').innerHTML = data;

					// Open the modal
					document.getElementById('myModal').style.display = 'block';
				})
				.catch(error => {
					console.error('Error:', error);
				});
		}


        // Close the modal
        function closeModal() {
            document.getElementById('myModal').style.display = 'none';
        }

        function startVoiceSearch() {
            const recognition = new webkitSpeechRecognition() || new SpeechRecognition();
            recognition.lang = 'en-US';

            recognition.onresult = function (event) {
                const result = event.results[0][0].transcript;
                const searchInput = document.getElementById('searchInput');
                searchInput.value = result;
                performSearch();
            };

            recognition.start();
        }

		// Get the button element
		var goToResourcesButton = document.querySelector('.go-to-resources-button');

		// Add click event listener to the button
		goToResourcesButton.addEventListener('click', function() {
			// Redirect to the resources page
			window.location.href = 'materials_page.php';
		});
		
		
	function ViewMaterial(item_id) {
		// Send an AJAX request to retrieve the PDF file URL and title
		console.log("Item ID:", item_id);
		prompt("View Material", message);
		var xhr = new XMLHttpRequest();
		xhr.open("GET", "get_pdf_url.php?item_id=" + item_id, true);
		
		xhr.onreadystatechange = function() {
			if (xhr.readyState === 4 && xhr.status === 200) {
				// Request succeeded, handle the response
				var response = JSON.parse(xhr.responseText);
				var pdfUrl = response.pdfUrl;
				var title = response.title;
				
				// Open the PDF file in a new tab
				window.open(pdfUrl, "_blank");
			}
		};
		
		xhr.send();
	}
