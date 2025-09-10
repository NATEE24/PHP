<?php
session_start();
require_once 'config.php';

if (!isset($_GET['id'])) {
    header('Location: indexmember.php'); exit();
}
$isLoggedIn = isset($_SESSION['user_id']);

$product_id = $_GET['id'];

$stmt = $conn->prepare("SELECT p.*, c.category_name
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.category_id
    WHERE p.product_id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>รายละเอียดสินค้า</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root{
      --pink-50:#fff5f9; --pink-100:#ffeef5; --pink-200:#ffd9e8; --pink-300:#ffc2d1;
      --pink-400:#ff99b8; --pink-500:#f78fb3; --pink-700:#d63384; --rose-500:#e75480;
    }
    body{
      min-height:100vh;
      background:
        radial-gradient(24rem 24rem at 10% 10%, #ffe1ee 0%, transparent 60%),
        radial-gradient(28rem 28rem at 90% 0%, #f3d9ff 0%, transparent 55%),
        radial-gradient(20rem 20rem at 0% 90%, #ffd6e7 0%, transparent 55%),
        linear-gradient(180deg, var(--pink-100), #ffffff 45%, var(--pink-50));
    }
    .topbar{
      background: linear-gradient(90deg, #ffb7d5, #f6a6d7 40%, #e6b6ff);
      box-shadow: 0 8px 30px rgba(214,51,132,.25);
      border-bottom: 1px solid rgba(255,255,255,.35);
    }
    .card-soft{
      border:0; border-radius: 20px;
      background: linear-gradient(180deg,#ffffff,#fff7fb);
      box-shadow: 0 16px 40px rgba(255,153,184,.22);
    }
    .badge-soft{
      background: #fff0f6; color: var(--pink-700); border:1px solid #ffe1ee;
    }
    .price-tag{
      display:inline-flex; align-items:center; gap:.4rem;
      background: linear-gradient(90deg,var(--pink-500),var(--rose-500));
      color:#fff; padding:.45rem .75rem; border-radius:999px;
      box-shadow: 0 10px 24px rgba(247,143,179,.35);
      font-weight:700;
    }
    .btn-pink{
      background: linear-gradient(90deg,var(--pink-500),var(--rose-500));
      border:none; color:#fff; box-shadow:0 10px 22px rgba(214,51,132,.32);
    }
    .btn-pink:hover{ filter:brightness(1.05); }
    .btn-outline-pink{
      border:1px solid var(--pink-400); color:var(--pink-700); background:#fff;
    }
    .btn-outline-pink:hover{ background:var(--pink-100); border-color:var(--pink-700); color:var(--pink-700); }
    .qty-input{ max-width: 120px; }
  </style>
</head>

<body>
  <!-- Top bar -->
  <nav class="topbar navbar navbar-expand">
    <div class="container">
      <a href="indexmember.php" class="btn btn-outline-light">
        ← กลับหน้ารายการสินค้า
      </a>
      <span class="ms-auto text-white-50 small">รายละเอียดสินค้า</span>
    </div>
  </nav>

  <main class="container py-4 py-md-5">
    <?php if(!$product): ?>
      <div class="alert alert-warning">ไม่พบสินค้า</div>
      <a href="indexmember.php" class="btn btn-outline-pink mt-2">กลับหน้ารายการ</a>
    <?php else: ?>
      <div class="card card-soft p-3 p-md-4">
        <div class="card-body">
          <div class="d-flex flex-column flex-md-row gap-4">
            <!-- หากมีฟิลด์รูปภาพใน DB ค่อยเพิ่ม <img> ได้ -->
            <div class="flex-fill">
              <h3 class="mb-1"><?= htmlspecialchars($product['product_name']) ?></h3>
              <div class="mb-3">
                <span class="badge badge-soft rounded-pill">
                  <i class="bi bi-tags me-1"></i><?= htmlspecialchars($product['category_name'] ?? 'ทั่วไป') ?>
                </span>
              </div>

              <?php
                $price = isset($product['price']) ? number_format((float)$product['price'], 2) : '0.00';
                $stock = (int)($product['stock'] ?? 0);
              ?>
              <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                <span class="price-tag">
                  <i class="bi bi-cash-coin"></i> ฿<?= $price ?>
                </span>
                <?php if ($stock > 0): ?>
                  <span class="badge text-bg-success rounded-pill">คงเหลือ: <?= $stock ?></span>
                <?php else: ?>
                  <span class="badge text-bg-danger rounded-pill">สินค้าหมด</span>
                <?php endif; ?>
              </div>

              <div class="text-secondary mb-3" style="white-space:pre-line;">
                <?= nl2br(htmlspecialchars($product['description'] ?? '')) ?>
              </div>

              <?php if ($isLoggedIn): ?>
                <form action="cart.php" method="post" class="d-flex align-items-end gap-2 flex-wrap">
                  <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['product_id']) ?>">
                  <div>
                    <label for="quantity" class="form-label mb-1">จำนวน</label>
                    <input
                      type="number"
                      class="form-control qty-input"
                      name="quantity" id="quantity"
                      value="1" min="1" max="<?= max($stock,0) ?>"
                      <?= $stock <= 0 ? 'disabled' : '' ?> required>
                  </div>
                  <button type="submit" class="btn btn-pink"
                          <?= $stock <= 0 ? 'disabled' : '' ?>>
                    <i class="bi bi-bag-plus me-1"></i> เพิ่มในตะกร้า
                  </button>
                </form>
              <?php else: ?>
                <div class="alert alert-info mt-3 mb-0">
                  กรุณาเข้าสู่ระบบเพื่อสั่งซื้อ
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </main>
</body>
</html>
