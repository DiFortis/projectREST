<!DOCTYPE html>
<html>
<head>
  <title>Users</title>
</head>
<body>
  <h1>Users</h1>
  <ul id="users"></ul>

  <script>
    const usersList = document.getElementById('users');

    // Fetch all users from the API
        data.forEach(beverages => {
          const li = document.createElement('li');
          li.innerHTML = `${data.name}, ${data.ingredients}, ${data.is_available} `;
          usersList.appendChild(li);
        });

  </script>
</body>
</html>
