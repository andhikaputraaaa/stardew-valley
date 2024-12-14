<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT CONCAT(first_name, ' ', last_name) AS full_name, email, role FROM user WHERE id = ?";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $full_name, $email, $role);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

mysqli_close($connect);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="styles/profil.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400..700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <h1>Profile!</h1>
        </div>
        <div class="profile-content">
            <div class="avatar">
                <img src="assets/chicken.png" alt="Avatar">
                <p class="box"><?php echo htmlspecialchars($full_name); ?></p>
            </div>
            <div class="user-info">
                <div class="box"><h2>Account</h2></div>
                <p><?php echo htmlspecialchars($full_name) ?></p>
                <p><?php echo htmlspecialchars($email); ?></p>
                <a href="changepass.php">change password</a>
            </div>
        <div class="role">
            <p>Role: 
                <div class="box"><span><?php echo htmlspecialchars($role); ?></span></div>
            </p>
        </div>
        <form action="logout.php" method="POST" style="display: inline;">
            <button type="submit" class="logout-btn">LOG OUT</button>
        </form>
        </div>
        <!-- <button class="btn">LOG OUT</button> -->
    </div>
    <button class="back-btn" onclick="pindah('dashboard.php');">BACK</button>

    <audio id="bgMusic" autoplay loop hidden>
        <source src="assets/StardewValley_OST2.mp3" type="audio/mp3">
    </audio>
    <script src="script/musik.js"></script>

    <script src="script/fishing.js"></script>
</body>
</html>