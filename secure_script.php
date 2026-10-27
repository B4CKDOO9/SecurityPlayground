<?php
session_start();
$servername = "localhost";
$username = "playground";
$password = "admin";
$dbname = "playground";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$action = $_POST['action'];

if($action == 'login') {

    $username = $_POST['username'];
    $password_post = $_POST['password'];

    $sql = "SELECT username, password, role_user FROM Users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($username, $password, $role_user);

    if ($stmt->fetch() && password_verify($password_post, $password)) {
        if($role_user == 'Administrator') {
            $_SESSION["role"] = "Administrator";
            echo "Logged in as Administrator";
        }
        else {
            $_SESSION["role"] = "User";
            echo "Login successful";
        }
    }
    else {
        echo "Invalid username or password";
    }

    $stmt->close();

} 

if ($action == 'search') {
 if((isset($_SESSION["role"]) && $_SESSION["role"] == "Administrator") || (isset($_SESSION["role"]) && $_SESSION["role"] == "User")) {

     $search_people = isset($_POST['search']) ? $_POST['search'] : '';
     $department_filter = isset($_POST['department']) ? $_POST['department'] : '';
     $role_filter = isset($_POST['role']) ? $_POST['role'] : '';

     if ($department_filter == '' && $role_filter == '') {
            $sql = "SELECT username, email, department, role_user FROM Users WHERE username LIKE ?";
            $stmt = $conn->prepare($sql);
            $search_wild = "%$search_people%";
            $stmt->bind_param("s", $search_wild);
            $stmt->execute();
            $result = $stmt->get_result();
     }
     else if (empty($department_filter) == false && $role_filter == '') {
            $sql = "SELECT username, email, department, role_user FROM Users WHERE username LIKE ? AND department = ?";
            $stmt = $conn->prepare($sql);
            $search_wild = "%$search_people%";
            $stmt->bind_param("ss", $search_wild, $department_filter);
            $stmt->execute();
            $result = $stmt->get_result();
    }
    else if ($department_filter == '' && empty($role_filter) == false) {
            $sql = "SELECT username, email, department, role_user FROM Users WHERE username LIKE ? AND role_user = ?";
            $stmt = $conn->prepare($sql);
            $search_wild = "%$search_people%";
            $stmt->bind_param("ss", $search_wild, $role_filter);
            $stmt->execute();
            $result = $stmt->get_result();
    }
    else if (empty($department_filter) == false && empty($role_filter) == false) {
            $sql = "SELECT username, email, department, role_user FROM Users WHERE username LIKE ? AND department = ? AND role_user = ?";
            $stmt = $conn->prepare($sql);
            $search_wild = "%$search_people%";
            $stmt->bind_param("sss", $search_wild, $department_filter, $role_filter);
            $stmt->execute();
            $result = $stmt->get_result();
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
 else {
    echo "Unauthorized action";
 }
}

if ($action == 'create') {
    if(isset($_SESSION["role"]) && $_SESSION["role"] == "Administrator") {
    
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $role_user = $_POST['role_user'];
        $department = $_POST['department'];

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        $sql = "INSERT INTO Users (username, password, email, role_user, department) VALUES (?, ?, ?, ?, ?)";
    
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $username, $hashed_password, $email, $role_user, $department);
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            echo "New record created successfully";
        } else {
            echo "Error adding a user";
        }
    }
    else {
        echo "Unauthorized action";
    }
}

if ($action == 'delete') {
    if(isset($_SESSION["role"]) && $_SESSION["role"] == "Administrator") {
    
        $username = $_POST['username'];
    
        $sql = "DELETE FROM Users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
    
        if ($stmt->affected_rows > 0) {
            echo "User removed successfully";
        } else {
            echo "Unable to remove user";
        }
    }
    else {
        echo "Unauthorized action";
    }
}

if ($action == 'sign_out') {

    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
        );
    }

    session_destroy();
    echo "Signed out successfully";
}

?>