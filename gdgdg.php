<!DOCTYPE html>
<html>
<head>
<style>
.modal {
  display: none;
  position: fixed;
  z-index: 9999;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
  background-color: #fff;
  width: 400px;
  max-width: 90%;
  margin: 100px auto;
  padding: 20px;
  border-radius: 4px;
  text-align: center;
}

.modal-message {
  font-size: 18px;
  margin-bottom: 20px;
}

.popup-button-container {
  display: flex;
  justify-content: center;
}

.popup-login-button, .popup-signup-button {
  padding: 10px 20px;
  margin: 0 10px;
  border: none;
  border-radius: 4px;
  background-color: #007bff;
  color: #fff;
  cursor: pointer;
}

.loginPopup-close {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 20px;
  cursor: pointer;
}
</style>
</head>
<body>

<button class="view-button" onclick="showLoginPopup()">View</button>

<div id="loginPopup" class="modal">
  <div class="modal-content">
    <span class="loginPopup-close" onclick="closeLoginPopup()">&times;</span>
    <p class="modal-message">You must login to do this.</p>
    <div class="popup-button-container">
      <button class="popup-login-button" onclick="handleLoginRequest()">Login</button>
      <button class="popup-signup-button" onclick="handleSignupRequest()">Signup</button>
    </div>
  </div>
</div>

<script>
function showLoginPopup() {
  var loginPopup = document.getElementById("loginPopup");
  loginPopup.style.display = "block";
}

function closeLoginPopup() {
  var loginPopup = document.getElementById("loginPopup");
  loginPopup.style.display = "none";
}

function handleLoginRequest() {
  // Handle login logic here
  alert("Login clicked");
}

function handleSignupRequest() {
  // Handle signup logic here
  alert("Signup clicked");
}
</script>

</body>
</html>