<?php
session_start();
$conn = new mysqli("localhost", "root", "", "tikshow");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $genre = trim($_POST['genre']);
    $duration = intval($_POST['duration']);
    $showtime = $_POST['showtime'];
    
    if (!empty($_FILES["poster"]["name"])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_name = basename($_FILES["poster"]["name"]);
        $target_file = $target_dir . $file_name;
        $allowed_types = ["jpg", "jpeg", "png", "gif"];
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        if (in_array($imageFileType, $allowed_types) && move_uploaded_file($_FILES["poster"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO movies (title, genre, duration, showtime, poster) VALUES (?, ?, ?, ?, ?)");
            
            if ($stmt === false) {
                die("Prepare failed: " . $conn->error);
            }
            
            $stmt->bind_param("ssiss", $title, $genre, $duration, $showtime, $file_name);
            if ($stmt->execute()) {
                header("Location: index.php");
                exit();
            } else {
                echo "Execute failed: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "File upload failed or invalid file type.";
        }
    } else {
        echo "No file uploaded.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Movie</title>
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
    <h2>Add Movie</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Movie Title" required><br>
        <input type="text" name="genre" placeholder="Genre" required><br>
        <input type="number" name="duration" placeholder="Duration (min)" required><br>
        <input type="datetime-local" name="showtime" required><br>
        <input type="file" name="poster" accept="image/*" required><br>
        <button type="submit">Add Movie</button>
    </form>
</body>
</html>
