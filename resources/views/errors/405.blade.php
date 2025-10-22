<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>405 | درخواست نامعتبر</title>
    <link rel="stylesheet" href="{{ asset('css/error-style.css') }}">
</head>
<body>
<div class="glow-orb orb-1"></div>
<div class="glow-orb orb-2"></div>
<div class="glow-orb orb-3"></div>
<div class="particles" id="particles"></div>

<div class="error-card">
    <div class="error-code">405</div>
    <div class="error-message">درخواست شما با روش غیرمجاز ارسال شده است 🚫</div>
    <a href="{{ url('/') }}" class="btn-home">بازگشت به صفحه اصلی</a>
</div>

<div class="footer">
    © <a href="https://thrillstore.ir" target="_blank">منطقه هیجان</a>
</div>

<script>
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
