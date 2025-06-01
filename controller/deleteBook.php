<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.html");
    exit;
}
$role = ($_SESSION['role']);
if ($role != 'admin') {
    header("Location: ../views/index.php");
    exit;
}
$conn = new mysqli("127.0.0.1", "root", "", "test_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['book_id'];

    $sql_image = "SELECT image_path FROM book_images WHERE book_id = $id;";
    $result_image = $conn->query($sql_image);
    if ($result_image->num_rows > 0) {
        $row = $result_image->fetch_assoc();
        $image_path = $row['image_path'];

        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }

    $sql = "DELETE FROM books WHERE book_id = $id;";
    $result = $conn->query($sql);
}



// $sql = "DELETE FROM books WHERE book_id = $id;";
// $result = $conn->query($sql);
header("Location: ../views/adminDashboard.php");
exit;
?>