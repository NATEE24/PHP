<?php
session_start();
require '../config.php';
require 'auth_admin.php';

// ตรวจสอบว่ามีการส่ง product_id หรือไม่
if (!isset($_GET['product_id'])) {
    header("Location: products.php");
    exit;
}

$product_id = intval($_GET['product_id']);

// ดึงข้อมูลสินค้าจากฐานข้อมูล
$stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// ถ้าไม่พบข้อมูลสินค้าจะแสดงข้อความ
if (!$product) {
    echo "<h3>ไม่พบข้อมูลสินค้าดังกล่าว</h3>";
    exit;
}

// ดึงข้อมูลหมวดหมู่ทั้งหมด
$categories = $conn->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);

// เมื่อลงมือส่งฟอร์ม
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['product_name']);
    $description = trim($_POST['description']);
    $price = (float) $_POST['price'];
    $stock = (int) $_POST['stock'];
    $category_id = (int) $_POST['category_id'];

    // ค่ารูปเดิมจากฟอร์ม
    $oldImage = $_POST['old_image'] ?? null;
    $removeImage = isset($_POST['remove_image']); // true/false

    if ($name && $price > 0) {
        // เตรียมตัวแปรรูปที่จะบันทึก
        $newImageName = $oldImage; // default: คงรูปเดิมไว้

        // 1) ถ้ามีติ๊ก "ลบรูปเดิม" → ตั้งให้เป็น null
        if ($removeImage) {
            $newImageName = null;
        }

        // 2) ถ้ามีอัปโหลดไฟล์ใหม่ → ตรวจแล้วเซฟไฟล์และตั้งชื่อใหม่ทับค่า
        if (!empty($_FILES['product_image']['name'])) {
            $file = $_FILES['product_image'];
            // ตรวจชนิดไฟล์แบบง่าย (แนะนำ: ตรวจ MIME จริงด้วย finfo)
            $allowed = ['image/jpeg', 'image/png'];
            if (in_array($file['type'], $allowed, true) && $file['error'] === UPLOAD_ERR_OK) {
                // สร้างชื่อไฟล์ใหม่
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $newImageName = 'product_' . time() . '.' . $ext;
                $uploadDir = realpath(__DIR__ . '/../product_images');
                $destPath = $uploadDir . DIRECTORY_SEPARATOR . $newImageName;

                // ย้ายไฟล์อัปโหลด
                if (!move_uploaded_file($file['tmp_name'], $destPath)) {
                    // ถ้าย้ายไม่ได้ คงใช้รูปเดิมไว้
                    $newImageName = $oldImage;
                }
            }
        }

        // อัปเดต DB
        $sql = "UPDATE products
                SET product_name = ?, description = ?, price = ?, stock = ?, category_id = ?, image = ?
                WHERE product_id = ?";
        $args = [$name, $description, $price, $stock, $category_id, $newImageName, $product_id];
        $stmt = $conn->prepare($sql);
        $stmt->execute($args);

        // ลบไฟล์เก่าในดิสก์ ถ้า:
        // - มีรูปเดิม ($oldImage) และ
        // - เกิดการเปลี่ยนรูป (อัปโหลดใหม่หรือสั่งลบรูปเดิม)
        if (!empty($oldImage) && $oldImage !== $newImageName) {
            $baseDir = realpath(__DIR__ . '/../product_images');
            $filePath = realpath($baseDir . DIRECTORY_SEPARATOR . $oldImage);
            if ($filePath && strpos($filePath, $baseDir) === 0 && is_file($filePath)) {
                @unlink($filePath);
            }
        }

        header("Location: products.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขสินค้า</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ฟอนต์ไทยนุ่ม ๆ -->
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Soft Pink Theme Overrides -->
    <style>
      :root{
        /* โทนชมพูอ่อน */
        --pink-50:  #fff1f5;
        --pink-100: #ffe4ec;
        --pink-200: #ffd6e5;
        --pink-300: #ffc2d8;
        --pink-400: #ff9ec3;
        --pink-500: #f48fb1; /* accent หลัก */
        --pink-600: #ec6f9e; /* hover/active */
        --ink-900:  #3a2a33; /* สีตัวอักษรเข้มอ่านง่าย */
      }

      html, body{
        height:100%;
      }
      body{
        font-family: "Kanit", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif;
        color: var(--ink-900);
        /* พื้นหลังไล่เฉดชมพูอ่อน + ลายจุดนุ่ม ๆ */
        background:
          radial-gradient(1200px 600px at 10% -10%, var(--pink-100) 0%, transparent 60%),
          radial-gradient(900px 500px at 110% 10%, var(--pink-200) 0%, transparent 60%),
          radial-gradient(800px 500px at 50% 120%, var(--pink-100) 0%, transparent 60%),
          linear-gradient(180deg, #fff, var(--pink-50));
      }

      .page-wrap{
        max-width: 980px;
        margin: 32px auto 64px;
        padding: 0 16px;
      }

      /* การ์ดแบบ Glass นิด ๆ */
      .card-soft{
        background: rgba(255,255,255,.8);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        border: 1px solid rgba(255, 192, 203, .45);
        box-shadow:
          0 6px 18px rgba(244, 143, 177, .18),
          0 2px 6px rgba(0,0,0,.04);
        border-radius: 22px;
      }

      h2.page-title{
        color: var(--ink-900);
        font-weight: 600;
        letter-spacing: .2px;
        margin-bottom: 14px;
      }

      /* ปุ่มหลักชมพูอ่อน */
      .btn-primary{
        --bs-btn-bg: var(--pink-500);
        --bs-btn-border-color: var(--pink-500);
        --bs-btn-hover-bg: var(--pink-600);
        --bs-btn-hover-border-color: var(--pink-600);
        --bs-btn-active-bg: var(--pink-600);
        --bs-btn-active-border-color: var(--pink-600);
        --bs-btn-disabled-bg: var(--pink-300);
        --bs-btn-disabled-border-color: var(--pink-300);
        border-radius: 14px;
        padding: 10px 16px;
      }

      /* ปุ่มรองโทนอ่อน ขอบชมพู */
      .btn-outline-pink{
        color: var(--ink-900);
        background: #fff;
        border: 1px solid var(--pink-300);
        border-radius: 12px;
      }
      .btn-outline-pink:hover{
        background: var(--pink-100);
        border-color: var(--pink-400);
        color: var(--ink-900);
      }

      /* ฟอร์ม: ขอบ/โฟกัสชมพูอ่อน */
      .form-label{
        color: var(--ink-900);
        font-weight: 500;
      }
      .form-control, .form-select{
        border-radius: 12px;
        border: 1px solid rgba(244, 143, 177, .35);
        background-color: rgba(255,255,255,.9);
      }
      .form-control:focus, .form-select:focus{
        border-color: var(--pink-500);
        box-shadow: 0 0 0 .2rem rgba(244, 143, 177, .22);
      }

      /* กล่องพรีวิวรูป */
      .image-wrap{
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: linear-gradient(180deg, #fff, var(--pink-50));
        border: 1px dashed var(--pink-300);
        padding: 10px 12px;
        border-radius: 14px;
      }
      .image-wrap .placeholder{
        color: #a05f78;
      }
      .thumb{
        width: 120px; height: 120px; object-fit: cover; border-radius: 14px;
        border: 1px solid rgba(244,143,177,.35);
      }

      /* แถบหัวข้อ */
      .topbar{
        display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:18px;
      }

      .badge-soft{
        display:inline-block;
        font-size:.9rem;
        padding:4px 10px;
        background: var(--pink-100);
        border: 1px solid var(--pink-300);
        border-radius: 999px;
        color: var(--ink-900);
      }
    </style>
</head>

<body>
  <div class="page-wrap">
    <div class="topbar">
      <h2 class="page-title">แก้ไขสินค้า</h2>
      <a href="products.php" class="btn btn-outline-pink">← กลับไปยังรายการสินค้า</a>
    </div>

    <div class="card-soft p-4 p-md-5">
      <div class="mb-3">
        <span class="badge-soft">โทนชมพูอ่อน • ใช้งานง่าย สบายตา</span>
      </div>

      <form method="post" enctype="multipart/form-data" class="row g-3">
        <div class="col-md-6">
          <label class="form-label">ชื่อสินค้า</label>
          <input type="text" name="product_name" class="form-control"
                 value="<?= htmlspecialchars($product['product_name']) ?>" required>
        </div>

        <div class="col-md-3">
          <label class="form-label">ราคาสินค้า</label>
          <input type="number" step="0.01" name="price" class="form-control"
                 value="<?= $product['price'] ?>" required>
        </div>

        <div class="col-md-3">
          <label class="form-label">จำนวนในคลัง</label>
          <input type="number" name="stock" class="form-control"
                 value="<?= $product['stock'] ?>" required>
        </div>

        <div class="col-md-6">
          <label class="form-label">หมวดหมู่</label>
          <select name="category_id" class="form-select" required>
            <?php foreach ($categories as $cat): ?>
              <option value="<?= $cat['category_id'] ?>" <?= $cat['category_id'] == $product['category_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['category_name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-12">
          <label class="form-label">รายละเอียดสินค้า</label>
          <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($product['description']) ?></textarea>
        </div>

        <!-- แสดงรูปเดิม + เก็บค่าเก่า -->
        <div class="col-md-6">
          <label class="form-label d-block">รูปปัจจุบัน</label>
          <div class="image-wrap">
            <?php if (!empty($product['image'])): ?>
              <img src="../product_images/<?= htmlspecialchars($product['image']) ?>" class="thumb" alt="รูปสินค้า">
            <?php else: ?>
              <span class="placeholder">ไม่มีรูป</span>
            <?php endif; ?>
          </div>
          <input type="hidden" name="old_image" value="<?= htmlspecialchars($product['image']) ?>">
        </div>

        <!-- อัปโหลดรูปใหม่ (ทางเลือก) -->
        <div class="col-md-6">
          <label class="form-label">อัปโหลดรูปใหม่ (jpg, png)</label>
          <input type="file" name="product_image" class="form-control">
          <div class="form-check mt-2">
            <input class="form-check-input" type="checkbox" name="remove_image" id="remove_image" value="1">
            <label class="form-check-label" for="remove_image">ลบรูปเดิม</label>
          </div>
        </div>

        <div class="col-12">
          <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
        </div>
      </form>
    </div>
  </div>

  <!-- (ถ้าต้องใช้ JS ของ Bootstrap) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
