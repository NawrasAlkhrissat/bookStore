<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.html");
    exit;
}
$role = ($_SESSION['role']);
if($role != 'admin'){
    header("Location: ../views/index.php");
    exit;
}
$conn = new mysqli("127.0.0.1", "root", "", "test_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = $_POST['book_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $quantity = $_POST['quantity'];
    $available_quantity = $_POST['available_quantity'];
    $published_year = $_POST['published_year'];
}
$sql = "UPDATE books
SET 
    title = '$title',
    author = '$author',
    isbn = '$isbn',
    quantity = $quantity,
    available_quantity = $available_quantity,
    published_year = $published_year
WHERE book_id = $book_id;
";
$result = $conn->query($sql);

header("Location: ../views/adminDashboard.php");
exit;
?>