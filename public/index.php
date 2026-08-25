<?php
declare(strict_types=1);
session_start();
$config = [
  'company' => getenv('COMPANY_NAME') ?: 'CÔNG TY ',
  'subtitle' => getenv('APP_SUBTITLE') ?: 'Hệ thống quản lý tài sản doanh nghiệp',
];
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="description" content="Hệ thống quản lý tài sản doanh nghiệp">
  <title>QLTS Enterprise</title>
  <link rel="stylesheet" href="assets/style.css">
  <link rel="stylesheet" href="assets/permissions.css">
  <link rel="stylesheet" href="assets/mobile-nav.css">
</head>
<body>
<div id="login" class="login-page">
  <form id="loginForm" class="login-card">
    <div class="brand-mark">ML</div>
    <h1><?= htmlspecialchars($config['company']) ?></h1>
    <p><?= htmlspecialchars($config['subtitle']) ?></p>
    <label>Tên đăng nhập<input id="username" autocomplete="username" value="admin" required></label>
    <label>Mật khẩu<input id="password" type="password" autocomplete="current-password" value="Admin@123" required></label>
    <button class="btn primary" type="submit">Đăng nhập</button>
    <small>Tài khoản demo: admin / Admin@123</small>
  </form>
</div>

<div id="app" class="app hidden">
  <aside class="sidebar">
    <div class="side-brand"><strong><?= htmlspecialchars($config['company']) ?></strong><span><?= htmlspecialchars($config['subtitle']) ?></span></div>
    <div class="user-box">👤 Xin chào, <b id="currentUserName">ADMIN</b><br><small id="currentUserRole">Quản trị hệ thống</small><button id="logout">Đăng xuất</button></div>
    <nav id="nav">
      <button data-page="dashboard" class="active">◉ Tổng quan</button>
      <button data-page="assets">▣ Tài sản</button>
      <button data-page="warehouse">▦ Trung tâm kho</button>
      <button data-page="transfers">⇄ Luân chuyển</button>
      <button data-page="maintenance">🛠 Bảo trì & sửa chữa</button>
      <button data-page="approvals">✓ Quy trình phê duyệt</button>
      <button data-page="documents">✍ Biên bản & chữ ký</button>
      <button data-page="procurement">🛒 Mua sắm & nhà cung cấp</button>
      <button data-page="itam">💻 Tài sản CNTT</button>
      <button data-page="disposal">♻ Thanh lý tài sản</button>
      <hr><button data-page="categories">⚙ Danh mục</button>
      <button data-page="inventory">☑ Kiểm kê</button>
      <hr><button data-page="accounts">👥 Tài khoản</button>
      <button data-page="audit">⌛ Nhật ký hoạt động</button>
    </nav>
  </aside>
  <button id="sidebarBackdrop" class="sidebar-backdrop" aria-label="Đóng menu"></button>
  <main class="main">
    <header class="topbar"><button id="menuBtn">☰</button><div><h2 id="pageTitle">Tổng quan hệ thống</h2><p id="pageSubtitle">Theo dõi toàn bộ tài sản trong một nơi.</p></div><button class="btn primary" data-action="new-asset">＋ Thêm tài sản</button></header>
    <section id="content"></section>
  </main>
</div>

<dialog id="modal"><form method="dialog" class="modal-card"><button class="modal-close" value="cancel">×</button><div id="modalBody"></div></form></dialog>
<div id="toast" role="status"></div>
<script>window.QLTS_CONFIG = <?= json_encode($config, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) ?>;</script>
<script src="assets/app.js"></script>
</body></html>
