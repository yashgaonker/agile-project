<?php
session_start();
$conn = new mysqli("localhost", "root", "", "movie_booking");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // MD5 Encryption

    $sql = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['admin'] = $username;
        header("Location: homepage.php");
    } else {
        echo "<script>alert('Invalid Credentials'); window.location='login.html';</script>";
    }
}
?>
