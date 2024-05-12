<!DOCTYPE html>
<html>
<head>
  <title>Voice Search Example</title>
  <script>
    function performSearch(event) {
      event.preventDefault();
      const searchInput = document.getElementById('search-input');
      // Perform your web search API request here using the searchInput value
      console.log('Performing search:', searchInput.value);
    }

    function startVoiceSearch() {
      const recognition = new webkitSpeechRecognition() || new SpeechRecognition();
      recognition.lang = 'en-US';

      recognition.onresult = function(event) {
        const result = event.results[0][0].transcript;
        const searchInput = document.getElementById('search-input');
        searchInput.value = result;
        performSearch(event);
      };

      recognition.start();
    }
  </script>
</head>
<body>
  <div class="search-container">
    <form class="search-form" method="GET" onsubmit="performSearch(event)">
      <input type="text" id="search-input" name="search" placeholder="Search by title, author, or major" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">

      <img src="../Images/voice.png" alt="Voice Search" class="search-icon" onclick="startVoiceSearch()" />
      <button type="submit">Search</button>
    </form>
  </div>
</body>
</html>