{{--<!DOCTYPE html>--}}
{{--<html lang="fa" dir="rtl">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <title>ورود مدیر | منطقه هیجان</title>--}}
{{--    <link href="https://cdn.jsdelivr.net/npm/vazir-font@30.1.0/dist/font-face.css" rel="stylesheet">--}}
{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">--}}

{{--    <style>--}}
{{--        body{background:linear-gradient(135deg,#0a0e27,#1a1a2e 50%,#16213e);min-height:100vh;display:flex;align-items:center;justify-content:center;color:#fff}--}}
{{--        .card{background:linear-gradient(135deg,rgba(20,25,50,.92),rgba(40,20,70,.88));border:1px solid rgba(0,255,255,.25);border-radius:20px;box-shadow:0 0 40px rgba(0,255,255,.15);}--}}
{{--        .btn-neon{background:linear-gradient(135deg,#00ffff,#ff00ff);border:none;border-radius:12px;color:#fff;font-weight:700}--}}
{{--        .btn-neon:hover{box-shadow:0 0 30px rgba(255,0,255,.5);transform:translateY(-1px)}--}}
{{--        .form-control{background:rgba(255,255,255,.06);border:1px solid rgba(0,255,255,.3);color:#fff;border-radius:12px}--}}
{{--        .form-control:focus{border-color:#ff00ff;box-shadow:0 0 20px rgba(255,0,255,.3)}--}}
{{--        a{color:#00ffff} a:hover{color:#ff00ff}--}}
{{--    </style>--}}
{{--</head>--}}
{{--<body>--}}
{{--<div class="container" style="max-width:420px">--}}
{{--    <div class="card p-4 p-md-5">--}}
{{--        <h3 class="text-center mb-4" style="background:linear-gradient(135deg,#00ffff,#ff00ff);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">--}}
{{--            ورود مدیر سامانه--}}
{{--        </h3>--}}

{{--        @if (session('success'))--}}
{{--            <div class="alert alert-success">{{ session('success') }}</div>--}}
{{--        @endif--}}

{{--        @if ($errors->any())--}}
{{--            <div class="alert alert-danger">--}}
{{--                @foreach ($errors->all() as $e)--}}
{{--                    <div>{{ $e }}</div>--}}
{{--                @endforeach--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        <form method="POST" action="{{ route('admin.login.submit') }}">--}}
{{--            @csrf--}}
{{--            <div class="mb-3">--}}
{{--                <label class="form-label">نام کاربری</label>--}}
{{--                <input type="text" name="username" value="{{ old('username') }}" class="form-control" required autofocus>--}}
{{--            </div>--}}

{{--            <div class="mb-3">--}}
{{--                <label class="form-label">رمز عبور</label>--}}
{{--                <input type="password" name="password" class="form-control" required>--}}
{{--            </div>--}}

{{--            <div class="form-check mb-3">--}}
{{--                <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">--}}
{{--                <label class="form-check-label" for="remember">من را به خاطر بسپار</label>--}}
{{--            </div>--}}

{{--            <button class="btn btn-neon w-100 py-2">ورود</button>--}}
{{--        </form>--}}

{{--        <div class="text-center mt-3">--}}
{{--            <a href="{{ url('/') }}">بازگشت به سایت</a>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--</body>--}}
{{--</html>--}}

{{--    <!DOCTYPE html>--}}
{{--<html lang="fa" dir="rtl">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <title>ورود مدیر | منطقه هیجان</title>--}}

{{--    <!-- فونت وزیر -->--}}
{{--    <link href="https://cdn.jsdelivr.net/npm/vazir-font@30.1.0/dist/font-face.css" rel="stylesheet">--}}

{{--    <!-- Bootstrap -->--}}
{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">--}}
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">--}}

{{--    <style>--}}
{{--        * {--}}
{{--            font-family: 'Vazir', sans-serif;--}}
{{--            box-sizing: border-box;--}}
{{--        }--}}

{{--        body {--}}
{{--            background: linear-gradient(135deg, #0a0e27, #1a1a2e 50%, #16213e);--}}
{{--            min-height: 100vh;--}}
{{--            display: flex;--}}
{{--            align-items: center;--}}
{{--            justify-content: center;--}}
{{--            color: #fff;--}}
{{--            overflow: hidden;--}}
{{--            position: relative;--}}
{{--        }--}}

{{--        /* انیمیشن ذرات درخشان */--}}
{{--        .particles {--}}
{{--            position: absolute;--}}
{{--            width: 100%;--}}
{{--            height: 100%;--}}
{{--            overflow: hidden;--}}
{{--            z-index: 0;--}}
{{--        }--}}

{{--        .particle {--}}
{{--            position: absolute;--}}
{{--            width: 3px;--}}
{{--            height: 3px;--}}
{{--            border-radius: 50%;--}}
{{--            background: rgba(0, 255, 255, 0.5);--}}
{{--            animation: float 15s infinite ease-in-out;--}}
{{--        }--}}

{{--        @keyframes float {--}}
{{--            0%, 100% { transform: translate(0, 0); opacity: 0; }--}}
{{--            10%, 90% { opacity: 1; }--}}
{{--            50% { transform: translateY(-100px); opacity: 1; }--}}
{{--        }--}}

{{--        /* کارت لاگین */--}}
{{--        .login-card {--}}
{{--            position: relative;--}}
{{--            z-index: 10;--}}
{{--            background: linear-gradient(135deg, rgba(15, 25, 50, 0.95), rgba(30, 20, 60, 0.9));--}}
{{--            border: 2px solid rgba(0, 255, 255, 0.25);--}}
{{--            border-radius: 25px;--}}
{{--            padding: 3rem 2.5rem;--}}
{{--            box-shadow: 0 0 50px rgba(0, 255, 255, 0.2);--}}
{{--            max-width: 420px;--}}
{{--            width: 100%;--}}
{{--            backdrop-filter: blur(15px);--}}
{{--            transition: all 0.3s ease-in-out;--}}
{{--        }--}}

{{--        .login-card:hover {--}}
{{--            box-shadow: 0 0 80px rgba(255, 0, 255, 0.3);--}}
{{--            transform: translateY(-6px);--}}
{{--        }--}}

{{--        /* لوگو */--}}
{{--        .logo-container {--}}
{{--            text-align: center;--}}
{{--            margin-bottom: 2rem;--}}
{{--        }--}}

{{--        .logo-icon {--}}
{{--            width: 80px;--}}
{{--            height: 80px;--}}
{{--            background: linear-gradient(135deg, #00ffff, #ff00ff);--}}
{{--            border-radius: 20px;--}}
{{--            display: inline-flex;--}}
{{--            align-items: center;--}}
{{--            justify-content: center;--}}
{{--            font-size: 2.5rem;--}}
{{--            box-shadow: 0 0 40px rgba(0, 255, 255, 0.5);--}}
{{--            margin-bottom: 1rem;--}}
{{--            animation: pulse 3s infinite ease-in-out;--}}
{{--        }--}}

{{--        @keyframes pulse {--}}
{{--            0%, 100% { transform: scale(1); box-shadow: 0 0 25px rgba(0,255,255,0.3); }--}}
{{--            50% { transform: scale(1.1); box-shadow: 0 0 50px rgba(255,0,255,0.6); }--}}
{{--        }--}}

{{--        .logo-text {--}}
{{--            font-size: 1.8rem;--}}
{{--            font-weight: bold;--}}
{{--            background: linear-gradient(135deg, #00ffff, #ff00ff, #00ffaa);--}}
{{--            -webkit-background-clip: text;--}}
{{--            -webkit-text-fill-color: transparent;--}}
{{--        }--}}

{{--        /* فیلدهای فرم */--}}
{{--        .form-control {--}}
{{--            background: rgba(255,255,255,0.05);--}}
{{--            border: 2px solid rgba(0,255,255,0.3);--}}
{{--            border-radius: 15px;--}}
{{--            padding: 1rem;--}}
{{--            color: #fff;--}}
{{--            font-size: 1.1rem;--}}
{{--            transition: all 0.3s;--}}
{{--        }--}}

{{--        .form-control:focus {--}}
{{--            border-color: #ff00ff;--}}
{{--            box-shadow: 0 0 25px rgba(255, 0, 255, 0.3);--}}
{{--            background: rgba(255,255,255,0.1);--}}
{{--        }--}}

{{--        .form-control::placeholder {--}}
{{--            color: rgba(255,255,255,0.5);--}}
{{--        }--}}

{{--        /* دکمه نئونی */--}}
{{--        .btn-neon {--}}
{{--            background: linear-gradient(135deg, #00ffff, #ff00ff);--}}
{{--            border: none;--}}
{{--            border-radius: 15px;--}}
{{--            color: #fff;--}}
{{--            font-weight: bold;--}}
{{--            font-size: 1.1rem;--}}
{{--            padding: 1rem;--}}
{{--            width: 100%;--}}
{{--            box-shadow: 0 0 20px rgba(0, 255, 255, 0.4);--}}
{{--            transition: all 0.3s;--}}
{{--        }--}}

{{--        .btn-neon:hover {--}}
{{--            transform: translateY(-3px);--}}
{{--            box-shadow: 0 0 40px rgba(255, 0, 255, 0.6);--}}
{{--        }--}}

{{--        /* چک‌باکس و لینک‌ها */--}}
{{--        .form-check-label {--}}
{{--            color: rgba(255,255,255,0.8);--}}
{{--        }--}}

{{--        a {--}}
{{--            color: #00ffff;--}}
{{--            text-decoration: none;--}}
{{--        }--}}
{{--        a:hover {--}}
{{--            color: #ff00ff;--}}
{{--        }--}}

{{--        /* واکنش‌گرایی */--}}
{{--        @media (max-width: 576px) {--}}
{{--            .login-card {--}}
{{--                padding: 2rem 1.5rem;--}}
{{--                border-radius: 20px;--}}
{{--            }--}}
{{--            .logo-icon {--}}
{{--                width: 65px;--}}
{{--                height: 65px;--}}
{{--                font-size: 2rem;--}}
{{--            }--}}
{{--            .logo-text {--}}
{{--                font-size: 1.5rem;--}}
{{--            }--}}
{{--        }--}}

{{--        .input-group-text {--}}
{{--            background: rgba(255, 255, 255, 0.05);--}}
{{--            border: 2px solid rgba(0, 255, 255, 0.3);--}}
{{--            color: #00ffff;--}}
{{--            border-radius: 12px 0 0 12px;--}}
{{--            font-weight: bold;--}}
{{--        }--}}

{{--        .input-group .form-control {--}}
{{--            border-radius: 0 12px 12px 0;--}}
{{--        }--}}

{{--    </style>--}}
{{--</head>--}}
{{--<body>--}}

{{--<div class="particles" id="particles"></div>--}}

{{--<div class="login-card text-center">--}}
{{--    <div class="logo-container">--}}
{{--        <div class="logo-icon">⚙️</div>--}}
{{--        <h1 class="logo-text">ورود مدیر سامانه</h1>--}}
{{--        <p style="color: rgba(255,255,255,0.8); font-size: 0.95rem;">برای ورود به پنل مدیریت، اطلاعات خود را وارد کنید</p>--}}
{{--    </div>--}}

{{--    @if (session('success'))--}}
{{--        <div class="alert alert-success">{{ session('success') }}</div>--}}
{{--    @endif--}}

{{--    @if ($errors->any())--}}
{{--        <div class="alert alert-danger">--}}
{{--            @foreach ($errors->all() as $e)--}}
{{--                <div>{{ $e }}</div>--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--    @endif--}}

{{--    <form method="POST" action="{{ route('admin.login.submit') }}">--}}
{{--        @csrf--}}
{{--        <div class="mb-3">--}}
{{--            <input type="text" name="username" value="{{ old('username') }}" class="form-control" placeholder="نام کاربری" required autofocus>--}}
{{--        </div>--}}

{{--        <div class="mb-3">--}}
{{--            <input type="password" name="password" class="form-control" placeholder="رمز عبور" required>--}}
{{--        </div>--}}

{{--        <div class="form-check mb-3 text-start">--}}
{{--            <input class="form-check-input" type="checkbox" id="remember" name="remember">--}}
{{--            <label class="form-check-label" for="remember">من را به خاطر بسپار</label>--}}
{{--        </div>--}}
{{--        @php--}}
{{--            // تولید اعداد رندوم برای کپچا--}}
{{--            $n1 = rand(1, 9);--}}
{{--            $n2 = rand(1, 9);--}}
{{--            session(['captcha_sum' => $n1 + $n2]);--}}
{{--        @endphp--}}

{{--        <div class="mb-3">--}}
{{--            <label class="form-label d-block text-start">--}}
{{--                برای اطمینان از انسان بودن، حاصل جمع زیر را وارد کنید:--}}
{{--            </label>--}}
{{--            <div class="input-group">--}}
{{--        <span class="input-group-text bg-transparent text-white border-0">--}}
{{--            {{ $n1 }} + {{ $n2 }} =--}}
{{--        </span>--}}
{{--                <input type="number" name="captcha" class="form-control" placeholder="?" required>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <button class="btn-neon">ورود</button>--}}
{{--    </form>--}}

{{--    <div class="text-center mt-3">--}}
{{--        <a href="{{ url('/') }}"><i class="bi bi-house-door"></i> بازگشت به سایت</a>--}}
{{--    </div>--}}
{{--</div>--}}

{{--<script>--}}
{{--    // ایجاد ذرات درخشان پس‌زمینه--}}
{{--    function createParticles() {--}}
{{--        const container = document.getElementById('particles');--}}
{{--        for (let i = 0; i < 50; i++) {--}}
{{--            const p = document.createElement('div');--}}
{{--            p.classList.add('particle');--}}
{{--            p.style.left = Math.random() * 100 + '%';--}}
{{--            p.style.top = Math.random() * 100 + '%';--}}
{{--            p.style.animationDelay = Math.random() * 15 + 's';--}}
{{--            container.appendChild(p);--}}
{{--        }--}}
{{--    }--}}
{{--    createParticles();--}}
{{--</script>--}}

{{--</body>--}}
{{--</html>--}}

    <!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ورود مدیر | منطقه هیجان</title>
    <link href="https://cdn.jsdelivr.net/npm/vazir-font@30.1.0/dist/font-face.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        * { box-sizing: border-box; font-family: 'Vazir', sans-serif; }
        body {
            background: linear-gradient(135deg, #0a0e27, #1a1a2e 50%, #16213e);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            overflow: hidden;
            position: relative;
            padding: 1rem;
        }

        /* کارت لاگین */
        .login-card {
            position: relative;
            z-index: 10;
            background: linear-gradient(135deg, rgba(15, 25, 50, 0.95), rgba(30, 20, 60, 0.9));
            border: 2px solid rgba(0, 255, 255, 0.25);
            border-radius: 22px;
            padding: 2.5rem 2rem;
            box-shadow: 0 0 40px rgba(0, 255, 255, 0.25);
            width: 100%;
            max-width: 420px;
            backdrop-filter: blur(15px);
            transition: all 0.3s ease-in-out;
        }
        .login-card:hover { transform: translateY(-4px); box-shadow: 0 0 60px rgba(255, 0, 255, 0.25); }

        /* لوگو */
        .logo-container { text-align: center; margin-bottom: 1rem; }
        .logo-icon {
            width: 70px; height: 70px;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            border-radius: 18px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 2rem;
            box-shadow: 0 0 30px rgba(0,255,255,0.5);
            margin-bottom: 0.8rem;
            animation: pulse 3s infinite ease-in-out;
        }
        @keyframes pulse {
            0%,100%{transform:scale(1);box-shadow:0 0 20px rgba(0,255,255,0.3);}
            50%{transform:scale(1.08);box-shadow:0 0 40px rgba(255,0,255,0.5);}
        }
        .logo-text {
            font-size: 1.6rem;
            font-weight: bold;
            background: linear-gradient(135deg, #00ffff, #ff00ff, #00ffaa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* فیلدها */
        .form-control {
            background: rgba(255,255,255,0.08);
            border: 2px solid rgba(0,255,255,0.3);
            border-radius: 12px;
            padding: 1rem;
            color: #fff;
            font-size: 1.05rem;
            text-align: center;
        }
        .form-control::placeholder { color: rgba(255,255,255,0.9); }
        .form-control:focus {
            border-color: #ff00ff;
            box-shadow: 0 0 25px rgba(255,0,255,0.3);
            background: rgba(255,255,255,0.12);
        }

        .input-group-text {
            background: rgba(255,255,255,0.05);
            border: 2px solid rgba(0,255,255,0.3);
            color: #00ffff;
            font-weight: bold;
            border-radius: 10px 0 0 10px;
            padding: 0.7rem 1rem;
        }

        /* دکمه */
        .btn-neon {
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-weight: 700;
            font-size: 1.05rem;
            padding: 1rem;
            width: 100%;
            box-shadow: 0 0 20px rgba(0,255,255,0.3);
            transition: all 0.3s;
        }
        .btn-neon:hover { transform: translateY(-2px); box-shadow: 0 0 35px rgba(255,0,255,0.5); }

        a { color: #00ffff; text-decoration: none; }
        a:hover { color: #ff00ff; }

        /* ✅ نسخه موبایل */
        @media (max-width: 576px) {
            body {
                padding: 0;
                display: flex;
                align-items: flex-start;
                justify-content: center;
            }

            .login-card {
                max-width: 95%; /* ✅ فرم تمام عرض */
                padding: 2rem 1.3rem;
                margin-top: 4rem;
                border-radius: 16px;
                box-shadow: 0 0 25px rgba(0, 255, 255, 0.25);
            }

            .form-control {
                font-size: 1.15rem;
                padding: 1.1rem;
            }

            .btn-neon {
                font-size: 1.15rem;
                padding: 1.2rem;
            }

            .logo-icon {
                width: 65px;
                height: 65px;
                font-size: 1.8rem;
            }

            .logo-text {
                font-size: 1.4rem;
            }
        }
    </style>

</head>
<body>

<div class="login-card text-center">
    <div class="logo-container">
        <div class="logo-icon">⚙️</div>
        <h1 class="logo-text">ورود مدیر سامانه</h1>
        <p style="color: rgba(255,255,255,0.8); font-size: 0.95rem;">برای ورود به پنل مدیریت، اطلاعات خود را وارد کنید</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger text-start">
            @foreach ($errors->all() as $e)
                <div>• {{ $e }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf
        <div class="mb-3">
            <input type="text" name="username" value="{{ old('username') }}" class="form-control" placeholder="نام کاربری" required autofocus>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="رمز عبور" required>
        </div>

        @php
            $n1 = rand(1,9); $n2 = rand(1,9);
            session(['captcha_sum' => $n1 + $n2]);
        @endphp
        <div class="mb-3">
            <div class="input-group">
                <span class="input-group-text">{{ $n1 }} + {{ $n2 }} =</span>
                <input type="number" name="captcha" class="form-control" placeholder="پاسخ را بنویسید" required>
            </div>
        </div>

        <div class="form-check mb-3 text-start">
            <input class="form-check-input" type="checkbox" id="remember" name="remember">
            <label class="form-check-label" for="remember">من را به خاطر بسپار</label>
        </div>

        <button class="btn-neon">ورود</button>
    </form>

    <div class="text-center mt-3">
        <a href="{{ url('/') }}"><i class="bi bi-house-door"></i> بازگشت به سایت</a>
    </div>
</div>

</body>
</html>
