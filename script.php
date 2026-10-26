<?php
$servername = "localhost";
$username = "playground";
$password = "admin";
$dbname = "playground";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$action = $_POST['action'];

if ($action == 'login') {

    $username = $_POST['username'];
    $password = $_POST['password'];


    $sql = "SELECT * FROM Users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if($row['role_user'] == 'Administrator') {
            echo "Logged in as Administrator";
        }
        else {
            echo "Login successful";
        }
    }
    else {
        echo "Invalid username or password";
    }

}

if ($action == 'search') {

     $search_people = isset($_POST['search']) ? $_POST['search'] : '';
     $department_filter = isset($_POST['department']) ? $_POST['department'] : '';
     $role_filter = isset($_POST['role']) ? $_POST['role'] : '';

     if ($department_filter == '' && $role_filter == '') {
        $sql = "SELECT username, email, department, role_user FROM Users WHERE username LIKE '%$search_people%'";
        $result = $conn->query($sql);
     }
     elseif (empty($department_filter) == false && $role_filter == '') {
            $sql = "SELECT username, email, department, role_user FROM Users WHERE username LIKE '%$search_people%' AND department LIKE '%$department_filter%'";
            $result = $conn->query($sql);
    }
    else if ($department_filter == '' && empty($role_filter) == false) {
            $sql = "SELECT username, email, department, role_user FROM Users WHERE username LIKE '%$search_people%' AND role_user LIKE '%$role_filter%'";
            $result = $conn->query($sql);
    }
    else if (empty($department_filter) == false && empty($role_filter) == false) {
            $sql = "SELECT username, email, department, role_user FROM Users WHERE username LIKE '%$search_people%' AND department LIKE '%$department_filter%' AND role_user LIKE '%$role_filter%'";
            $result = $conn->query($sql);
    }

    header('Content-Type: application/json');
    $json_array = array();

     if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
           array_push($json_array, $row);
        }
    }
    echo json_encode($json_array);
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
    $username = $_POST['username'];

    $sql = "DELETE FROM Users WHERE username = '$username'";
    $result = $conn->query($sql);


    if ($result === TRUE) {
        echo "User removed successfully";
    } else {
        echo "Unable to remove user";
    }
}

if ($action == 'sign_out') {
    session_start();
    session_destroy();
    echo "Signed out successfully";
}
?>