<?php
session_start();
require_once 'config.php';

$isLoggedIn = isset($_SESSION['user_id']);

$stmt = $conn->query("SELECT p.*, c.category_name
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.category_id
    ORDER BY p.created_at DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>หน้าหลัก</title>
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root{
      --pink-50:#fff5f9; --pink-100:#ffeef5; --pink-200:#ffd9e8; --pink-300:#ffc2d1;
      --pink-400:#ff99b8; --pink-500:#f78fb3; --pink-700:#d63384; --rose-500:#e75480;
    }
    body{
      background:
        radial-gradient(24rem 24rem at 10% 10%, #ffe1ee 0%, transparent 60%),
        radial-gradient(28rem 28rem at 90% 0%, #f3d9ff 0%, transparent 55%),
        radial-gradient(20rem 20rem at 0% 90%, #ffd6e7 0%, transparent 55%),
        linear-gradient(180deg, var(--pink-100), #ffffff 45%, var(--pink-50));
      font-family: 'Kanit', sans-serif;
      min-height: 100vh;
    }
    /* แถบบน */
    .topbar{
      background: linear-gradient(90deg, #ffb7d5, #f6a6d7 40%, #e6b6ff);
      box-shadow: 0 8px 24px rgba(214,51,132,.25);
      border-bottom: 1px solid rgba(255,255,255,.4);
    }
    h1{ color: var(--pink-700); font-weight: 800; }

    /* ปุ่มโทนชมพู (คง class เดิมให้โค้ดด้านล่างใช้ได้เหมือนเดิม) */
    .btn{ border-radius: 999px; }
    .btn-info{ background-color:#f78fb3; border-color:#f78fb3; }
    .btn-info:hover{ filter:brightness(1.05); }
    .btn-warning{ background-color:#ffc2d1; border-color:#ffc2d1; color:#6a1b4d; }
    .btn-warning:hover{ background-color:#ff99b8; border-color:#ff99b8; color:#fff; }
    .btn-secondary{ background-color:#f5a6c5; border-color:#f5a6c5; color:#6a1b4d; }
    .btn-secondary:hover{ background-color:#ef6aa8; border-color:#ef6aa8; color:#fff; }
    .btn-success{ background: linear-gradient(90deg, var(--pink-500), var(--rose-500)); border:none; }
    .btn-success:hover{ filter:brightness(1.05); }
    .btn-primary{ background-color:#ec407a; border-color:#ec407a; }
    .btn-outline-primary{ color:#ec407a; border-color:#ec407a; }
    .btn-outline-primary:hover{ background-color:#ec407a; color:#fff; }

    /* การ์ดสินค้า */
    .card{
      border:0; border-radius:18px;
      background: linear-gradient(180deg,#ffffff,#fff7fb);
      box-shadow: 0 12px 28px rgba(255,153,184,.18);
      transition: transform .18s ease, box-shadow .18s ease;
      height: 100%;
    }
    .card:hover{ transform: translateY(-3px); box-shadow: 0 16px 40px rgba(214,51,132,.22); }
    .card-title{ color:#d81b60; font-weight:700; }
    .card-subtitle{ color:#e91e63; }

    /* ตัดความยาวคำอธิบายให้สวยบนการ์ด */
    .card-text{
      color:#a23b6f;
      display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden;
      min-height: 3.9em; /* ให้สูงพอสำหรับ 3 บรรทัด */
    }
    .price{
      font-weight:800; color:#b02a6b;
      background:#fff0f6; border:1px solid #ffe1ee; border-radius:999px; padding:.25rem .6rem;
      display:inline-block;
    }
    .grid-gap{ row-gap: 1.25rem; }
  </style>
</head>
<body>

  <!-- แถบด้านบน -->
  <nav class="topbar">
    <div class="container py-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
      <h1 class="m-0">รายการสินค้า</h1>
      <div class="d-flex flex-wrap align-items-center gap-2">
        <?php if ($isLoggedIn): ?>
          <span class="me-2 text-white fw-semibold d-none d-md-inline">
            ยินดีต้อนรับ, <?= htmlspecialchars($_SESSION['username']) ?>
            (<?= htmlspecialchars($_SESSION['role']) ?>)
          </span>
          <a href="profile.php" class="btn btn-info">ข้อมูลส่วนตัว</a>
          <a href="cart.php" class="btn btn-warning">ดูตะกร้า</a>
          <a href="logout.php" class="btn btn-secondary">ออกจากระบบ</a>
        <?php else: ?>
          <a href="login.php" class="btn btn-success">เข้าสู่ระบบ</a>
          <a href="register.php" class="btn btn-primary">สมัครสมาชิก</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <!-- เนื้อหา -->
  <main class="container my-4">
    <div class="row grid-gap">
      <?php foreach ($products as $product): ?>
        <div class="col-12 col-sm-6 col-lg-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-1"><?= htmlspecialchars($product['product_name']) ?></h5>
              <h6 class="card-subtitle mb-2"><?= htmlspecialchars($product['category_name']) ?></h6>

              <p class="card-text mb-2"><?= nl2br(htmlspecialchars($product['description'])) ?></p>

              <p class="mb-3">
                <span class="price">฿<?= number_format((float)$product['price'], 2) ?></span>
              </p>

              <div class="d-flex align-items-center justify-content-between">
                <?php if ($isLoggedIn): ?>
                  <form action="cart.php" method="post" class="m-0">
                    <input type="hidden" name="product_id" value="<?= (int)$product['product_id'] ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn btn-sm btn-success">เพิ่มในตะกร้า</button>
                  </form>
                <?php else: ?>
                  <small class="text-muted">เข้าสู่ระบบเพื่อสั่งซื้อ</small>
                <?php endif; ?>

                <a href="product_detail.php?id=<?= (int)$product['product_id'] ?>"
                   class="btn btn-sm btn-outline-primary">ดูรายละเอียด</a>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

      <?php if (!$products): ?>
        <div class="col-12">
          <div class="alert alert-warning">ยังไม่มีสินค้าในระบบ</div>
        </div>
      <?php endif; ?>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
