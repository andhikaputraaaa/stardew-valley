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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400..700&display=swap" rel="stylesheet">
</head>
<body>
    <nav>
        <ul>
            <div class="navbar-container">
            <li><a href="fishing.html">FISHING</a></li>
            <li><a href="inventory.html">INVENTORY</a></li>
            </div>
        </ul>
    </nav>

    <div class="profile-icon">
        <img src="assets/chicken.png" alt="profile icon" onclick="pindah('profil.php')">
    </div>

    <div class="welcome-message">
        <h1>HALO, <?php echo htmlspecialchars($user_name); ?>!</h1>
    </div>

<script src="script/fishing.js"></script>
</body>
</html>