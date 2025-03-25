<?php
// header.php
?>
<header>
    <div class="logo">
        <a href="index.php"><img src="assets/images/logo.png" alt="TikShow Logo"></a>
    </div>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="movies.php">Movies</a></li>
            <li><a href="register.html">Register</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
</header>

<style>
    /* General Header Styling */
    header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 50px;
        background: rgba(0, 0, 0, 0.8); /* Dark semi-transparent background */
        color: white;
        position: fixed;
        width: 100%;
        top: 0;
        left: 0;
        z-index: 1000;
        box-shadow: 0 4px 8px rgba(255, 255, 255, 0.1);
    }

    /* Logo */
    .logo img {
        width: 150px; /* Adjust logo size */
        height: auto;
    }

    /* Navigation Menu */
    nav ul {
        list-style: none;
        display: flex;
        gap: 20px; /* Space between links */
        margin: 0;
        padding: 0;
    }

    nav ul li {
        display: inline-block; /* Ensures they stay in one line */
    }

    nav ul li a {
        text-decoration: none;
        color: white;
        font-size: 18px;
        font-weight: 600;
        padding: 10px 15px;
        transition: 0.3s ease;
    }

    /* Hover Effects */
    nav ul li a:hover {
        background: #ffcc00;
        color: black;
        border-radius: 5px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        header {
            flex-direction: column;
            text-align: center;
        }

        nav ul {
            flex-direction: column;
            gap: 10px;
        }
    }
</style>
