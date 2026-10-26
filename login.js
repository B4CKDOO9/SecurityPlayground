const loginForm = document.getElementById('login-form');
const usernameInput = document.getElementById('username');
const passwordInput = document.getElementById('password');

loginForm.addEventListener('submit', async function(event) {
  event.preventDefault();
  const formData = new FormData();
  formData.append('action', 'login');
  formData.append('username', usernameInput.value);
  formData.append('password', passwordInput.value);
  const response = await fetch("script.php", {
  method: "POST",
  body: formData,
  });
  const result = (await response.text()).trim();
  if (result === "Logged in as Administrator") {
    window.location.href = "admin.php";
  }
  else if (result === "Login successful") {
    window.location.href = "dashboard.php";
  }
  else {
    alert("Login failed! Wrong username or password.");
  }
});