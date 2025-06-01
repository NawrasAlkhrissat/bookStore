<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.html");
    exit;
}
$role = $_SESSION['role'];
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
}

$sql = "SELECT * FROM books WHERE book_id = $book_id;";
$result = $conn->query($sql);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 2rem;
            margin-top: 100px;
        }

        .edit-book-form {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 30px auto;
            max-width: 700px;
        }

        .edit-book-form h3 {
            margin-bottom: 20px;
            color: #2c3e50;
            text-align: center;
            font-size: 1.6rem;
        }

        .edit-book-form form {
            display: grid;
            gap: 15px;
        }

        .edit-book-form input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
        }

        .edit-book-form button {
            grid-column: span 1;
            background-color: #2980b9;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .edit-book-form button:hover {
            background-color: #1a5276;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #2980b9;
            padding: 15px 20px;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            color: white;
            z-index: 1000;
        }

        .nav-logo {
            font-size: 1.8rem;
            font-weight: bold;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 30px;
            /* Increase the spacing between links */
            padding-right: 35px;
            /* Add space from the right edge */
        }

        .nav-links li {
            display: inline;
        }

        .nav-links a {
            text-decoration: none;
            color: white;
            font-size: 1.2rem;
            transition: color 0.3s ease-in-out;
        }

        .nav-links a:hover {
            color: #f4d03f;
        }

        /* Responsive Menu Button */
        .menu-toggle {
            display: none;
            font-size: 1.8rem;
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding-right: 35px;
        }

        #nav {
            background: #2980b9;
            color: white;
            border: none;
            font-size: 1.2rem;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
                flex-direction: column;
                background: #2980b9;
                width: 100%;
                position: absolute;
                top: 60px;
                left: 0;
                text-align: center;
                padding: 15px;
            }

            .nav-links.show {
                display: flex;
            }

            .menu-toggle {
                display: block;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="nav-logo">BOOKSTORE</div>
        <ul class="nav-links">
            <li><a href="./index.php">All Books</a></li>
            <?php if ($role === 'admin') { ?>
                <li><a href="./adminDashboard.php">Admin Dashboard</a></li>
                <li><a href="./allReservations.php">All Reservations</a></li>
            <?php } else {
                ($role === 'user') ?>
                <li><a href="./reservations.php">My Reservations</a></li>
            <?php } ?>
            <li>
                <form action="../controller/signout.php">
                    <button id="nav">Sign Out</button>
                </form>
            </li>
        </ul>
        <button class="menu-toggle">&#9776;</button>
    </nav>
    <h2></h2>
    <div class="edit-book-form">
        <h3>Edit Book</h3>
        <form action="../controller/editBook.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="book_id" value="<?= $book_id ?>">
            <input type="text" name="title" placeholder="Book Title" value="<?= $row['title'] ?>" required>
            <input type="text" name="author" placeholder="Author" value="<?= $row['author'] ?>" required>
            <input type="text" name="isbn" value="<?= $row['isbn'] ?>" placeholder="ISBN" required>
            <input type="number" name="quantity" placeholder="Total Quantity" value="<?= $row['quantity'] ?>" required
                min="1">
            <input type="number" name="available_quantity" placeholder="Available Quantity"
                value="<?= $row['available_quantity'] ?>" required min="0">
            <input type="number" name="published_year" placeholder="Published Year"
                value="<?= $row['published_year'] ?>" required min="1600" max="2155">
            <input type="file" name="book_image">
            <button type="submit">Edit Book</button>
        </form>
    </div>










    <script>
        document.querySelector(".menu-toggle").addEventListener("click", () => {
            document.querySelector(".nav-links").classList.toggle("show");
        });
    </script>
</body>

</html>