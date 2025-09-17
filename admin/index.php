<?php
session_start();
require_once '../config.php';

// ตรวจสอบสิทธิ์ admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
$username = htmlspecialchars($_SESSION['username'] ?? 'ผู้ดูแลระบบ');
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <title>แผงควบคุมผู้ดูแลระบบ</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons (สำหรับไอคอน) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    :root{
      --pink-50:#fff5f9; --pink-100:#ffeef5; --pink-200:#ffd9e8; --pink-300:#ffc2d1;
      --pink-400:#ff99b8; --pink-500:#f78fb3; --pink-600:#ef6aa8; --pink-700:#d63384;
      --rose-500:#e75480; --lav-500:#c084fc;
    }
    /* พื้นหลังพาสเทล + ลายจุด */
    body{
      min-height:100vh;
      background:
        radial-gradient(24rem 24rem at 10% 10%, #ffe1ee 0%, transparent 60%),
        radial-gradient(28rem 28rem at 90% 0%, #f3d9ff 0%, transparent 55%),
        radial-gradient(20rem 20rem at 0% 90%, #ffd6e7 0%, transparent 55%),
        linear-gradient(180deg, var(--pink-100), #ffffff 45%, var(--pink-50));
      position:relative;
    }
    /* แถบบาร์บน ไล่เฉด+กระจก */
    .topbar{
      background: linear-gradient(90deg, #ffb7d5, #f6a6d7 40%, #e6b6ff);
      box-shadow: 0 8px 30px rgba(214,51,132,.25);
      border-bottom: 1px solid rgba(255,255,255,.35);
    }
    .glass{
      backdrop-filter: blur(8px);
      background: rgba(255,255,255,.45);
      border: 1px solid rgba(255,255,255,.6);
      box-shadow: 0 10px 30px rgba(214,51,132,.15);
    }
    /* การ์ดเมนู */
    .menu-card{
      border: 0;
      border-radius: 18px;
      transition: transform .2s ease, box-shadow .2s ease;
      background: linear-gradient(180deg, #fff, #fff7fb);
      box-shadow: 0 12px 30px rgba(255,153,184,.18);
    }
    .menu-card:hover{
      transform: translateY(-4px);
      box-shadow: 0 18px 40px rgba(214,51,132,.22);
    }
    .menu-icon{
      width: 56px; height:56px; border-radius:14px;
      display:flex; align-items:center; justify-content:center;
      background: linear-gradient(135deg, #ffd3e6, #ffe6f1);
      color: var(--pink-700); font-size: 1.5rem;
      box-shadow: inset 0 1px 0 #fff, 0 8px 20px rgba(214,51,132,.12);
    }
    .btn-pink{
      background: linear-gradient(90deg, var(--pink-500), var(--rose-500));
      border: none; color:#fff;
      box-shadow: 0 10px 24px rgba(247,143,179,.35);
    }
    .btn-pink:hover{
      filter: brightness(1.05);
      box-shadow: 0 14px 28px rgba(214,51,132,.35);
    }
    .btn-outline-pink{
      border:1px solid var(--pink-400); color:var(--pink-700); background:#fff;
    }
    .btn-outline-pink:hover{
      background: var(--pink-100);
      border-color: var(--pink-600);
      color: var(--pink-700);
    }
    .section-title{
      color: var(--pink-700);
      font-weight: 800;
      letter-spacing:.2px;
    }
    .subtitle{
      color:#9e3b6a;
    }
    /* ชิปต้อนรับ */
    .hello-chip{
      display:inline-flex; gap:.5rem; align-items:center;
      padding:.45rem .8rem; border-radius:999px;
      background: rgba(255,255,255,.7); border:1px solid rgba(255,255,255,.9);
      box-shadow: 0 6px 18px rgba(214,51,132,.15);
      color:#b02a6b;
    }
    /* ฟุตเตอร์จาง ๆ */
    .soft-footer{
      color:#a15780;
    }

    /* ปรับ spacing บนมือถือ */
    @media (max-width: 575.98px){
      .menu-grid{ row-gap: .75rem; }
      .menu-card .card-body{ padding: 1rem 1rem 1.1rem; }
    }
  </style>
</head>

<body>

  <!-- Topbar -->
  <nav class="topbar navbar navbar-expand-lg">
    <div class="container">
      <span class="navbar-brand fw-bold text-white">
        <i class="bi bi-stars me-2"></i>แผงควบคุมผู้ดูแลระบบ
      </span>
      <div class="ms-auto d-flex align-items-center gap-2">
        <span class="hello-chip">
          <i class="bi bi-person-heart"></i>
          <span>สวัสดี, <?= $username ?></span>
        </span>
        <a href="../logout.php" class="btn btn-outline-light ms-2">
          <i class="bi bi-door-open me-1"></i> ออกจากระบบ
        </a>
      </div>
    </div>
  </nav>

  <!-- Content -->
  <main class="container py-4 py-md-5">
    <div class="glass rounded-4 p-4 p-md-5 mb-4">
      <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div>
          <h2 class="section-title mb-1">ระบบผู้ดูแลระบบ</h2>
          <div class="subtitle">จัดการข้อมูลร้านค้าได้ครบ จบในที่เดียว</div>
        </div>
      </div>
    </div>

    <!-- เมนูหลัก -->
    <div class="row menu-grid g-3 g-md-4">
      <!-- จัดการสินค้า -->
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card menu-card h-100">
          <div class="card-body">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="menu-icon"><i class="bi bi-bag"></i></div>
              <div>
                <h5 class="mb-0 fw-bold">จัดการสินค้า</h5>
                <small class="text-muted">เพิ่ม/แก้ไข/สต็อก</small>
              </div>
            </div>
            <p class="mb-3 text-secondary">ดูรายการสินค้าและอัปเดตข้อมูลได้อย่างรวดเร็ว</p>
            <a href="products.php" class="btn btn-pink w-100">
              ไปที่สินค้า <i class="bi bi-arrow-right-short ms-1"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- จัดการคำสั่งซื้อ -->
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card menu-card h-100">
          <div class="card-body">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="menu-icon"><i class="bi bi-card-checklist"></i></div>
              <div>
                <h5 class="mb-0 fw-bold">คำสั่งซื้อ</h5>
                <small class="text-muted">ตรวจสอบสถานะ</small>
              </div>
            </div>
            <p class="mb-3 text-secondary">ติดตามสถานะออเดอร์และอัปเดตได้ทันที</p>
            <a href="orders.php" class="btn btn-pink w-100">
              ไปที่คำสั่งซื้อ <i class="bi bi-arrow-right-short ms-1"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- จัดการสมาชิก -->
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card menu-card h-100">
          <div class="card-body">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="menu-icon"><i class="bi bi-people"></i></div>
              <div>
                <h5 class="mb-0 fw-bold">สมาชิก</h5>
                <small class="text-muted">บทบาท/สิทธิ์</small>
              </div>
            </div>
            <p class="mb-3 text-secondary">จัดการผู้ใช้ ปรับระดับสิทธิ์ และดูวันที่สมัคร</p>
            <a href="users.php" class="btn btn-pink w-100">
              ไปที่สมาชิก <i class="bi bi-arrow-right-short ms-1"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- จัดการหมวดหมู่ -->
      <div class="col-12 col-sm-6 col-lg-3">
        <div class="card menu-card h-100">
          <div class="card-body">
            <div class="d-flex align-items-center gap-3 mb-3">
              <div class="menu-icon"><i class="bi bi-tags"></i></div>
              <div>
                <h5 class="mb-0 fw-bold">หมวดหมู่</h5>
                <small class="text-muted">จัดระเบียบสินค้า</small>
              </div>
            </div>
            <p class="mb-3 text-secondary">เพิ่ม/แก้ไขหมวดหมู่เพื่อให้ค้นหาง่ายขึ้น</p>
            <a href="category.php" class="btn btn-pink w-100">
              ไปที่หมวดหมู่ <i class="bi bi-arrow-right-short ms-1"></i>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- แถบลัดด้านล่าง (ทางเลือก) -->
    <div class="text-center mt-4">
      <a href="../logout.php" class="btn btn-outline-pink">
        <i class="bi bi-door-open me-1"></i> ออกจากระบบ
      </a>
    </div>
  </main>

  <footer class="py-4">
    <div class="container text-center soft-footer">
      <small>ด้วยรักสีชมพูอ่อนๆ · TEENOI</small>
    </div>
  </footer>

</body>
</html>
