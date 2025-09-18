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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    product-card {
      border: 1;
      background: #fff;
    }

    .product-thumb {
      height: 180px;
      object-fit: cover;
      border-radius: .5rem;
    }

    .product-meta {
      font-size: .75rem;
      letter-spacing: .05em;
      color: #8a8f98;
      text-transform: uppercase;
    }

    .product-title {
      font-size: 1rem;
      margin: .25rem 0 .5rem;
      font-weight: 600;
      color: #222;
    }

    .price {
      font-weight: 700;
    }

    .rating i {
      color: #ffc107;
    }

    /* ดำวสที อง */
    .wishlist {
      color: #b9bfc6;
    }

    .wishlist:hover {
      color: #ff5b5b;
    }

    .badge-top-left {
      position: absolute;
      top: .5rem;
      left: .5rem;
      z-index: 2;
      border-radius: .375rem;
    }

    :root {
      --pink-50: #fff5f9;
      --pink-100: #ffeef5;
      --pink-200: #ffd9e8;
      --pink-300: #ffc2d1;
      --pink-400: #ff99b8;
      --pink-500: #f78fb3;
      --pink-700: #d63384;
      --rose-500: #e75480;
    }

    body {
      background:
        radial-gradient(24rem 24rem at 10% 10%, #ffe1ee 0%, transparent 60%),
        radial-gradient(28rem 28rem at 90% 0%, #f3d9ff 0%, transparent 55%),
        radial-gradient(20rem 20rem at 0% 90%, #ffd6e7 0%, transparent 55%),
        linear-gradient(180deg, var(--pink-100), #ffffff 45%, var(--pink-50));
      font-family: 'Kanit', sans-serif;
      min-height: 100vh;
    }

    /* แถบบน */
    .topbar {
      background: linear-gradient(90deg, #ffb7d5, #f6a6d7 40%, #e6b6ff);
      box-shadow: 0 8px 24px rgba(214, 51, 132, .25);
      border-bottom: 1px solid rgba(255, 255, 255, .4);
    }

    h1 {
      color: var(--pink-700);
      font-weight: 800;
    }

    /* ปุ่มโทนชมพู (คง class เดิมให้โค้ดด้านล่างใช้ได้เหมือนเดิม) */
    .btn {
      border-radius: 999px;
    }

    .btn-info {
      background-color: #f78fb3;
      border-color: #f78fb3;
    }

    .btn-info:hover {
      filter: brightness(1.05);
    }

    .btn-warning {
      background-color: #ffc2d1;
      border-color: #ffc2d1;
      color: #6a1b4d;
    }

    .btn-warning:hover {
      background-color: #ff99b8;
      border-color: #ff99b8;
      color: #fff;
    }

    .btn-secondary {
      background-color: #f5a6c5;
      border-color: #f5a6c5;
      color: #6a1b4d;
    }

    .btn-secondary:hover {
      background-color: #ef6aa8;
      border-color: #ef6aa8;
      color: #fff;
    }

    .btn-success {
      background: linear-gradient(90deg, var(--pink-500), var(--rose-500));
      border: none;
    }

    .btn-success:hover {
      filter: brightness(1.05);
    }

    .btn-primary {
      background-color: #ec407a;
      border-color: #ec407a;
    }

    .btn-outline-primary {
      color: #ec407a;
      border-color: #ec407a;
    }

    .btn-outline-primary:hover {
      background-color: #ec407a;
      color: #fff;
    }

    /* การ์ดสินค้า */
    .card {
      border: 0;
      border-radius: 18px;
      background: linear-gradient(180deg, #ffffff, #fff7fb);
      box-shadow: 0 12px 28px rgba(255, 153, 184, .18);
      transition: transform .18s ease, box-shadow .18s ease;
      height: 100%;
    }

    .card:hover {
      transform: translateY(-3px);
      box-shadow: 0 16px 40px rgba(214, 51, 132, .22);
    }

    .card-title {
      color: #d81b60;
      font-weight: 700;
    }

    .card-subtitle {
      color: #e91e63;
    }

    /* ตัดความยาวคำอธิบายให้สวยบนการ์ด */
    .card-text {
      color: #a23b6f;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
      min-height: 3.9em;
      /* ให้สูงพอสำหรับ 3 บรรทัด */
    }

    .price {
      font-weight: 800;
      color: #b02a6b;
      background: #fff0f6;
      border: 1px solid #ffe1ee;
      border-radius: 999px;
      padding: .25rem .6rem;
      display: inline-block;
    }

    .grid-gap {
      row-gap: 1.25rem;
    }
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
    <div class="row g-4">
      <?php foreach ($products as $p): ?>
        <?php
        // เตรียมรูป
        $img = !empty($p['image'])
          ? 'product_images/' . rawurlencode($p['image'])
          : 'product_images/no-image.jpg';
        // Badge: NEW ภายใน 7 วัน / HOT ถ้าสต็อกน้อยกว่า 5
        $isNew = isset($p['created_at']) && (time() - strtotime($p['created_at']) <= 7 * 24 * 3600);
        $isHot = (int) $p['stock'] > 0 && (int) $p['stock'] < 5;
        // ดาวรีวิว
        $rating = isset($p['rating']) ? (float) $p['rating'] : 4.5;
        $full = floor($rating);
        $half = ($rating - $full) >= 0.5 ? 1 : 0;
        ?>
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="card product-card h-100 position-relative">
            <!-- badge -->
            <?php if ($isNew): ?>
              <span class="badge bg-success badge-top-left">NEW</span>
            <?php elseif ($isHot): ?>
              <span class="badge bg-danger badge-top-left">HOT</span>
            <?php endif; ?>

            <!-- รูปสินค้า -->
            <a href="product_detail.php?id=<?= (int) $p['product_id'] ?>" class="p-3 d-block">
              <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($p['product_name']) ?>"
                class="img-fluid w-100 product-thumb">
            </a>

            <div class="px-3 pb-3 d-flex flex-column">
              <!-- หมวดหมู่ + ปุ่มหัวใจ -->
              <div class="d-flex justify-content-between align-items-center mb-1">
                <div class="product-meta"><?= htmlspecialchars($p['category_name'] ?? 'Category') ?></div>
                <button class="btn btn-link p-0 wishlist" title="Add to wishlist" type="button">
                  <i class="bi bi-heart"></i>
                </button>
              </div>

              <!-- ชื่อสินค้า -->
              <a class="text-decoration-none" href="product_detail.php?id=<?= (int) $p['product_id'] ?>">
                <div class="product-title"><?= htmlspecialchars($p['product_name']) ?></div>
              </a>

              <!-- ดาวรีวิว -->
              <div class="rating mb-2">
                <?php for ($i = 0; $i < $full; $i++): ?><i class="bi bi-star-fill"></i><?php endfor; ?>
                <?php if ($half): ?><i class="bi bi-star-half"></i><?php endif; ?>
                <?php for ($i = 0; $i < 5 - $full - $half; $i++): ?><i class="bi bi-star"></i><?php endfor; ?>
              </div>

              <!-- ราคา -->
              <div class="price mb-3">
                <?= number_format((float) $p['price'], 2) ?> บาท
              </div>

              <!-- ปุ่ม -->
              <div class="mt-auto d-flex gap-2">
                <?php if ($isLoggedIn): ?>
                  <form action="cart.php" method="post" class="d-inline-flex gap-2">
                    <input type="hidden" name="product_id" value="<?= (int) $p['product_id'] ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn btn-sm btn-success">เพิ่มในตะกร้า</button>
                  </form>
                <?php else: ?>
                  <small class="text-muted">เข้าสู่ระบบเพื่อสั่งซื้อ</small>
                <?php endif; ?>
                <a href="product_detail.php?id=<?= (int) $p['product_id'] ?>"
                  class="btn btn-sm btn-outline-primary ms-auto">
                  ดูรายละเอียด
                </a>
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