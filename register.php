<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["firstname"];
    $last_name = $_POST["lastname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_pass = $_POST["confirm_pass"];
    $gender = $_POST["avatar"];

    if ($password !== $confirm_pass) {
        echo "<script>alert('Password dan konfirmasi password tidak sama!');</script>";
    } else {
        $check_email_query = "SELECT email FROM user WHERE email = ?";
        $stmt = mysqli_prepare($connect, $check_email_query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            echo "<script>alert('Email sudah terdaftar. Silakan gunakan email lain.');</script>";
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO user (role, first_name, last_name, email, password, gender)
                    VALUES ('villager', ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($connect, $sql);
            mysqli_stmt_bind_param($stmt, "sssss", $first_name, $last_name, $email, $hashed_password, $gender);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>
                        alert('Pendaftaran berhasil.');
                        window.location.href = 'index.html';
                      </script>";
            } else {
                echo "<script>alert('Terjadi kesalahan: " . mysqli_error($connect) . "');</script>";
            }
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="styles/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400..700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="form-container">
        <form action="register.php" method="post">
            <div class="fullname">
                <div class="form-group"><input type="text" id="firstname" name="firstname" placeholder="First Name" autocomplete="off" maxlength="15" required></div>
                <div class="form-group"><input type="text" id="lastname" name="lastname" placeholder="Last Name" autocomplete="off" maxlength="15" required></div>
            </div>
            <div class="form-group">
                <label for="email"><img src="assets/user.png" alt="user"></label>
                <input type="email" id="email" name="email" placeholder="Input your email here" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label for="password"><img src="assets/pass.png" alt="pass"></label>
                <input type="password" id="password" name="password" placeholder="Input your password here" required>
            </div>
            <div class="form-group">
                <label for="confirm-pass"><img src="assets/pass.png" alt="pass"></label>
                <input type="password" id="confirm-pass" name="confirm_pass" placeholder="Confirm your password here" required>
            </div>
            <div class="form-group">
                <select id="avatar" name="avatar" required>
                    <option disabled selected>Choose your gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="">I prefer not to say</option>
                </select>
            </div>
            <button type="submit" class="btn">Sign Up</button>
        </form>
    </div>
</body>
</html>