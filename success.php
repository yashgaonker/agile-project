<?php
include 'includes/db.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['movie_id']) && isset($_POST['seat_number']) && isset($_POST['user_id'])) {
    $movie_id = $_POST['movie_id'];
    $seat_number = $_POST['seat_number'];
    $user_id = $_POST['user_id'];

    // Insert booking into database
    $sql = "INSERT INTO bookings (user_id, movie_id, seat_number) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $user_id, $movie_id, $seat_number);
    
    if ($stmt->execute()) {
        $booking_id = $stmt->insert_id;
    } else {
        echo "<p>Error processing your booking. Please try again.</p>";
        exit;
    }
} else {
    echo "<p>Invalid request.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Success - TikShow</title>
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
    <section class="success">
        <h1>Booking Confirmed!</h1>
        <p>Your ticket has been booked successfully.</p>
        <p><strong>Booking ID:</strong> <?php echo $booking_id; ?></p>
        <p><strong>Seat Number:</strong> <?php echo $seat_number; ?></p>
        <a href="index.php" class="btn">Go to Homepage</a>
    </section>
</body>
</html>

<?php include 'includes/footer.php'; ?>
