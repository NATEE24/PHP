<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับข้อมูลจากฟอร์ม
    $usernameOrEmail = trim($_POST['username_or_email']);
    $password = $_POST['password'];

    // ตรวจสอบข้อมูลในฐานข้อมูล
    $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$usernameOrEmail, $usernameOrEmail]);  // ใช้ $usernameOrEmail แทน $email
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

        // <!-- STEP 08 -->
        // เขำ้สรู่ ะบบส ำเร็จ
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // ถ้าเป็นผู้ดูแลระบบ
        if ($user['role'] === 'admin') {
            header("Location: admin/index.php");
        } else {
            header("Location: indexmember.php");
        }
        exit();
    } else {
        $error = "ชื่อผู้ใช่หรือรหัสผ่านไม่ถูกต้อง";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
</head>

<body>

    <!-- STEP 12 -->
    <?php if (isset($_GET['register']) && $_GET['register'] === 'success'): ?>
        <div class="alert alert-success">สมัครสมาชิฟสำเร็จ กรุณาเข้าสู่ระบบ</div>
    <?php endif; ?>

    <!-- STEP 13 -->
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="container mt-5">
        <form method="post" class="row g-3">
            <div class="col-md-6">
                <label for="username_or_email" class="form-label">ชื่อผู้ใช้หรืออีเมล</label>
                <input type="text" name="username_or_email" id="username_or_email" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="password" class="form-label">รหัสผ่าน</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-success">เข้าสู่ระบบ</button>
                <a href="register.php" class="btn btn-link">สมัครสมาชิก</a>
            </div>
        </form>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger mt-3">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>