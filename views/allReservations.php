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
//$userId = ($_SESSION['user_id']);

//$user = ($_SESSION['name']);
$sql = "SELECT * FROM borrowings";
$result = $conn->query($sql);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reservations</title>
    <style>
        body {
            background-color: #f4f4f4;
            ;
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 2rem;
            margin-top: 100px;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: auto;
        }

        .reservation-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            font-family: 'Segoe UI', sans-serif;
            transition: transform 0.3s ease;
        }

        .reservation-card:hover {
            transform: translateY(-5px);
        }

        .card-header h3 {
            margin: 0 0 10px;
            color: #2c3e50;
        }

        .card-body p {
            margin: 8px 0;
            color: #34495e;
        }

        .status {
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: bold;
        }

        .status.pending {
            background-color: #f1c40f;
            color: #fff;
        }

        .status.approved {
            background-color: #2ecc71;
        }

        .status.returned {
            background-color: #3498db;
        }


        .card-footer {
            margin-top: 15px;
        }

        .button-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: space-between;
        }

        .button-group form {
            flex: 1;
        }

        .button-group button {
            width: 100%;
            padding: 10px 0;
            font-weight: bold;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .cancel-btn {
            background-color: #e74c3c;
            color: white;
        }

        .cancel-btn:hover {
            background-color: #c0392b;
        }

        .confirm-btn {
            background-color: #3498db;
            color: white;
        }

        .confirm-btn:hover {
            background-color: #2980b9;
        }

        .approve-btn {
            background-color: #2ecc71;
            color: white;
        }

        .approve-btn:hover {
            background-color: #27ae60;
        }


        .cancel-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .cancel-btn:hover {
            background-color: #c0392b;
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

        .confirm-btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            margin-left: 8px;
            transition: background-color 0.3s ease;
        }

        .confirm-btn:hover {
            background-color: #2980b9;
        }

        .approve-btn {
            background-color: #2ecc71;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            margin-left: 8px;
            transition: background-color 0.3s ease;
        }

        .approve-btn:hover {
            background-color: #27ae60;
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
    <h2>All Reservations</h2>
    <div class="card-container">
        <!-- Repeat this block for each reservation -->
        <?php
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $bookId = $row['book_id'];
                $sql2 = "SELECT * FROM books where book_id = $bookId;";
                $result2 = $conn->query($sql2);
                $row2 = mysqli_fetch_assoc($result2);
                $userId = $row['user_id'];
                $sql3 = "SELECT * FROM users where user_id = $userId;";
                $result3 = $conn->query($sql3);
                $row3 = mysqli_fetch_assoc($result3);
                ?>

                <div class="reservation-card">
                    <div class="card-header">
                        <h3>Book Title: <span><?= $row2['title'] ?></span></h3>
                    </div>
                    <div class="card-body">
                        <p><strong>User:</strong> <?= $row3['name'] ?></p>
                        <p><strong>Borrow Date:</strong> <?= $row['borrow_date'] ?></p>
                        <p><strong>Return Date:</strong> <?= $row['return_date'] ?></p>
                        <p><strong>Status:</strong>
                            <span class="status <?= strtolower($row['status']) ?>">
                                <?= ucfirst($row['status']) ?>
                            </span>
                        </p>
                    </div>
                    <div class="card-footer">
                        <div class="button-group">
                            <form action="../controller/deleteReservation.php" method="post">
                                <input type="hidden" name="borrowing_id" value="<?= $row['borrowing_id'] ?>">
                                <button class="cancel-btn">
                                    <?php if($row['status'] != 'returned'){?>
                                Cancel
                            <?php }else{?>
                                Clear
                                <?php }?>
                                </button>
                            </form>
                            <?php if($row['status'] == 'approved'){  ?>
                            <form action="../controller/returned.php" method="post">
                                <input type="hidden" name="borrowing_id" value="<?= $row['borrowing_id'] ?>">
                                <input type="hidden" name="book_id" value="<?= $row['book_id'] ?>">
                                <button class="confirm-btn">Returned ?</button>
                            </form>
                            <?php }?>
                            <?php if ($row['status'] == 'pending'){ ?>
                            <form action="../controller/approved.php" method="post">
                                <input type="hidden" name="borrowing_id" value="<?= $row['borrowing_id'] ?>">
                                <button class="approve-btn">Approve</button>
                            </form>
                            <?php } ?>
                        </div>
                    </div>

                </div>

                <?php
            }
        }
        ?>
    </div>

    <script>
        document.querySelector(".menu-toggle").addEventListener("click", () => {
            document.querySelector(".nav-links").classList.toggle("show");
        });
    </script>

</body>

</html>