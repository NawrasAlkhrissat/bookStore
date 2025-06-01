<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.html");
    exit;
}
$conn = new mysqli("127.0.0.1", "root", "", "test_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ( $_SERVER [ "REQUEST_METHOD" ] == "POST" ){
    $bookId = $_POST['book_id'];
    $userId = $_POST['user_id'];
    $borrowDate = $_POST['borrow_date'];
    $returnDate = $_POST['return_date'];
    $status = "pending";
}
$sql = "INSERT INTO borrowings (user_id, book_id, borrow_date , return_date, status) 
        VALUES ('$userId', '$bookId', '$borrowDate', ' $returnDate','$status')";
    $result = $conn->query($sql);

$sql2 = "UPDATE books
SET available_quantity = available_quantity - 1 
WHERE book_id = '$bookId' AND available_quantity > 0";

    $result2 = $conn->query($sql2);
    
    header("Location: ../views/index.php");
    exit;
?>