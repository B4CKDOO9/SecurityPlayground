<?php
$servername = "localhost";
$username = "playground";
$password = "admin";
$dbname = "playground";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

$action = $_POST['action'];

if ($action == 'login') {

    $username = $_POST['username'];
    $password = $_POST['password'];


    $sql = "SELECT * FROM Users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        echo "Login successful";
    } else {
        echo "Invalid username or password";    
    }

}

if ($action == 'search') {

     $search_people = isset($_POST['searchPeople']) ? $_POST['searchPeople'] : '';
     $department_filter = isset($_POST['departmentFilter']) ? $_POST['departmentFilter'] : '';
     $role_filter = isset($_POST['roleFilter']) ? $_POST['roleFilter'] : '';

     if ($department_filter == '' && $role_filter == '') {
        $sql = "SELECT * FROM Users WHERE username LIKE '%$search_people%'";
        $result = $conn->query($sql);
     }
     elseif (empty($department_filter) == false && $role_filter == '') {
            $sql = "SELECT * FROM Users WHERE username LIKE '%$search_people%' AND department LIKE '%$department_filter%'";
            $result = $conn->query($sql);
    }
    else if ($department_filter == '' && empty($role_filter) == false) {
            $sql = "SELECT * FROM Users WHERE username LIKE '%$search_people%' AND role_user LIKE '%$role_filter%'";
            $result = $conn->query($sql);
    }
    else if (empty($department_filter) == false && empty($role_filter) == false) {
            $sql = "SELECT * FROM Users WHERE username LIKE '%$search_people%' AND department LIKE '%$department_filter%' AND role_user LIKE '%$role_filter%'";
            $result = $conn->query($sql);
    }

     if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "username: " . $row["username"] . "role: " . $row["role_user"] . "department: " .  $row["department"] . "<br>";
        }
     }
     else {
        echo "No results found";
     }
}

if ($action == 'create') {
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role_user = $_POST['role_user'];
    $department = $_POST['department'];

    $sql = "INSERT INTO Users (username, password, email, role_user, department) VALUES ('$username', '$password', '$email', '$role_user', '$department')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error adding a user";
    }
}

if ($action == 'delete') {
    $username = isset($_POST['username']) ? $_POST['username'] : '';

    $sql = "DELETE FROM Users WHERE username = '$username'";
    $result = $conn->query($sql);


    if ($result === TRUE) {
        echo "User removed successfully";
    } else {
        echo "Unable to remove user";
    }
}
?>