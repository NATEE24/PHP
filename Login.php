<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = trim($_POST['username_or_email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$usernameOrEmail, $usernameOrEmail]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header("Location: admin/index.php");
        } else {
            header("Location: indexmember.php");
        }
        exit();
    } else {
        $error = "ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง";
    }
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #ff9a9e 0%, #a1c4fd 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.15);
            padding: 40px;
            width: 100%;
            max-width: 450px;
            animation: fadeIn 0.9s ease-in-out;
        }

        .login-card h2 {
            background: linear-gradient(to right, #ff6bcb, #4a90e2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: bold;
            margin-bottom: 25px;
            text-align: center;
        }

        .form-label {
            font-weight: 600;
            color: #444;
        }

        .btn-login {
            background: linear-gradient(90deg, #ff6bcb, #4a90e2);
            border: none;
            border-radius: 30px;
            padding: 10px 20px;
            color: white;
            font-size: 1.1rem;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: linear-gradient(90deg, #ff3ca6, #357abd);
            transform: scale(1.05);
        }

        .btn-link {
            color: #ff6bcb;
            font-weight: 600;
            text-decoration: none;
        }

        .btn-link:hover {
            text-decoration: underline;
            color: #e6399b;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(30px);}
            to {opacity: 1; transform: translateY(0);}
        }
    </style>
</head>

<body>
    <div class="login-card">
        <h2>เข้าสู่ระบบ</h2>

        <?php if (isset($_GET['register']) && $_GET['register'] === 'success'): ?>
            <div class="alert alert-success">✅ สมัครสมาชิกสำเร็จ กรุณาเข้าสู่ระบบ</div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" class="row g-3">
            <div class="col-12">
                <label for="username_or_email" class="form-label">ชื่อผู้ใช้หรืออีเมล</label>
                <input type="text" name="username_or_email" id="username_or_email" class="form-control" required>
            </div>
            <div class="col-12">
                <label for="password" class="form-label">รหัสผ่าน</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="col-12 d-grid mt-3">
                <button type="submit" class="btn btn-login">เข้าสู่ระบบ</button>
            </div>
            <div class="col-12 text-center mt-2">
                <a href="register.php" class="btn-link">ยังไม่มีบัญชี? สมัครสมาชิก</a>
            </div>
        </form>
    </div>
</body>

</html>
