<?php
// Đọc giá trị cookie 'fehost'
// Nếu cookie không tồn tại, đặt giá trị mặc định là 'prod-cache-01'
$fehost = $_COOKIE['fehost'] ?? 'prod-cache-01';

// Đặt cookie cho các lần truy cập sau
// (Trong lab thực tế, cookie này có thể đã được đặt bởi một endpoint khác)
if (!isset($_COOKIE['fehost'])) {
    setcookie('fehost', 'prod-cache-01', time() + 3600, '/');
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Lab Cache — Trang chủ</title>

  <!-- Bootstrap CSS (CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body { padding-top: 70px; background: #f6f8fa; }
    .hero { background: #fff; border-radius: .5rem; padding: 1.5rem; box-shadow: 0 2px 8px rgba(15,15,15,.05); }
    .host-badge { font-family: monospace; font-size: .95rem; padding:.45rem .6rem; border-radius:.35rem; background:#eef2ff; color:#0b5ed7; }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">Cache Lab</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navMain">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link active" href="#">Trang chủ</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Hướng dẫn</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main -->
  <main class="container">
    <div class="row gy-4">
      <div class="col-12">
        <div class="hero">
          <h1 class="h4 mb-2">Chào mừng đến với Lab Cache Poisoning</h1>
          <p class="text-muted mb-1">Đây là trang demo phục vụ mục đích học tập.</p>
          <p class="mb-0">Trang này được phục vụ bởi: <strong>Vũ Việt Hoàng</strong></p>
        </div>
      </div>

      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Thông tin cookie</h5>
            <p class="card-text">Giá trị host hiện tại được lấy từ cookie <code>fehost</code>. Nếu chưa có, mặc định là <strong>prod-cache-01</strong>.</p>

            <div class="d-flex align-items-center gap-3">
              <!-- hiển thị host -->
              <span class="host-badge" id="hostname">--</span>

              <button id="btnRefresh" class="btn btn-sm btn-outline-primary">Làm mới</button>
              <!-- <button id="btnCopy" class="btn btn-sm btn-outline-secondary">Sao chép</button> -->
            </div>

            <hr>

            <!-- <h6>Ghi chú</h6> -->
            
            <ul>
              <!-- <li>Cookie <code>fehost</code> được tạo trên server nếu chưa tồn tại.</li> -->
              
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <!-- <div class="card border-0 shadow-sm">
          <div class="card-body">
            <h6 class="card-title">Mẫu kiểm tra nhanh</h6>
            <p class="small text-muted">Dùng curl để kiểm tra Host header hoặc chỉnh cookie trong DevTools.</p>
            <pre class="small bg-light p-2"><code>curl -i -H "Host: attacker.example" http://YOUR_LAB_HOST/</code></pre>
            <button id="btnGuideCookie" class="btn btn-sm btn-primary w-100">Hướng dẫn đổi cookie (DevTools)</button>
          </div>
        </div> -->
      </div>

    </div>
  </main>

  <!-- <footer class="mt-5 py-4 text-center text-muted">
    © Cache Lab — VVH
  </footer> -->

  <!-- Bootstrap bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // GIỮ NGUYÊN LOGIC PHP NHƯ BẠN YÊU CẦU
    var config = {
      "host": "<?php echo $fehost; ?>"
    };

    // Hiển thị host
    var hostEl = document.getElementById('hostname');
    if (hostEl) hostEl.innerText = config.host;

    document.getElementById('btnRefresh').addEventListener('click', function() {
      if (hostEl) hostEl.innerText = config.host;
    });

    document.getElementById('btnCopy').addEventListener('click', function() {
      if (!navigator.clipboard) {
        alert('Clipboard API không hỗ trợ trên trình duyệt này.');
        return;
      }
      navigator.clipboard.writeText(config.host).then(function() {
        var btn = document.getElementById('btnCopy');
        var old = btn.innerText;
        btn.innerText = 'Đã sao chép';
        setTimeout(function(){ btn.innerText = old; }, 1200);
      });
    });

    document.getElementById('btnGuideCookie').addEventListener('click', function() {
      alert('Đổi cookie trong DevTools (Chrome):\\n1. F12 → Application → Cookies → chọn domain.\\n2. Thêm/Chỉnh giá trị cookie tên fehost = attacker.example\\n3. Reload trang để server đọc cookie mới.');
    });
  </script>
</body>
</html>
