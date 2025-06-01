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

$sql = "SELECT * FROM books;";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
    <link rel="stylesheet" href="styles.css">
</head>
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

    .grid-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        justify-content: center;
        padding: 20px;
    }

    .book-card {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }

    .book-card:hover {
        transform: translateY(-5px);
    }

    .book-title {
        font-size: 1.5rem;
        color: #2c3e50;
    }

    .book-author {
        font-size: 1.2rem;
        color: #16a085;
    }

    .borrow-btn {
        background: #2980b9;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        display: block;
        margin-top: 10px;
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

    .edit-btn,
    .delete-btn {
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
        margin-top: 10px;
        margin-right: 10px;
        transition: background-color 0.3s ease;
    }

    .edit-btn {
        background-color: #27ae60;
        color: white;
    }

    .edit-btn:hover {
        background-color: #1e8449;
    }

    .delete-btn {
        background-color: #e74c3c;
        color: white;
    }

    .delete-btn:hover {
        background-color: #c0392b;
    }

    .add-book-form {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin: 30px auto;
        max-width: 700px;
    }

    .add-book-form h3 {
        margin-bottom: 20px;
        color: #2c3e50;
        text-align: center;
        font-size: 1.6rem;
    }

    .add-book-form form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .add-book-form input {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 1rem;
    }

    .add-book-form button {
        grid-column: span 2;
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

    .add-book-form button:hover {
        background-color: #1a5276;
    }
</style>

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
    <div class="container">
        <h2>Admi Dashboard</h2>
        <div class="add-book-form">
            <h3>Add New Book</h3>
            <form action="../controller/addBook.php" method="post">
                <input type="text" name="title" placeholder="Book Title" required>
                <input type="text" name="author" placeholder="Author" required>
                <input type="text" name="isbn" placeholder="ISBN" required>
                <input type="number" name="quantity" placeholder="Total Quantity" required min="1">
                <input type="number" name="available_quantity" placeholder="Available Quantity" required min="0">
                <input type="number" name="published_year" placeholder="Published Year" required min="1600" max="2155">
                <button type="submit">Add Book</button>
            </form>
        </div>
        <div class="grid-container">
            <?php
            if ($result->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="book-card">
                        <h5 class="book-title"><?= $row['title'] ?></h5>
                        <h6 class="book-author"><?= $row['author'] ?></h6>
                        <p><strong>ISBN:</strong> <?= $row['isbn'] ?></p>
                        <p><strong>Number of Books:</strong> <?= $row['quantity'] ?></p>
                        <p><strong>Available Quantity:</strong> <?= $row['available_quantity'] ?></p>
                        <p><strong>Published Year:</strong> <em><?= $row['published_year'] ?></em></p>
                        <form method="post" action="editBook.php" style="display:inline-block;">
                            <input type="hidden" name="book_id" value="<?= $row['book_id'] ?>">
                            <button type="submit" class="edit-btn">Edit</button>
                        </form>

                        <form method="post" action="../controller/deleteBook.php" style="display:inline-block;">
                            <input type="hidden" name="book_id" value="<?= $row['book_id'] ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>

                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</body>
<script>
    document.querySelector(".menu-toggle").addEventListener("click", () => {
        document.querySelector(".nav-links").classList.toggle("show");
    });
</script>

</html>