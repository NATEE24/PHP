<?php
require_once 'config.php';

$error = []; // ตัวแปรเก็บตัว error

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $fname = trim($_POST['fname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if (empty($username) || empty($fname) || empty($email) || empty($password) || empty($cpassword)) {
        $error[] = "กรุณากรอกข้อมูลให้ครบทุกช่อง";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "อีเมลไม่ถูกต้อง";
    } elseif ($password !== $cpassword) {
        $error[] = "รหัสผ่านไม่ตรงกัน";
    } else {
        // ตรวจสอบว่าชื่อผู้ใช้หรืออีเมลถูกใช้ไปแล้วหรือไม่
        $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username, $email]);
        if ($stmt->rowCount() > 0) {
            $error[] = "ชื่อผู้ใช้หรืออีเมลนี้ถูกใช้ไปแล้ว";
        }
    }

    if (empty($error)) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(username, full_name, email, password, role) VALUES (?, ?, ?, ?, 'member')";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username, $fname, $email, $hashedPassword]);

        // ถ้าบันทึกสำเร็จให้เปลี่ยนเส้นทางไปหน้า login
        header("Location: Login.php?register=success");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300;400;500;600&display=swap" rel="stylesheet">
    <title>สมัครสมาชิก</title>
</head>

<style>
    body {
        background: linear-gradient(to bottom right, #a2d2ff, #ffc8dd, #bde0fe);
        font-family: 'Prompt', sans-serif;
        color: #333;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .container {
        background-color: #ffffffcc;
        border-radius: 20px;
        padding: 35px;
        max-width: 500px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        backdrop-filter: blur(6px);
        animation: fadeIn 0.7s ease-in-out;
    }

    h2 {
        text-align: center;
        margin-bottom: 25px;
        color: #0077b6;
        font-weight: 600;
    }

    label {
        color: #444;
        font-weight: 500;
    }

    .form-control {
        border-radius: 12px;
        border: 1px solid #ccc;
        padding: 10px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #ff80ab;
        box-shadow: 0 0 8px rgba(255, 128, 171, 0.4);
    }

    .btn-primary {
        background-color: #ff80ab;
        border-color: #ff80ab;
        font-weight: 500;
        border-radius: 30px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #f5598f;
        border-color: #f5598f;
        transform: scale(1.05);
    }

    a.btn-link {
        color: #0077b6;
        font-weight: 500;
    }

    a.btn-link:hover {
        text-decoration: underline;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<body>

    <div class="container">
        <h2>สมัครสมาชิก</h2>

        <?php if (!empty($error)): // ถ้าหากมีข้อผิดพลาด ให้แสดงข้อความ ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($error as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <div>
                <label for="username" class="form-label">ชื่อผู้ใช้</label>
                <input type="text" name="username" class="form-control" id="username" placeholder="กรอกชื่อผู้ใช้"
                    value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" required>
            </div>

            <div>
                <label for="fname" class="form-label">ชื่อ - นามสกุล</label>
                <input type="text" name="fname" class="form-control" id="fname" placeholder="กรอกชื่อ-นามสกุล"
                    value="<?= isset($_POST['fname']) ? htmlspecialchars($_POST['fname']) : '' ?>" required>
            </div>

            <div>
                <label for="email" class="form-label">อีเมล</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="กรอกอีเมล"
                    value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>
            </div>

            <div>
                <label for="password" class="form-label">รหัสผ่าน</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="กรอกรหัสผ่าน">
            </div>

            <div>
                <label for="cpassword" class="form-label">ยืนยันรหัสผ่าน</label>
                <input type="password" name="cpassword" class="form-control" id="cpassword"
                    placeholder="ยืนยันรหัสผ่าน">
            </div>

            <div class="mt-3 text-center">
                <button type="submit" class="btn btn-primary px-4">สมัครสมาชิก</button>
                <a href="Login.php" class="btn btn-link">เข้าสู่ระบบ</a>
            </div>
        </form>
    </div>

    <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>