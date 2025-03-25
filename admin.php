<?php
include 'includes/db.php';

// Fetch all bookings
$sql = "SELECT bookings.id, users.name AS user_name, movies.title AS movie_title, bookings.seat_number 
        FROM bookings 
        JOIN users ON bookings.user_id = users.id 
        JOIN movies ON bookings.movie_id = movies.id 
        ORDER BY bookings.id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - TikShow</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            background: linear-gradient(135deg, #2b0a3d, #000000); /* Fallback gradient */
            background: url('assets/images/background.webp') no-repeat center center fixed;
            background-size: cover; /* Ensures the image fills the entire screen */
            background-attachment: fixed;
            color: white;
            overflow-x: hidden;
        }
        .floating {
            animation: floatAnimation 6s infinite alternate ease-in-out;
        }
        @keyframes floatAnimation {
            from { transform: translateY(0px); }
            to { transform: translateY(10px); }
        }
    </style>
</head>
<body>
    <section class="admin">
        <h1>Admin Dashboard</h1>
        <h2>Bookings</h2>
        <a href="add_movies.php">add movies</a>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Movie</th>
                <th>Seat</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['user_name']; ?></td>
                    <td><?php echo $row['movie_title']; ?></td>
                    <td><?php echo $row['seat_number']; ?></td>
                    <td><a href="delete_booking.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a></td>
                </tr>
            <?php } ?>
        </table>
    </section>
</body>
</html>

<?php include 'includes/footer.php'; ?>