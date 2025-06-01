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

$sql = "INSERT INTO books (book_id, title, author, isbn, quantity, available_quantity, published_year) VALUES
(1, '1984', 'George Orwell', '978-0451524935', 56, 50, 1949),
(2, 'To Kill a Mockingbird', 'Harper Lee', '978-0061120084', 40, 35, 1960),
(3, 'Pride and Prejudice', 'Jane Austen', '978-1503290563', 30, 28, 1813),
(4, 'The Great Gatsby', 'F. Scott Fitzgerald', '978-0743273565', 45, 40, 1925),
(5, 'Moby Dick', 'Herman Melville', '978-1503280786', 25, 20, 1851),
(6, 'War and Peace', 'Leo Tolstoy', '978-0199232765', 20, 18, 1869),
(7, 'The Catcher in the Rye', 'J.D. Salinger', '978-0316769488', 38, 33, 1951),
(8, 'The Hobbit', 'J.R.R. Tolkien', '978-0547928227', 60, 55, 1937),
(9, 'Fahrenheit 451', 'Ray Bradbury', '978-1451673319', 50, 45, 1953),
(10, 'Jane Eyre', 'Charlotte Brontë', '978-0141441146', 35, 30, 1847),
(11, 'Brave New World', 'Aldous Huxley', '978-0060850524', 42, 38, 1932),
(12, 'Crime and Punishment', 'Fyodor Dostoevsky', '978-0486415871', 28, 25, 1866),
(13, 'The Odyssey', 'Homer', '978-0140268867', 33, 30, -800),
(14, 'The Brothers Karamazov', 'Fyodor Dostoevsky', '978-0374528379', 22, 20, 1880),
(15, 'Wuthering Heights', 'Emily Brontë', '978-0141439556', 30, 27, 1847),
(16, 'The Divine Comedy', 'Dante Alighieri', '978-0142437223', 18, 15, 1320),
(17, 'Les Misérables', 'Victor Hugo', '978-0451419439', 26, 22, 1862),
(18, 'Dracula', 'Bram Stoker', '978-0486411095', 34, 30, 1897),
(19, 'Frankenstein', 'Mary Shelley', '978-0486282114', 36, 32, 1818),
(20, 'The Picture of Dorian Gray', 'Oscar Wilde', '978-0141439570', 29, 26, 1890);
";
$result = $conn->query($sql);

header("Location: ../views/adminDashboard.php");
exit;

?>