<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ورود مدیر | منطقه هیجان</title>
    <link href="https://cdn.jsdelivr.net/npm/vazir-font@30.1.0/dist/font-face.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">

    <style>
        body{background:linear-gradient(135deg,#0a0e27,#1a1a2e 50%,#16213e);min-height:100vh;display:flex;align-items:center;justify-content:center;color:#fff}
        .card{background:linear-gradient(135deg,rgba(20,25,50,.92),rgba(40,20,70,.88));border:1px solid rgba(0,255,255,.25);border-radius:20px;box-shadow:0 0 40px rgba(0,255,255,.15);}
        .btn-neon{background:linear-gradient(135deg,#00ffff,#ff00ff);border:none;border-radius:12px;color:#fff;font-weight:700}
        .btn-neon:hover{box-shadow:0 0 30px rgba(255,0,255,.5);transform:translateY(-1px)}
        .form-control{background:rgba(255,255,255,.06);border:1px solid rgba(0,255,255,.3);color:#fff;border-radius:12px}
        .form-control:focus{border-color:#ff00ff;box-shadow:0 0 20px rgba(255,0,255,.3)}
        a{color:#00ffff} a:hover{color:#ff00ff}
    </style>
</head>
<body>
<div class="container" style="max-width:420px">
    <div class="card p-4 p-md-5">
        <h3 class="text-center mb-4" style="background:linear-gradient(135deg,#00ffff,#ff00ff);-webkit-background-clip:text;-webkit-text-fill-color:transparent;">
            ورود مدیر سامانه
        </h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $e)
                    <div>{{ $e }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">نام کاربری</label>
                <input type="text" name="username" value="{{ old('username') }}" class="form-control" required autofocus>
            </div>

            <div class="mb-3">
                <label class="form-label">رمز عبور</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember">
                <label class="form-check-label" for="remember">من را به خاطر بسپار</label>
            </div>

            <button class="btn btn-neon w-100 py-2">ورود</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ url('/') }}">بازگشت به سایت</a>
        </div>
    </div>
</div>
</body>
</html>
