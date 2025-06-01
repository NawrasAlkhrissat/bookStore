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
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $quantity = $_POST['quantity'];
    $available_quantity = $_POST['available_quantity'];
    $published_year = $_POST['published_year'];

    $targetDir = "../uploads/";
    $imageName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $imageName;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];


    if (in_array($imageFileType, $allowedTypes)) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {

            $sql = "INSERT INTO books(title, author, isbn, quantity, available_quantity, published_year)
                    VALUES ('$title','$author' , '$isbn', $quantity, $available_quantity, $published_year);";
            if ($conn->query($sql) === TRUE) {
                $book_id = $conn->insert_id;

                // إدخال مسار الصورة في جدول الصور
                $sql_image = "INSERT INTO book_images(book_id, image_path)
                              VALUES ($book_id, '$targetFilePath');";
                if ($conn->query($sql_image) === TRUE) {
                    header("Location: ../views/adminDashboard.php");
                    exit;
                }
            }
        }
    }

}


?>