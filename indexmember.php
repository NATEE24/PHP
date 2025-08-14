<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">

</head>

<body>
    <h1>WELCOME CAMBODIA</h1>
    <p>ผู้ใช้ <?= htmlspecialchars($_SESSION['username']) ?>(<?= $_SESSION['role'] ?>)
    </p>
    <a href="Logout.php" class="btn btn-secondary">ออกจากระบบ</a>
</body>

</html>