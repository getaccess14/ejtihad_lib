<!DOCTYPE html>
<html>
<head>
    <title>Four Rows Page</title>
    <link rel="stylesheet" type="text/css" href="../CSS/sss.css">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="modal.css">
	<style>

	</style>
</head>
<body>
    <div class="row row1">
        <div class="row1-content">
            <h1 class="row1-heading">Share, Learn and Excel</h1>
            <p class="row1-subheading">Ejtihad is a digital library of open educational resources for the majors of Computer Science department in Al Imam Mohammad Ibn Saud Islamic University.</p>

            <div class="form-container">
                <div class="container">
                    <div class="search_box">
                        <form id="searchForm" action="search.php" method="POST">
                            <!-- Add action and method attributes to the form -->
                            <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                            <input type="text" name="search_term" id="searchInput" placeholder="Search...">
                            <button onclick="startVoiceSearch(); return false;" id="micButton"><i class="fa fa-microphone" aria-hidden="true"></i></button>
                        </form>
                    </div>
                </div>

                <button class="apply-button" id="applyButton" onclick="performSearch();">Find</button>
            </div>
        </div>
    </div>

    <div class="row row2">
    </div>

    <div class="row row3">
        <h1>Third Section</h1>
    </div>

    <div class="row row4">
        <h1>Fourth Section</h1>
    </div>

    <!-- The modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Search Results</h2>
            <div id="searchResults"></div>
			<button class="go-to-resources-button">Go to Resources Page</button>
        </div>
    </div>

    <!-- Include the JavaScript code -->
    <script>
        function performSearch() {
            var searchTerm = document.getElementById('searchInput').value;

            // Construct the URL with query parameters
            var url = 'search.php?search=' + encodeURIComponent(searchTerm);

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
			window.location.href = 'PHP/materials_page.php';
		});


    </script>
</body>
</html>