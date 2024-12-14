<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles/dashboard.css">
</head>
<body>
    <nav>
        <ul>
            <div class="navbar-container">
            <li><a href="fishing.php">FISHING</a></li>
            <li><a href="inventory.php">INVENTORY</a></li>
            </div>
        </ul>
    </nav>

    <div class="profile-icon">
        <img src="assets/chicken.png" alt="profile icon" onclick="pindah('profil.php')">
    </div>

    <div class="welcome-message">
        <h1>HALO, <?php echo htmlspecialchars($user_name); ?>!</h1>
    </div>

    <audio id="bgMusic" autoplay loop hidden>
        <source src="assets/StardewValley_OST2.mp3" type="audio/mp3">
    </audio>
    <script src="script/musik.js"></script>

<script src="script/fishing.js"></script>
</body>
</html>