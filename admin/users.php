<?php
session_start();
require_once '../config.php';
require_once 'auth_admin.php';

// ตรวจสอบสิทธิ์ admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// ลบสมาชิก
if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    // ป้องกันลบตัวเอง
    if ($user_id != $_SESSION['user_id']) {
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ? AND role = 'member'");
        $stmt->execute([$user_id]);
    }
    header("Location: users.php");
    exit;
}

// ดึงข้อมูลสมาชิก
$stmt = $conn->prepare("SELECT * FROM users WHERE role = 'member' ORDER BY created_at DESC");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการสมาชิก</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* === โทนชมพูอ่อนแบบเดิม แต่เพิ่มแค่นิดเดียว === */
        :root{
            --pink-50:#fff5f9; --pink-100:#ffeef5; --pink-300:#ffc2d1;
            --pink-400:#ff99b8; --pink-500:#f78fb3; --pink-700:#d63384;
        }
        body{ background: linear-gradient(180deg, var(--pink-100), #fff 45%, var(--pink-50)); }
        h2{ color: var(--pink-700); font-weight: 800; }
        .btn-secondary{ border:1px solid var(--pink-400); color:var(--pink-700); background:#fff; }
        .btn-secondary:hover{ background: var(--pink-100); border-color: var(--pink-500); color: var(--pink-700); }

        /* ปรับปุ่มแก้ไข/ลบให้เข้าธีม โดยยังใช้คลาสเดิมได้ */
        .btn-warning{ background-color:#ffc2d1; border-color:#ffc2d1; color:#6a1b4d; }
        .btn-warning:hover{ background-color:#ff99b8; border-color:#ff99b8; color:#fff; }
        .btn-danger{ background-color:#f78fb3; border-color:#f78fb3; }
        .btn-danger:hover{ background-color:#d63384; border-color:#d63384; }

        /* ตารางอ่านง่ายขึ้นเล็กน้อย */
        thead th{ background:#fff0f6; }
        .table{ border-color: #ffe1ee; }
        .table > :not(caption) > * > * { vertical-align: middle; }
        .page-wrap{ max-width: 1100px; }
    </style>
</head>

<body class="container mt-4 page-wrap">
    <h2 class="mb-3">จัดการสมาชิก</h2>
    <a href="index.php" class="btn btn-secondary mb-3">← กลับหน้าผู้ดูแล</a>

    <?php if (count($users) === 0): ?>
        <div class="alert alert-warning">ยังไม่มีสมาชิกในระบบ</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>ชื่อผู้ใช้</th>
                        <th>ชื่อ - นามสกุล</th>
                        <th>อีเมล</th>
                        <th>วันที่สมัคร</th>
                        <th style="width:160px">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['full_name'] ?? '') ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['created_at']) ?></td>
                            <td>
                                <a href="edit_user.php?id=<?= (int)$user['user_id'] ?>" class="btn btn-sm btn-warning">แก้ไข</a>
                                <a href="users.php?delete=<?= (int)$user['user_id'] ?>" class="btn btn-sm btn-danger"
                                   onclick="return confirm('คุณต้องการลบสมาชิกนี้หรือไม่?')">ลบ</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</body>
</html>
