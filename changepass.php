<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['currentPass'];
    $new_password = $_POST['newPass'];
    $confirm_password = $_POST['confirmPass'];

    $sql = "SELECT password FROM user WHERE id = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $hashed_password);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if (!password_verify($current_password, $hashed_password)) {
        echo "<script>alert('Password lama salah!');</script>";
    } elseif ($new_password === $current_password) {
        echo "<script>alert('Password baru tidak boleh sama dengan password lama!');</script>";
    } elseif ($new_password !== $confirm_password) {
        echo "<script>alert('Password baru dan konfirmasi password tidak cocok!');</script>";
    } else {
        $new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        $update_sql = "UPDATE user SET password = ? WHERE id = ?";
        $update_stmt = mysqli_prepare($connect, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "si", $new_hashed_password, $user_id);

        if (mysqli_stmt_execute($update_stmt)) {
            echo "<script>alert('Password berhasil diubah!'); window.location.href = 'profil.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat mengubah password.');</script>";
        }

        mysqli_stmt_close($update_stmt);
    }
}

mysqli_close($connect);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="styles/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400..700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="form-container">
        <h1>Change Password</h1>
        <form action="" method="post">
            <div class="form-group">
            <label for="currentPass"><img src="assets/pass.png" alt="pass"></label>
            <input type="password" id="currentPass" name="currentPass" placeholder="Input your current password here" required>
            </div>
            <div class="form-group">
            <label for="newPass"><img src="assets/pass.png" alt="pass"></label>
            <input type="password" id="newPass" name="newPass" placeholder="Input your new password here" required>
            </div>
            <div class="form-group">
            <label for="confirmPass"><img src="assets/pass.png" alt="pass"></label>
            <input type="password" id="confirmPass" name="confirmPass" placeholder="Confirm your new password here" required>
            </div>
            <button type="submit" class="btn">Submit</button>
        </form>
    </div>
</body>
</html>