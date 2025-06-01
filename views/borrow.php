<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.html");
    exit;
}
$username = ($_SESSION['name']);
$email = ($_SESSION['email']);
$userId = ($_SESSION['user_id']);
$role = ($_SESSION['role']);

$conn = new mysqli("127.0.0.1", "root", "", "test_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bookId = $_POST['book_id'];
}

$sql = "SELECT books.*, book_Images.image_path 
FROM books 
LEFT JOIN book_Images ON books.book_id = book_Images.book_id 
WHERE books.book_id = $bookId 
GROUP BY books.book_id";

$result = $conn->query($sql);
if ($result->num_rows == 1) {
    $book = $result->fetch_assoc();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $book['title'] ?> - Borrow</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
        }

        .book-container {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 100px;
        }

        .book-card {
            background: white;
            padding: 30px;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }

        .book-card:hover {
            transform: translateY(-5px);
        }

        .book-title {
            font-size: 1.8rem;
            color: #2c3e50;
        }

        .book-author {
            font-size: 1.4rem;
            color: #16a085;
        }

        .borrow-form {
            width: 400px;
            background: white;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            display: flex;
            flex-direction: column;

        }

        label {
            font-weight: bold;
            margin-top: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .borrow-btn {
            background: #2980b9;
            color: white;
            padding: 12px;
            font-size: 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 15px;
        }

        .borrow-btn:hover {
            background: #1a5276;
        }

        /* Navbar Styling */
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

        .error-msg {
            color: red;
            font-size: 0.9em;
            display: block;
            margin-top: 4px;
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
    <div class="book-container">
        <div class="book-card">
            <?php if (!empty($book['image_path'])) { ?>
                <img src="<?= $book['image_path'] ?>" alt="Book Cover"
                    style="width:100%; height:250px; object-fit:cover; border-radius:5px; margin-bottom:15px;">
            <?php } else { ?>
                <img src="../uploads/default.png" alt="Default Cover"
                    style="width:100%; height:250px; object-fit:cover; border-radius:5px; margin-bottom:15px;">
            <?php }
            ; ?>

            <h5 class="book-title"><?= $book['title'] ?></h5>
            <h6 class="book-author"><?= $book['author'] ?></h6>
            <p><strong>ISBN:</strong> <?= $book['isbn'] ?></p>
            <p><strong>Number of Books:</strong> <?= $book['quantity'] ?></p>
            <p><strong>Available Quantity:</strong> <?= $book['available_quantity'] ?></p>
            <p><strong>Published Year:</strong> <em><?= $book['published_year'] ?></em></p>
        </div>
        <form method="post" action="../controller/borrow.php" class="borrow-form" id="borrowForm">
            <label for="username">Name:</label>
            <input type="text" id="username" disabled value="<?= $username ?>">

            <label for="email">Email:</label>
            <input type="text" id="email" disabled value="<?= $email ?>">

            <input type="hidden" name="book_id" value="<?= $bookId ?>">
            <input type="hidden" name="user_id" value="<?= $userId ?>">

            <label for="borrow_date">Borrow Date:</label>
            <input type="date" id="borrow_date" name="borrow_date" value="<?= date("Y-m-d"); ?>">
            <small id="borrow_date_error" class="error-msg"></small>

            <label for="return_date">Return Date:</label>
            <input type="date" id="return_date" name="return_date" value="<?= date("Y-m-d"); ?>">
            <small id="return_date_error" class="error-msg"></small>

            <button type="submit" class="borrow-btn">Borrow</button>
        </form>
    </div>
    <script>
        document.querySelector(".menu-toggle").addEventListener("click", () => {
            document.querySelector(".nav-links").classList.toggle("show");
        });

        const borrowDateInput = document.getElementById("borrow_date");
        const returnDateInput = document.getElementById("return_date");


        const todayStr = new Date().toISOString().split('T')[0];
        borrowDateInput.min = todayStr;
        borrowDateInput.value = todayStr;
        returnDateInput.min = todayStr;
        returnDateInput.value = todayStr;

        borrowDateInput.addEventListener("change", function () {
            returnDateInput.min = borrowDateInput.value;
            if (returnDateInput.value < borrowDateInput.value) {
                returnDateInput.value = borrowDateInput.value;
            }
        });

        document.getElementById("borrowForm").addEventListener("submit", function (e) {

            document.getElementById("borrow_date_error").textContent = "";
            document.getElementById("return_date_error").textContent = "";

            const borrowDate = new Date(borrowDateInput.value);
            const returnDate = new Date(returnDateInput.value);

            let valid = true;

            if (borrowDate < new Date(todayStr)) {
                document.getElementById("borrow_date_error").textContent = "Borrow date cannot be before today.";
                valid = false;
            }

            if (returnDate < borrowDate) {
                document.getElementById("return_date_error").textContent = "Return date cannot be before borrow date.";
                valid = false;
            }

            if (!valid) {
                e.preventDefault();
            }
        });
    </script>
</body>

</html>