<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>404 | صفحه یافت نشد</title>
    <link rel="stylesheet" href="{{ asset('css/error-style.css') }}">
</head>
<body>
<div class="particles" id="particles"></div>

<div class="error-card">
    <div class="error-code">404</div>
    <div class="error-message">صفحه مورد نظر شما پیدا نشد 😕</div>
    <a href="{{ url('/') }}" class="btn-home">بازگشت به خانه</a>
</div>

<div class="footer">
    © تمامی حقوق برای <a href="https://thrillstore.ir" target="_blank">منطقه هیجان</a> محفوظ است.
</div>

<script>
    // ذرات پس‌زمینه
    const p = document.getElementById('particles');
    for (let i = 0; i < 60; i++) {
        const e = document.createElement('div');
        e.className = 'particle';
        e.style.left = Math.random() * 100 + '%';
        e.style.top = Math.random() * 100 + '%';
        e.style.animationDelay = Math.random() * 15 + 's';
        p.appendChild(e);
    }
</script>
</body>
</html>
