<?php
session_start();
require_once 'config.php';

$isLoggedIn = isset($_SESSION['user_id']);

$stmt = $conn->query("SELECT p.*, c.category_name
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.category_id
    ORDER BY p.created_at DESC");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าหลัก</title>
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f1f9;
            font-family: 'Kanit', sans-serif;
        }

        h1 {
            color: #e91e63;
            /* สีชมพูเข้ม */
        }

        .btn {
            border-radius: 25px;
        }

        /* ปรับปุ่มให้ใช้สีชมพู */
        .btn-info {
            background-color: #f06292;
            /* สีชมพูอ่อน */
            border-color: #f06292;
        }

        .btn-warning {
            background-color: #f48fb1;
            /* สีชมพูปนส้ม */
            border-color: #f48fb1;
        }

        .btn-secondary {
            background-color: #e57373;
            /* สีชมพูแดง */
            border-color: #e57373;
        }

        .btn-success {
            background-color: #f50057;
            /* สีชมพูเข้ม */
            border-color: #f50057;
        }

        .btn-primary {
            background-color: #ec407a;
            /* สีชมพูสด */
            border-color: #ec407a;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-outline-primary {
            color: #ec407a;
            border-color: #ec407a;
        }

        .btn-outline-primary:hover {
            background-color: #ec407a;
            color: white;
        }

        .card-title {
            color: #d81b60;
            /* สีชมพูเข้ม */
        }

        .card-subtitle {
            color: #e91e63;
            /* สีชมพูอ่อน */
        }

        .card-text {
            color: #c2185b;
            /* สีชมพูเข้ม */
        }
    </style>
</head>

<body class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>รายการสินค้า</h1>
        <div>
            <?php if ($isLoggedIn): ?>
                <span class="me-3">ยินดีต้อนรับ, <?= htmlspecialchars($_SESSION['username']) ?>
                    (<?= htmlspecialchars($_SESSION['role']) ?>)</span>
                <a href="profile.php" class="btn btn-info">ข้อมูลส่วนตัว</a>
                <a href="cart.php" class="btn btn-warning">ดูตะกร้า</a>
                <a href="logout.php" class="btn btn-secondary">ออกจากระบบ</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-success">เข้าสู่ระบบ</a>
                <a href="register.php" class="btn btn-primary">สมัครสมาชิก</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- รายการแสดงสินค้า -->
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product['product_name']) ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($product['category_name']) ?></h6>
                        <p class="card-text"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                        <p><strong>ราคา:</strong> <?= number_format($product['price'], 2) ?> บาท</p>

                        <?php if ($isLoggedIn): ?>
                            <form action="cart.php" method="post" class="d-inline">
                                <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-sm btn-success">เพิ่มในตะกร้า</button>
                            </form>
                        <?php else: ?>
                            <small class="text-muted">เข้าสู่ระบบเพื่อสั่งซื้อ</small>
                        <?php endif; ?>
                        <a href="product_detail.php?id=<?= $product['product_id'] ?>"
                            class="btn btn-sm btn-outline-primary float-end">ดูรายละเอียด</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>