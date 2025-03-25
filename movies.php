<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies - TikShow</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/css/style.css"> <!-- Custom styles -->
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
        .movie-poster {
            height: 300px; /* Fixed height */
            object-fit: cover; /* Ensures the image doesn't stretch */
            border-radius: 10px; /* Optional rounded corners */}
    </style>
</head>
<body class="bg-dark text-white">

<div class="container py-5">
    <h2 class="text-center mb-4 floating">All Movies</h2>

    <!-- Filter Form -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-4">
            <form method="GET" action="movies.php" class="d-flex gap-2 floating">
                <select name="genre" class="form-select">
                    <option value="">All Genres</option>
                    <option value="Action">Action</option>
                    <option value="Comedy">Comedy</option>
                    <option value="Drama">Drama</option>
                </select>
                <button type="submit" class="btn btn-danger">Filter</button>
            </form>
        </div>
    </div>

    <!-- Movies Grid -->
    <div class="container">
        <div class="row">
            <?php
            $sql = "SELECT * FROM movies";
            if (!empty($_GET['genre'])) {
                $genre = $_GET['genre'];
                $stmt = $conn->prepare("SELECT * FROM movies WHERE genre = ?");
                $stmt->bind_param("s", $genre);
                $stmt->execute();
                $result = $stmt->get_result();
            } else {
                $result = $conn->query($sql);
            }

            $count = 0; // Counter for tracking when to start a new row
            while ($row = $result->fetch_assoc()) {
                if ($count % 3 == 0) { // Start a new row every 3 movies
                    echo '<div class="row justify-content-center">';
                }

                echo "<div class='col-md-4 mb-4 floating'>
                        <div class='card bg-secondary text-white h-100'>
                            <img src='uploads/" . $row['poster'] . "' class='card-img-top movie-poster' alt='Movie Poster'>
                            <div class='card-body'>
                                <h2 class='card-title'>" . htmlspecialchars($row['title']) . "</h2>
                                <p class='card-text'>Genre: " . htmlspecialchars($row['genre']) . "</p>
                                <a href='movie_details.php?id=" . $row['id'] . "' class='btn btn-danger w-100'>View Details</a>
                            </div>
                        </div>
                      </div>";

                $count++;

                if ($count % 3 == 0) { // Close the row after 3 movies
                    echo '</div>';
                }
            }

            // Close any unclosed row div
            if ($count % 3 != 0) {
                echo '</div>';
            }

            if (isset($stmt)) {
                $stmt->close();
            }
            ?>
        </div>
    </div>
</div>

</div>


</body>
</html>

<?php include 'footer.php'; ?>
