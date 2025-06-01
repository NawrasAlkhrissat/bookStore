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
    $book_id = $_POST['book_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'];
    $quantity = $_POST['quantity'];
    $available_quantity = $_POST['available_quantity'];
    $published_year = $_POST['published_year'];

    // تحديث بيانات الكتاب
    $sql = "UPDATE books
            SET 
                title = '$title',
                author = '$author',
                isbn = '$isbn',
                quantity = $quantity,
                available_quantity = $available_quantity,
                published_year = $published_year
            WHERE book_id = $book_id;";
    $result = $conn->query($sql);

    if (isset($_FILES['book_image']) && $_FILES['book_image']['error'] == 0) {
        $image_name = $_FILES['book_image']['name'];
        $image_tmp = $_FILES['book_image']['tmp_name'];
        $image_path = '../uploads/' . basename($image_name);

        move_uploaded_file($image_tmp, $image_path);

        $check_sql = "SELECT * FROM book_Images WHERE book_id = $book_id";
        $check_result = $conn->query($check_sql);

        if ($check_result->num_rows > 0) {
            $old_image = $check_result->fetch_assoc()['image_path'];

            if (file_exists($old_image)) {
                unlink($old_image);
            }

            $update_image_sql = "UPDATE book_Images SET image_path = '$image_path' WHERE book_id = $book_id";
            $conn->query($update_image_sql);
        } else {
            $insert_image_sql = "INSERT INTO book_Images (book_id, image_path) VALUES ($book_id, '$image_path')";
            $conn->query($insert_image_sql);
        }
    }
}


header("Location: ../views/adminDashboard.php");
exit;
?>