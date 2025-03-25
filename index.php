<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TikShow - Movie Ticket Booking</title>
    <link rel="stylesheet" href="bootstrap.css.min">
    <link rel="stylesheet" href="style.css">
</head>
<body style="background: linear-gradient(135deg, #2b0a3d, #000000); background: url('assets/images/background.webp') no-repeat center center fixed; background-size: cover; background-attachment: fixed; color: white; overflow-x: hidden; font-family: 'Poppins', sans-serif; margin: 0; padding: 0;">

    <!-- Header Section -->
    <header style="background: rgba(0, 0, 0, 0.9); padding: 15px 30px; display: flex; align-items: center; justify-content: space-between; position: fixed; width: 100%; top: 0; z-index: 1000;">
        <div style="font-size: 26px; font-weight: bold; color: #e50914;">TIKSHOW</div>
        <nav>
            <ul style="display: flex; list-style: none; margin: 0; padding: 0;">
                <li style="margin-right: 15px;"><a href="C:\xampp\htdocs\tikshow\index.php" target="_blank" style="text-decoration: none; color: white; padding: 10px 15px; border-radius: 5px; transition: 0.3s ease; background: transparent;">Home</a></li>
                <li style="margin-right: 15px;"><a href="movies.php" style="text-decoration: none; color: white; padding: 10px 15px; border-radius: 5px; transition: 0.3s ease;">Movies</a></li>
                <li style="margin-right: 15px;"><a href="theaters.php" style="text-decoration: none; color: white; padding: 10px 15px; border-radius: 5px; transition: 0.3s ease;">Theaters</a></li>
                <li style="margin-right: 15px;"><a href="offers.php" style="text-decoration: none; color: white; padding: 10px 15px; border-radius: 5px; transition: 0.3s ease;">Offers</a></li>
                <li><a href="account.php" style="text-decoration: none; color: white; padding: 10px 15px; border-radius: 5px; transition: 0.3s ease;">My Account</a></li>

                <li><a href="login.html" style="text-decoration: none; color: white; padding: 10px 15px; border-radius: 5px; transition: 0.3s ease;">Login</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section style="height: 500px; background: url('assets/images/hero-bg.jpg') no-repeat center center/cover; position: relative; display: flex; align-items: center; justify-content: center; text-align: center; margin-top: 80px;">
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background:  #4B0082;"></div>
        <div id="bg" style="position: relative; z-index: 10;">
            <h1 style="font-size: 42px; font-weight: bold;">NOW SHOWING</h1>
            <p style="font-size: 18px; margin: 10px 0;">A Movie Ticket Booking Experience Like Never Before</p>
            <a href="movies.php" style="display: inline-block; padding: 12px 25px; font-size: 18px; color: white; background: #e50914; border-radius: 5px; text-decoration: none; transition: 0.3s ease;">Browse Movies</a>
        </div>
    </section>

    <!-- Now Showing Section -->
    <section style="padding: 50px; text-align: center;">
        <div style="display: flex; justify-content: center; flex-wrap: wrap; gap: 20px;">

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

            $count = 0;
            while ($row = $result->fetch_assoc()) {
                if ($count % 3 == 0) { echo '<div style="display: flex; justify-content: center; flex-wrap: wrap;">'; }

                echo "<div style='background: rgba(34, 34, 34, 0.9); border-radius: 10px; width: 250px; overflow: hidden; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3); transition: 0.3s ease; text-align: center; padding: 15px;'>
                        <img src='uploads/" . $row['poster'] . "' style='width: 100%; height: 350px; object-fit: cover; border-radius: 10px 10px 0 0;'>
                        <div style='padding: 15px;'>
                            <h2 style='font-size: 20px; margin-bottom: 5px;'>" . htmlspecialchars($row['title']) . "</h2>
                            <p style='font-size: 14px; color: #ccc; margin: 5px 0;'>Genre: " . htmlspecialchars($row['genre']) . "</p>
                            <a href='movie_details.php?id=" . $row['id'] . "' style='display: block; background: #e50914; color: white; padding: 10px; border-radius: 5px; text-decoration: none; transition: 0.3s ease;'>View Details</a>
                        </div>
                      </div>";

                $count++;
                if ($count % 3 == 0) { echo '</div>'; }
            }

            if ($count % 3 != 0) { echo '</div>'; }

            if (isset($stmt)) { $stmt->close(); }
        ?>
        </div>
    </section>

</body>
</html>

<?php include 'footer.php'; ?>
