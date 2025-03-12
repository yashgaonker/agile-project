<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "movie_booking");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch movies
$movies = $conn->query("SELECT * FROM movies");

// Fetch bookings
$bookings = $conn->query("SELECT bookings.id, movies.title, bookings.customer_name, bookings.seats, bookings.booking_time
                          FROM bookings JOIN movies ON bookings.movie_id = movies.id");

// Fetch total users (Assuming there's a 'users' table)
$total_users = $conn->query("SELECT COUNT(*) AS total FROM admin")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Movie Booking</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { display: flex; justify-content: space-between; }
        .box { width: 30%; padding: 20px; border: 1px solid #ddd; background: #f9f9f9; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; padding: 10px; text-align: center; }
        a { display: block; margin-top: 10px; text-decoration: none; color: blue; }
    </style>
</head>
<body>

    <h2>Welcome, Admin!</h2>
    <div class="container">
        <div class="box">
            <h3>Total Movies</h3>
            <p><?php echo $movies->num_rows; ?></p>
            <a href="add_movie.php">Add Movie</a>
        </div>
        <div class="box">
            <h3>Total Bookings</h3>
            <p><?php echo $bookings->num_rows; ?></p>
        </div>
        <div class="box">
            <h3>Total Users</h3>
            <p><?php echo $total_users; ?></p>
        </div>
    </div>

    <h3>Recent Bookings</h3>
    <table>
        <tr>
            <th>Movie</th>
            <th>Customer Name</th>
            <th>Seats</th>
            <th>Booking Time</th>
        </tr>
        <?php while ($row = $bookings->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['title']; ?></td>
                <td><?php echo $row['customer_name']; ?></td>
                <td><?php echo $row['seats']; ?></td>
                <td><?php echo $row['booking_time']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <br>
    <a href="logout.php">Logout</a>

</body>
</html>
