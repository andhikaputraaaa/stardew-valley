<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fish_name']) && isset($_POST['fish_image'])) {
    $fish_name = mysqli_real_escape_string($connect, $_POST['fish_name']);
    $fish_image = mysqli_real_escape_string($connect, $_POST['fish_image']);

    $query = "INSERT INTO hasil_mancing (name, image, user_id) VALUES ('$fish_name', '$fish_image', $user_id)";
    mysqli_query($connect, $query);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fishing</title>
    <link rel="stylesheet" href="styles/fishing.css">
</head>
<body>
    <div class="profile-icon">
        <img src="assets/chicken.png" alt="profile icon" onclick="pindah('profil.php')">
    </div>
    <div id="game-container">
        <h1>Fishing Mini Game</h1>
        <div id="fishing-area">
            <div id="fish"><img src="assets/Sardine.png" alt=""></div>
            <div id="bar"></div>
        </div>
        <div id="controls">
            <button id="up-button" class="btn">Move Up</button>
            <button id="down-button" class="btn">Move Down</button>
            <button id="start-button" class="btn">Start Fishing</button>
            <p id="progress">Ayo Memancing!</p>
        </div>
        <p id="message" class="message"></p>
    </div>
    <button class="back-btn" onclick="pindah('dashboard.php');">BACK</button>

    <form id="fish-form" method="POST" style="display: none;">
        <input type="hidden" name="fish_name" id="fish-name">
        <input type="hidden" name="fish_image" id="fish-image">
    </form>

    <script src="script/fishing.js"></script>

    <audio id="bgMusic" autoplay loop hidden>
        <source src="assets/StardewValley_OST3.mp3" type="audio/mp3">
    </audio>
    <script src="script/musik.js"></script>
</body>
</html>
