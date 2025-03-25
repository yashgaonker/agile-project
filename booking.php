<?php
include 'db.php';
include 'header.php';

if (!isset($_GET['movie_id'])) {
    echo "<p class='error-msg'>Invalid movie selection.</p>";
    exit;
}

$movie_id = $_GET['movie_id'];
$sql = "SELECT * FROM movies WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();
$movie = $result->fetch_assoc();

if (!$movie) {
    echo "<p class='error-msg'>Movie not found.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book <?php echo htmlspecialchars($movie['title']); ?> - TikShow</title>
    
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url('assets/images/background.webp') no-repeat center center fixed;
            background-size: cover;
            background-attachment: fixed;
            color: white;
            overflow-x: hidden;
            position: relative;
        }

        /* Animated Background Overlay */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            z-index: -1;
        }

        /* Floating Animation */
        .floating {
            animation: floatAnimation 6s infinite alternate ease-in-out;
        }

        @keyframes floatAnimation {
            from { transform: translateY(0px); }
            to { transform: translateY(10px); }
        }

        /* Booking Container */
        .booking-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            width: 400px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease-in-out;
        }

        .booking-container:hover {
            transform: scale(1.03);
        }

        .booking-container h1 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #ffcc00;
            text-shadow: 0 0 10px rgba(255, 204, 0, 0.8);
        }

        /* Select Field */
        .booking-container select {
            width: 100%;
            padding: 12px;
            border: 2px solid #ffcc00;
            border-radius: 5px;
            font-size: 16px;
            margin: 15px 0;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            text-align: center;
            outline: none;
            transition: 0.3s ease;
        }

        .booking-container select:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Button */
        .btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(45deg, #ffcc00, #ff9900);
            color: black;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: 0.3s ease-in-out;
            box-shadow: 0 0 10px rgba(255, 204, 0, 0.8);
        }

        .btn:hover {
            background: linear-gradient(45deg, #d4a700, #b37c00);
            box-shadow: 0 0 20px rgba(255, 204, 0, 1);
        }

        /* Error Message */
        .error-msg {
            color: red;
            text-align: center;
            font-size: 18px;
            padding: 10px;
        }
    </style>
</head>
<body>

    <div class="booking-container floating">
        <h1>Book Tickets for <?php echo htmlspecialchars($movie['title']); ?></h1>
        <form action="payment.php" method="POST">
            <input type="hidden" name="movie_id" value="<?php echo $movie['id']; ?>">

            <label for="seats">Select Seats:</label>
            <select name="seat_number" required>
                <option value="A1">A1</option>
                <option value="A2">A2</option>
                <option value="B1">B1</option>
                <option value="B2">B2</option>
            </select>

            <button type="submit" class="btn">Proceed to Payment</button>
        </form>
    </div>

</body>
</html>
