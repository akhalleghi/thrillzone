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
            background: #000;
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .animated-bg { position: fixed; inset: 0; overflow: hidden; z-index: 0; pointer-events: none; }
        .animated-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse at 20% 20%, rgba(255, 0, 77, 0.12) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 80%, rgba(200, 0, 50, 0.12) 0%, transparent 50%),
                radial-gradient(ellipse at 50% 50%, rgba(255, 35, 0, 0.08) 0%, transparent 60%);
            animation: bgPulse 8s ease-in-out infinite;
        }

        @keyframes bgPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .floating-shapes { position: absolute; inset: 0; }
        .shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            animation: floatShape 20s infinite ease-in-out;
        }
        .shape:nth-child(1) { width: 380px; height: 380px; background: linear-gradient(135deg, #ff004d, #a10035); top: 10%; left: 12%; animation-delay: 0s; }
        .shape:nth-child(2) { width: 320px; height: 320px; background: linear-gradient(135deg, #ff1e56, #ff5500); bottom: 15%; right: 18%; animation-delay: 3s; }
        .shape:nth-child(3) { width: 360px; height: 360px; background: linear-gradient(135deg, #ff2d55, #7a001f); top: 55%; left: 45%; animation-delay: 6s; }

        @keyframes floatShape {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(40px, -40px) scale(1.05); }
            66% { transform: translate(-40px, 40px) scale(0.95); }
        }

        .particles { position: absolute; width: 100%; height: 100%; overflow: hidden; z-index: 1; }
        .particle { position: absolute; width: 3px; height: 3px; border-radius: 50%; background: rgba(255, 0, 77, 0.65); animation: float 15s infinite ease-in-out; }
        @keyframes float { 0%, 100% { transform: translateY(0); opacity: 0; } 10%, 90% { opacity: 1; } 50% { transform: translateY(-100px); } }

        .login-card { position: relative; z-index: 10; width: 100%; max-width: 420px; background: linear-gradient(135deg, rgba(12, 12, 12, 0.95), rgba(35, 0, 15, 0.9)); border-radius: 25px; padding: 3rem 2.5rem; border: 1px solid rgba(255, 0, 77, 0.25); box-shadow: 0 20px 60px rgba(0, 0, 0, 0.7); backdrop-filter: blur(25px); transition: all 0.4s; }
        .login-card:hover { transform: translateY(-6px); box-shadow: 0 30px 70px rgba(255, 0, 77, 0.25); }

        .logo { text-align: center; margin-bottom: 1.5rem; }
        .logo-icon { width: 80px; height: 80px; background: linear-gradient(135deg, #ff004d, #a10035); border-radius: 20px; display: inline-flex; align-items: center; justify-content: center; font-size: 2.5rem; color: white; box-shadow: 0 0 35px rgba(255, 0, 77, 0.6); margin-bottom: 1rem; animation: pulse 3s infinite ease-in-out; padding: 8px; }
        .logo-icon img { width: 100%; height: 100%; object-fit: contain; display: block; border-radius: 14px; }
        @keyframes pulse { 0%, 100% { transform: scale(1); box-shadow: 0 0 25px rgba(255,0,77,0.35); } 50% { transform: scale(1.07); box-shadow: 0 0 45px rgba(255,45,0,0.55); } }
        .logo-text { font-size: 1.8rem; font-weight: bold; background: linear-gradient(90deg, #ff004d, #ff2d55, #ff8a00); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

        .form-control { background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 15px; padding: 1rem; color: #fff; font-size: 1.1rem; text-align: center; transition: all 0.3s; }
        .form-control:focus { border-color: rgba(255, 0, 77, 0.9); box-shadow: 0 0 25px rgba(255, 0, 77, 0.25); background: rgba(255,255,255,0.06); }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.85); /* ✅ روشن و واضح */
        }

        .btn-neon { background: linear-gradient(135deg, #ff004d, #a10035); border: none; color: white; font-weight: bold; font-size: 1.2rem; padding: 1rem; border-radius: 15px; width: 100%; box-shadow: 0 15px 35px rgba(255, 0, 77, 0.35); transition: all 0.3s; }
        .btn-neon:hover { transform: translateY(-3px); box-shadow: 0 20px 45px rgba(255, 0, 77, 0.5); }
        .btn-secondary { background: rgba(255,255,255,0.04); border: 1px solid rgba(255, 255, 255, 0.15); color: #ff8a80; }
        .btn-secondary:hover { background: rgba(255,255,255,0.08); color: #ff4d6d; border-color: rgba(255, 0, 77, 0.6); }

        .alert-custom { background: rgba(255, 0, 77, 0.12); border: 1px solid rgba(255, 0, 77, 0.3); color: #ff4d6d; border-radius: 12px; padding: 1rem; margin-bottom: 1rem; }

        .footer { text-align: center; font-size: 0.85rem; color: rgba(255, 255, 255, 0.65); margin-top: 2rem; }
        .footer a { color: #ff8a80; text-decoration: none; }
        .footer a:hover { color: #ff4d6d; }

        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 54px;
            height: 54px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff004d 0%, #a10035 100%);
            color: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 25px rgba(255, 0, 77, 0.45);
            z-index: 20;
            transition: all 0.3s ease;
        }
        .whatsapp-float:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(255, 0, 77, 0.6); }
        .whatsapp-float svg { width: 26px; height: 26px; fill: currentColor; }

        @media (max-width: 576px) {
            .login-card { padding: 2rem 1.5rem; }
            .logo-icon { width: 65px; height: 65px; font-size: 2rem; }
            .logo-text { font-size: 1.6rem; }
            .whatsapp-float { bottom: 20px; right: 20px; width: 48px; height: 48px; }
        }
        .form-control.mb-3 {
        color: white;
        }
    </style>
</head>
<body>
<div class="animated-bg">
    <div class="floating-shapes">
        <span class="shape"></span>
        <span class="shape"></span>
        <span class="shape"></span>
    </div>
</div>
<div class="particles" id="particles"></div>

<div class="login-card text-center">
    <div class="logo-container">
                    <div class="logo-icon">
                        <img src="{{ asset('images/thrill-logo.png') }}" alt="منطقه هیجان">
                    </div>
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
    @error('name')
    <div class="alert-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
    @enderror

    {{-- مرحله ۱: شماره موبایل --}}
    @if (!session('otp_sent') && !session('need_name'))
        <form method="POST" action="{{ route('auth.send_otp') }}">
            @csrf
            <input type="tel" name="phone" class="form-control mb-3" placeholder="شماره موبایل (مثلاً 09123456789)" required maxlength="11">
            <button class="btn-neon">ارسال کد تایید</button>
        </form>

        {{-- مرحله ۲: کد تایید --}}
    @elseif (session('otp_sent') && !session('need_name'))
        <form method="POST" action="{{ route('auth.verify_otp') }}">
            @csrf
            <input type="hidden" name="phone" value="{{ session('phone') }}">
            <input type="text" name="otp" class="form-control mb-3 text-center" placeholder="کد تایید ۶ رقمی" maxlength="6" required>
            <button type="submit" class="btn-neon">تایید و ورود</button>

            {{-- ارسال مجدد با تایمر --}}
            <a href="#" id="resendBtn" class="btn btn-secondary w-100 mt-2 disabled" data-url="{{ route('auth.resend_otp') }}">ارسال مجدد (60)</a>

            {{-- تغییر شماره --}}
            <a href="{{ route('auth.reset') }}" class="btn btn-secondary w-100 mt-2">تغییر شماره</a>
        </form>

        {{-- مرحله ۳: تکمیل نام برای کاربر جدید --}}
    @elseif (session('need_name'))
        <form method="POST" action="{{ route('auth.complete_profile') }}">
            @csrf
            <input type="text" name="name" class="form-control mb-3" placeholder="نام و نام خانوادگی" required minlength="3" maxlength="100">
            <button type="submit" class="btn-neon">تکمیل ثبت‌نام و ورود</button>

            {{-- اگر بخواد شماره را عوض کند --}}
            <a href="{{ route('auth.reset') }}" class="btn btn-secondary w-100 mt-2">تغییر شماره</a>
        </form>
    @endif

    <div class="footer mt-4">
        <p>© کلیه حقوق متعلق به <a href="https://thrillstore.ir" target="_blank">فروشگاه هیجان</a> است.</p>
    </div>
</div>

<a href="https://wa.me/989051401029" class="whatsapp-float" target="_blank" rel="noopener" aria-label="چت واتس‌اپ">
    <svg viewBox="0 0 32 32" aria-hidden="true">
        <path d="M16 2.7c-6.97 0-12.63 5.66-12.63 12.63 0 2.22.58 4.39 1.69 6.31L3 29l7.57-1.98c1.85 1 3.94 1.52 6.06 1.52 6.97 0 12.63-5.66 12.63-12.63S22.97 2.7 16 2.7zm0 22.9c-1.86 0-3.7-.5-5.3-1.44l-.38-.23-3.84 1 1.03-3.74-.25-.39A9.85 9.85 0 0 1 6.16 15C6.16 9.97 10.97 5.7 16 5.7s9.84 4.27 9.84 9.3-4.81 9.3-9.84 9.3zm5.27-6.93c-.29-.15-1.71-.85-1.98-.95-.27-.1-.47-.15-.67.15-.2.29-.77.95-.94 1.14-.17.19-.35.22-.64.07-.29-.15-1.23-.45-2.35-1.43-.87-.78-1.46-1.74-1.63-2.03-.17-.29-.02-.45.13-.6.13-.13.29-.35.44-.52.15-.17.2-.29.3-.48.1-.19.05-.36-.02-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.5-.5-.67-.5-.17 0-.36 0-.55.02-.19.02-.52.08-.79.36-.27.29-1.04 1.02-1.04 2.48s1.07 2.88 1.22 3.08c.15.19 2.11 3.22 5.1 4.38.71.31 1.26.5 1.69.64.71.23 1.36.2 1.87.12.57-.08 1.71-.7 1.95-1.37.24-.67.24-1.24.17-1.37-.07-.13-.26-.21-.55-.36z"/>
    </svg>
</a>

<script>
    // افکت ذرات
    (function createParticles(){
        const container = document.getElementById('particles');
        if (!container) return;
        for (let i = 0; i < 50; i++) {
            const p = document.createElement('div');
            p.classList.add('particle');
            p.style.left = Math.random() * 100 + '%';
            p.style.top = Math.random() * 100 + '%';
            p.style.animationDelay = Math.random() * 15 + 's';
            container.appendChild(p);
        }
    })();

    // تایمر ارسال مجدد (فقط وقتی فرم OTP نمایش داده می‌شود)
    (function handleResendTimer(){
        const btn = document.getElementById('resendBtn');
        if (!btn) return;

        // 60 ثانیه
        let left = 60;
        btn.classList.add('disabled');
        btn.setAttribute('aria-disabled', 'true');

        const timer = setInterval(() => {
            left--;
            btn.textContent = 'ارسال مجدد (' + left + ')';

            if (left <= 0) {
                clearInterval(timer);
                btn.textContent = 'ارسال مجدد';
                btn.classList.remove('disabled');
                btn.removeAttribute('aria-disabled');

                // کلیک فعال بعد از تایمر
                btn.addEventListener('click', function(e){
                    e.preventDefault();
                    window.location.href = btn.getAttribute('data-url');
                }, { once: true });
            }
        }, 1000);
    })();
</script>
</body>
</html>
