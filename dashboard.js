const searchBar = document.getElementById('search');
const filterRoles = document.getElementById('role');
const filterDepartments = document.getElementById('department');
const tableBody = document.getElementById('user-table');

searchBar.addEventListener('input', async function() {
  await searchRun();
});
filterRoles.addEventListener('change', async function() {
  await searchRun();
});
filterDepartments.addEventListener('change', async function() {
  await searchRun();
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
searchRun();

