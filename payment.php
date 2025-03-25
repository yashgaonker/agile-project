<?php
include 'includes/db.php';
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['movie_id']) && isset($_POST['seat_number'])) {
    $movie_id = $_POST['movie_id'];
    $seat_number = $_POST['seat_number'];
    $user_id = 1; // Replace with actual user authentication

    // Fetch movie details
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
} else {
    echo "<p class='error-msg'>Invalid booking details.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - TikShow</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        /* Body Styling */
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            background: url('assets/images/background.webp') no-repeat center center fixed;
            background-size: cover;
            color: white;
            margin: 0;
            padding-top: 80px; /* Ensures content is pushed below the header */
        }

        /* Header Styling */
        header {
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.8); /* Semi-transparent background */
            padding: 15px 0;
            text-align: center;
            z-index: 1000;
        }

        /* Payment Container */
        .payment-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            width: 400px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease-in-out;
            margin-top: 100px; /* Pushes it down so it doesn't go under the header */
        }

        .payment-container:hover {
            transform: scale(1.02);
        }

        .payment-container h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #ffcc00;
            text-shadow: 0 0 10px rgba(255, 204, 0, 0.8);
        }

        .payment-container p {
            font-size: 18px;
            margin-bottom: 15px;
            color: #fff;
        }

        /* Input Fields */
        .payment-container input {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            outline: none;
            transition: 0.3s ease;
        }

        .payment-container input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .payment-container input:hover,
        .payment-container input:focus {
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

        /* Floating Animation */
        .floating {
            animation: floatAnimation 6s infinite alternate ease-in-out;
        }

        @keyframes floatAnimation {
            from { transform: translateY(0px); }
            to { transform: translateY(10px); }
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

    <div class="payment-container floating">
        <h1>Payment for <?php echo htmlspecialchars($movie['title']); ?></h1>
        <p>Seat: <strong><?php echo htmlspecialchars($seat_number); ?></strong></p>
        <p>Price: <strong>$10.00</strong></p>

        <form action="success.php" method="POST">
            <input type="hidden" name="movie_id" value="<?php echo $movie_id; ?>">
            <input type="hidden" name="seat_number" value="<?php echo $seat_number; ?>">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

            <label for="card">Card Number:</label>
            <input type="text" name="card" placeholder="XXXX-XXXX-XXXX-XXXX" required>

            <label for="expiry">Expiry Date:</label>
            <input type="month" name="expiry" required>

            <label for="cvv">CVV:</label>
            <input type="text" name="cvv" placeholder="123" required>

            <button type="submit" class="btn">Confirm Payment</button>
        </form>
    </div>

</body>
</html>

<?php include 'includes/footer.php'; ?>
