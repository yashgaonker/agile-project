<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "movie_booking");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $duration = $_POST['duration'];
    $showtime = $_POST['showtime'];

    $conn->query("INSERT INTO movies (title, genre, duration, showtime) VALUES ('$title', '$genre', '$duration', '$showtime')");
    header("Location: homepage.php");
}
?>

<!DOCTYPE html>
<html>
<head><title>Add Movie</title></head>
<body>
    <h2>Add Movie</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Movie Title" required>
        <input type="text" name="genre" placeholder="Genre" required>
        <input type="number" name="duration" placeholder="Duration (min)" required>
        <input type="datetime-local" name="showtime" required>
        <button type="submit">Add Movie</button>
    </form>
</body>
</html>
