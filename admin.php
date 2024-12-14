<?php
session_start();
include 'database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'mayor') {
    header('Location: login.php');
    exit();
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    $query = "SELECT role FROM user WHERE id = $delete_id";
    $result = mysqli_query($connect, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user['role'] == 'mayor') {
        echo "<script>alert('Tidak dapat menghapus Mayor!');</script>";
    } else {
        $delete_query = "DELETE FROM user WHERE id = $delete_id";
        if (mysqli_query($connect, $delete_query)) {
            echo "<script>alert('Berhasil menghapus Villager!');</script>";
            header('Location: admin.php');
            exit();
        } else {
            echo "<script>alert('Gagal menghapus Villager');</script>";
        }
    }
}

$per_page = 7;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $per_page;

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'id';
$order = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'desc' : 'asc';

$allowed_filters = ['id', 'name', 'email'];
if (!in_array($filter, $allowed_filters)) {
    $filter = 'id';
}

if ($filter === 'name') {
    $query = "SELECT id, first_name, last_name, email, role FROM user ORDER BY CONCAT(first_name, ' ', last_name) $order LIMIT $start_from, $per_page";
} else {
    $query = "SELECT id, first_name, last_name, email, role FROM user ORDER BY $filter $order LIMIT $start_from, $per_page";
}

$result = mysqli_query($connect, $query);

$rows = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = [
        'id' => $row['id'],
        'name' => $row['first_name'] . ' ' . $row['last_name'],
        'email' => $row['email'],
        'role' => $row['role'],
    ];
}

$total_query = "SELECT COUNT(*) as total FROM user";
$total_result = mysqli_query($connect, $total_query);
$total_users = mysqli_fetch_assoc($total_result)['total'];
$total_pages = ceil($total_users / $per_page);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="styles/admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400..700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="admin-header">
            <h1>Administrator</h1>
        </div>
        <div class="filter-search">
            <div class="filter">
                <img src="assets/Filter.png" alt="filter">
                <select name="filter" id="filter">
                    <option disabled selected hidden>Filter</option>
                    <option value="id">ID</option>
                    <option value="name">Name</option>
                    <option value="email">Email</option>
                </select>
            </div>
            <div class="search">
                <img src="assets/search.png" alt="search">
                <input type="text" id="search-input" placeholder="Search">
            </div>
        </div>
        <div class="table-container">
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Action</th>
                </tr>   
                </thead>
                <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?>.</td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td>*****</td>
                        <td>
                            <?php if (!empty($row['name']) && !empty($row['email'])): ?>
                                <a href="javascript:void(0)" 
                                   class="delete-user" 
                                   data-id="<?= $row['id'] ?>" 
                                   data-name="<?= $row['name'] ?>" 
                                   data-role="<?= $row['role'] ?>">
                                   <img src="assets/trash.png" alt="delete">
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="nav-page">
            <button class="nav" <?= $page <= 1 ? 'disabled' : '' ?> onclick="window.location.href='admin.php?page=<?= $page - 1 ?>'">Prev</button>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <button class="nav num" onclick="window.location.href='admin.php?page=<?= $i ?>'"><?= $i ?></button>
            <?php endfor; ?>

            <button class="nav" <?= $page >= $total_pages ? 'disabled' : '' ?> onclick="window.location.href='admin.php?page=<?= $page + 1 ?>'">Next</button>
        </div>
    </div>
    <button class="back-btn" onclick="window.history.back();">BACK</button>

    <audio id="bgMusic" autoplay loop hidden>
        <source src="assets/StardewValley_OST1.mp3" type="audio/mp3">
    </audio>
    <script src="script/musik.js"></script>
    
    <script src="script/admin.js"></script>
</body>
</html>
