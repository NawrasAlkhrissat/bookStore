<?php
$conn = new mysqli("127.0.0.1", "root", "", "test_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $password = password_hash($pass, PASSWORD_DEFAULT);
    $role = "user";
}
$sql = "INSERT INTO users (name, email, password,role) VALUES ('$name', '$email','$password',   '$role');";
$result = $conn->query($sql);
if(!$result){
    echo "error Try again";
}

header("Location: ../views/login.html");
exit;
?>