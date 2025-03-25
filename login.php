<?php
include("db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Check if the email exists in the database
    $sql = "SELECT id, email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user["password"])) {
            // Set session variables
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["email"] = $user["email"];

            // Redirect to homepage
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Invalid email or password!'); window.location.href='login.html';</script>";
            exit();
        }
    } else {
        // User not registered -> Redirect to registration page
        echo "<script>alert('No account found! Please register first.'); window.location.href='register.html';</script>";
        exit();
    }

    $stmt->close();
}
?>

