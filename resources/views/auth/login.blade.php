<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود به منطقه هیجان</title>

    <!-- فونت وزیر -->
    <link href="https://cdn.jsdelivr.net/npm/vazir-font@30.1.0/dist/font-face.css" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Vazir', sans-serif; }

        body {
            background: linear-gradient(135deg, #0a0e27, #1a1a2e 50%, #16213e);
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* ذرات درخشان پس‌زمینه */
        .particles { position: absolute; width: 100%; height: 100%; overflow: hidden; z-index: 0; }
        .particle { position: absolute; width: 3px; height: 3px; border-radius: 50%; background: rgba(0, 255, 255, 0.6); animation: float 15s infinite ease-in-out; }
        @keyframes float { 0%, 100% { transform: translateY(0); opacity: 0; } 10%, 90% { opacity: 1; } 50% { transform: translateY(-100px); } }

        /* کارت لاگین */
        .login-card { position: relative; z-index: 10; width: 100%; max-width: 420px; background: linear-gradient(135deg, rgba(15, 25, 50, 0.95), rgba(30, 20, 60, 0.9)); border-radius: 25px; padding: 3rem 2.5rem; border: 2px solid rgba(0, 255, 255, 0.25); box-shadow: 0 0 40px rgba(0, 255, 255, 0.2); backdrop-filter: blur(20px); transition: all 0.4s; }
        .login-card:hover { transform: translateY(-6px); box-shadow: 0 0 60px rgba(255, 0, 255, 0.4); }

        .logo { text-align: center; margin-bottom: 1.5rem; }
        .logo-icon { width: 80px; height: 80px; background: linear-gradient(135deg, #00ffff, #ff00ff); border-radius: 20px; display: inline-flex; align-items: center; justify-content: center; font-size: 2.5rem; color: white; box-shadow: 0 0 30px rgba(0, 255, 255, 0.5); margin-bottom: 1rem; animation: pulse 3s infinite ease-in-out; }
        @keyframes pulse { 0%, 100% { transform: scale(1); box-shadow: 0 0 20px rgba(0,255,255,0.3); } 50% { transform: scale(1.1); box-shadow: 0 0 40px rgba(255,0,255,0.6); } }
        .logo-text { font-size: 1.8rem; font-weight: bold; background: linear-gradient(90deg, #00ffff, #ff00ff, #00ffaa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

        /* فیلدها */
        .form-control { background: rgba(255, 255, 255, 0.05); border: 2px solid rgba(0, 255, 255, 0.3); border-radius: 15px; padding: 1rem; color: #fff; font-size: 1.1rem; text-align: center; transition: all 0.3s; }
        .form-control:focus { border-color: #ff00ff; box-shadow: 0 0 25px rgba(255, 0, 255, 0.3); background: rgba(255,255,255,0.1); }
        .form-control::placeholder { color: #706f6c; }

        /* دکمه نئون */
        .btn-neon { background: linear-gradient(135deg, #00ffff, #ff00ff); border: none; color: white; font-weight: bold; font-size: 1.2rem; padding: 1rem; border-radius: 15px; width: 100%; box-shadow: 0 0 20px rgba(0, 255, 255, 0.4); transition: all 0.3s; }
        .btn-neon:hover { transform: translateY(-3px); box-shadow: 0 0 40px rgba(255, 0, 255, 0.6); }
        .btn-secondary { background: rgba(255,255,255,0.05); border: 2px solid rgba(0,255,255,0.3); color: #00ffff; }
        .btn-secondary:hover { background: rgba(255,255,255,0.1); color: #ff00ff; border-color: #ff00ff; }

        /* پیغام‌ها */
        .alert-custom { background: rgba(255, 0, 255, 0.1); border: 2px solid rgba(255, 0, 255, 0.3); color: #ff00ff; border-radius: 12px; padding: 1rem; margin-bottom: 1rem; }

        /* فوتر */
        .footer { text-align: center; font-size: 0.85rem; color: rgba(255, 255, 255, 0.5); margin-top: 2rem; }
        .footer a { color: #00ffff; text-decoration: none; }
        .footer a:hover { color: #ff00ff; }

        @media (max-width: 576px) {
            .login-card { padding: 2rem 1.5rem; }
            .logo-icon { width: 65px; height: 65px; font-size: 2rem; }
            .logo-text { font-size: 1.6rem; }
        }
    </style>
</head>
<body>
<div class="particles" id="particles"></div>

<div class="login-card text-center">
    <div class="logo-container">
        <div class="logo-icon">🎮</div>
        <h1 class="logo-text">منطقه هیجان</h1>
        <p class="welcome-text">خوش آمدید! لطفا وارد شوید</p>
    </div>

    {{-- پیام‌ها --}}
    @if (session('success'))
        <div class="alert-custom"><i class="bi bi-check2-circle"></i> {{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert-custom"><i class="bi bi-exclamation-circle"></i> {{ session('error') }}</div>
    @endif
    @error('phone')
    <div class="alert-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
    @enderror
    @error('otp')
    <div class="alert-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
    @enderror

    {{-- مرحله ۱: شماره موبایل --}}
    @if (!session('otp_sent'))
        <form method="POST" action="{{ route('auth.send_otp') }}">
            @csrf
            <input type="tel" name="phone" class="form-control mb-3" placeholder="شماره موبایل (مثلاً 09123456789)" required maxlength="11">
            <button class="btn-neon">ارسال کد تایید</button>
        </form>
    @else
        {{-- مرحله ۲: کد تایید --}}
        <form method="POST" action="{{ route('auth.verify_otp') }}">
            @csrf
            <input type="hidden" name="phone" value="{{ session('phone') }}">
            <input type="text" name="otp" class="form-control mb-3 text-center" placeholder="کد تایید ۶ رقمی" maxlength="6" required>
            <button type="submit" class="btn-neon">تایید و ورود</button>

            {{-- ارسال مجدد با تایمر --}}
            <a href="#" id="resendBtn" class="btn btn-secondary w-100 mt-2 disabled">ارسال مجدد (60)</a>

            {{-- تغییر شماره --}}
            <a href="{{ route('auth.reset') }}" class="btn btn-secondary w-100 mt-2">تغییر شماره</a>
        </form>
    @endif

    <div class="footer mt-4">
        <p>© کلیه حقوق متعلق به <a href="https://thrillstore.ir" target="_blank">فروشگاه هیجان</a> است.</p>
    </div>
</div>

<script>
    // افکت ذرات
    (function createParticles(){
        const container = document.getElementById('particles');
        for (let i = 0; i < 50; i++) {
            const p = document.createElement('div');
            p.classList.add('particle');
            p.style.left = Math.random() * 100 + '%';
            p.style.top = Math.random() * 100 + '%';
            p.style.animationDelay = Math.random() * 15 + 's';
            container.appendChild(p);
        }
    })();

    // تایمر "ارسال مجدد": بعد از 60 ثانیه لینک فعال و کلیک، واقعاً درخواست می‌فرستد
    (function handleResend(){
        const resendBtn = document.getElementById('resendBtn');
        if (!resendBtn) return;

        let timeLeft = 60;
        resendBtn.classList.add('disabled');
        resendBtn.style.pointerEvents = 'none';
        resendBtn.textContent = `ارسال مجدد (${timeLeft})`;

        const t = setInterval(() => {
            timeLeft--;
            resendBtn.textContent = `ارسال مجدد (${timeLeft})`;
            if (timeLeft <= 0) {
                clearInterval(t);
                resendBtn.classList.remove('disabled');
                resendBtn.style.pointerEvents = 'auto';
                resendBtn.textContent = 'ارسال مجدد';
                resendBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    window.location.href = "{{ route('auth.resend_otp') }}";
                }, { once: true });
            }
        }, 1000);
    })();
</script>
</body>
</html>
