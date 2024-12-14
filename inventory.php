<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "SELECT name, image FROM hasil_mancing WHERE user_id = $user_id";
$result = mysqli_query($connect, $query);

if (!$result) {
    die("Error fetching inventory data: " . mysqli_error($connect));
}

$fish_inventory = [];
while ($row = mysqli_fetch_assoc($result)) {
    $fish_name = $row['name'];
    $fish_image = $row['image'];

    if (isset($fish_inventory[$fish_name])) {
        $fish_inventory[$fish_name]['count']++;
    } else {
        $fish_inventory[$fish_name] = [
            'name' => $fish_name,
            'image' => $fish_image,
            'count' => 1
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory UI</title>
    <link rel="stylesheet" href="styles/inventory.css">
</head>
<body>
    <div class="profile-icon">
        <img src="assets/chicken.png" alt="profile icon" onclick="pindah('profil.php')">
    </div>
    <div class="inventory-container">
        <div class="box"><img src="assets/box.png" alt=""></div>
        <button class="close-button" onclick="pindah('dashboard.php');">X</button>

        <?php
        $slot_count = 30;
        $fish_count = count($fish_inventory);
        $slot_index = 0;

        foreach ($fish_inventory as $fish) {
            if ($slot_index < $slot_count) {
                echo '<div class="inventory-slot">';
                echo '<img src="' . $fish['image'] . '" alt="' . $fish['name'] . '">';
                echo '<div class="item-count">' . $fish['count'] . '</div>';
                echo '</div>';
                $slot_index++;
            }
        }

        while ($slot_index < $slot_count) {
            echo '<div class="inventory-slot"></div>';
            $slot_index++;
        }
        ?>

    </div>

    <script src="script/fishing.js"></script>
</body>
</html>
