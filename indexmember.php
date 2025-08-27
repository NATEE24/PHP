<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: login.php"); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .welcome-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
            padding: 40px;
            text-align: center;
            max-width: 500px;
            width: 100%;
            animation: fadeIn 1s ease-in-out;
            
        }

        .welcome-card h1 {
            color: #ff6b6b;
            font-weight: bold;
        }

        .welcome-card p {
            font-size: 1.2rem;
            color: #444;
        }

        .btn-logout {
            background: #ff6b6b;
            border: none;
            padding: 10px 20px;
            border-radius: 30px;
            color: white;
            font-size: 1rem;
            transition: 0.3s;
        }

        .btn-logout:hover {
            background: #e63946;
            transform: scale(1.05);
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(30px);}
            to {opacity: 1; transform: translateY(0);}
        }
    </style>
</head>

<body>
    <div class="welcome-card">
        <h1>ยินดีตอนรับสู่หน้าหลัก</h1>
        <p>
            สวัสดีคุณ <strong><?= htmlspecialchars($_SESSION['username']) ?></strong><br>
            ตำแหน่ง: <span class="text-primary"><?= htmlspecialchars($_SESSION['role']) ?></span>
        </p>
        <a href="Logout.php" class="btn btn-logout mt-3">ออกจากระบบ</a>
    </div>
</body>

</html>
