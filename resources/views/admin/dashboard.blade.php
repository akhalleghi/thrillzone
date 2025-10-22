<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>داشبورد مدیریت | منطقه هیجان</title>
    <link href="https://cdn.jsdelivr.net/npm/vazir-font@30.1.0/dist/font-face.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body{background:#0b0f2a;color:#fff}
        .topbar{background:linear-gradient(135deg,#11173e,#16163c);border-bottom:1px solid rgba(0,255,255,.2)}
        .btn-neon{background:linear-gradient(135deg,#00ffff,#ff00ff);border:none;border-radius:10px;color:#fff;font-weight:700}
        .btn-neon:hover{box-shadow:0 0 25px rgba(255,0,255,.5)}
        a{color:#00ffff} a:hover{color:#ff00ff}
    </style>
</head>
<body>
<nav class="topbar p-3 d-flex justify-content-between align-items-center">
    <div>🎮 پنل مدیریت منطقه هیجان</div>
    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button class="btn btn-neon btn-sm">خروج</button>
    </form>
</nav>

<div class="container py-4">
    @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

    <div class="row g-3">
        <div class="col-md-4">
            <div class="p-4 rounded" style="background:linear-gradient(135deg,rgba(20,25,50,.92),rgba(40,20,70,.88));border:1px solid rgba(0,255,255,.25);">
                <h5>مدیریت پلن‌ها</h5>
                <p class="text-muted">تعریف/ویرایش پلن‌های Thrill (Lite, Silver, Pro, Max)</p>
                <a href="#" class="btn btn-outline-info btn-sm">ورود به بخش</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 rounded" style="background:linear-gradient(135deg,rgba(20,25,50,.92),rgba(40,20,70,.88));border:1px solid rgba(0,255,255,.25);">
                <h5>کاربران</h5>
                <p class="text-muted">جستجو، مشاهده، مسدودسازی/فعال‌سازی</p>
                <a href="#" class="btn btn-outline-info btn-sm">ورود به بخش</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="p-4 rounded" style="background:linear-gradient(135deg,rgba(20,25,50,.92),rgba(40,20,70,.88));border:1px solid rgba(0,255,255,.25);">
                <h5>سفارش‌ها و اشتراک‌ها</h5>
                <p class="text-muted">پیگیری پرداخت‌ها و وضعیت اشتراک‌ها</p>
                <a href="#" class="btn btn-outline-info btn-sm">ورود به بخش</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
