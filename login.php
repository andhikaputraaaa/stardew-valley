<?php
session_start();
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        echo "<script>alert('Email dan password harus diisi.');</script>";
    } else {
        $sql = "SELECT id, first_name, password FROM user WHERE email = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $id, $first_name, $hashed_password);
            mysqli_stmt_fetch($stmt);

            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $id;
                $_SESSION['user_name'] = $first_name;

                echo "<script>
                        alert('Login berhasil. Selamat datang, $first_name!');
                        window.location.href = 'dashboard.html';
                      </script>";
            } else {
                echo "<script>alert('Password salah.');</script>";
            }
        } else {
            echo "<script>alert('Email tidak ditemukan.');</script>";
        }

        mysqli_stmt_close($stmt);
    }
}

mysqli_close($connect);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="styles/login.css">
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
    <div class="form-container">
        <img src="assets\chicken.png" class="logo">
        <form action="" method="post">
            <div class="form-group">
            <label for="email"><span class="icon">👤</span></label>
            <input type="email" id="email" name="email" placeholder="Input your email here" autocomplete="off">
            </div>
            <div class="form-group">
            <label for="password"><span class="icon">🔒</span></label>
            <input type="password" id="password" name="password" placeholder="Input your password here" autocomplete="off">
            </div>
            <button type="submit" class="btn">Sign In</button>
        </form>
    </div>
</body>
</html>