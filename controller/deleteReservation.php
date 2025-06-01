<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.html");
    exit;
}
$role = ($_SESSION['role']);
$conn = new mysqli("127.0.0.1", "root", "", "test_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['borrowing_id'];
}
$sql = "DELETE FROM borrowings where borrowing_id = $id ; ";
$result = $conn->query($sql);
if($role == "user"){
header("Location: ../views/reservations.php");
            exit;
        }else{
            header("Location: ../views/allReservations.php");
            exit;
            }
?>