<?php
include 'db.php';

if (!isset($_GET['id'])) {
    echo "<p>Movie not found.</p>";
    exit;
}

$movie_id = $_GET['id'];
$sql = "SELECT * FROM movies WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();
$movie = $result->fetch_assoc();

if (!$movie) {
    echo "<p>Movie not found.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $movie['title']; ?> - TikShow</title>
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
    <section class="movie-details">
        <img src="assets/images/<?php echo $movie['poster']; ?>" alt="Movie Poster">
        <div class="details">
            <h1><?php echo $movie['title']; ?></h1>
            <p><strong>Genre:</strong> <?php echo $movie['genre']; ?></p>
            <p><strong>Duration:</strong> <?php echo $movie['duration']; ?> mins</p>
            <p><strong>Release Date:</strong> <?php echo $movie['release_date']; ?></p>
            <p><strong>Synopsis:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            <a href="booking.php?movie_id=<?php echo $movie['id']; ?>" class="btn">Book Now</a>
        </div>
    </section>
</body>
</html>

<?php include 'includes/footer.php'; ?>