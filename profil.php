<?php
session_start();
include 'database.php'; // Menghubungkan ke database

if (!isset($_SESSION['user_id'])) {
    // Redirect ke halaman login jika belum login
    header("Location: login.php");
    exit();
}

// Ambil data dari session
$user_id = $_SESSION['user_id'];

// Query untuk mendapatkan data user dari database
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
    <style>
        body {
            background-image: url('assets/background-index.jpg');
        }
    </style>
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
                <p><?php echo htmlspecialchars($email); ?></p>
                <a href="#">change password</a>
            </div>
        <div class="role">
            <p>Role: 
                <div class="box"><span><?php echo htmlspecialchars($role); ?></span></div>
            </p>
        </div>
        </div>
        <!-- <button class="btn">LOG OUT</button> -->
    </div>
    <button class="back-btn" onclick="window.history.back();">BACK</button>
</body>
</html>