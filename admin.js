const searchBar = document.getElementById('search');
const filterRoles = document.getElementById('role');
const filterDepartments = document.getElementById('department');
const deleteForm = document.getElementById('remove-form-id');
const createFrom = document.getElementById('add-user-form');
const tableBody = document.getElementById('user-table');
const signOut = document.getElementById('signout');

signOut.addEventListener('click', async function(event){
  event.preventDefault();
  await signOutButton();
});
searchBar.addEventListener('input', async function() {
  await searchRun();
});
filterRoles.addEventListener('change', async function() {
  await searchRun();
});
filterDepartments.addEventListener('change', async function() {
  await searchRun();
});
deleteForm.addEventListener('submit', async function(event) {
  event.preventDefault();
  await deleteUser();
});
createFrom.addEventListener('submit', async function(event) {
  event.preventDefault();
  await createUser();
});

async function searchRun() {
  const formData = new FormData();
  formData.append('action', 'search');
  formData.append('search', searchBar.value);
  formData.append('role', filterRoles.value);
  formData.append('department', filterDepartments.value);
  const response = await fetch("script.php", {
    method: "POST",
    body: formData
  });
  const result = await response.json();
  tableBody.innerHTML = '';
  if (result.length === 0) {
    tableBody.innerHTML = '<tr style="text-align: center;"><td colspan="4">No results found</td></tr>';
  }
  else {
  let rows = "";
  result.forEach((user) => {
    rows += `<tr><td>${user.username}</td><td>${user.email}</td><td>${user.department}</td><td>${user.role_user}</td></tr>`;
  });
  tableBody.innerHTML = rows;
  }
}

async function deleteUser() {
    const removeUser = document.getElementById('remove-username').value;
    const formData = new FormData();
    formData.append('action', 'delete');
    formData.append('username', removeUser);
    const response = await fetch("script.php", {
        method: "POST",
        body: formData
    });
    alert(await response.text());
    deleteForm.reset();
    searchRun();
}

async function createUser() {
    const username = document.getElementById('new-username').value;
    const email = document.getElementById('new-email').value;
    const password = document.getElementById('new-password').value;
    const department = document.getElementById('new-department').value;
    const role = document.getElementById('new-role').value;
    const formData = new FormData();
    formData.append('action', 'create');
    formData.append('username', username);
    formData.append('password', password);
    formData.append('email', email);
    formData.append('role_user', role);
    formData.append('department', department);
    const response = await fetch("script.php", {
        method: "POST",
        body: formData
    });
    alert(await response.text());
    createFrom.reset();
    searchRun();
}

async function signOutButton() {
  const formData = new FormData();
  formData.append('action', 'sign_out')
  const response = await fetch("script.php", {
    method: "POST",
    body: formData
  });
  const result = await response.text();
  console.log(result);
  window.location.href = "login.html";
}

searchRun();

