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
    $id = $_POST['borrowing_id'];
}
$sql = "UPDATE borrowings
SET status = 'approved'
WHERE borrowing_id = $id;";
$result = $conn->query($sql);
header("Location: ../views/allReservations.php");
exit;

?>