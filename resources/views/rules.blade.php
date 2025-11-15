<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon-32x32.png') }}">
    <title>قوانین و مقررات - منطقه هیجان</title>

    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Vazirmatn', -apple-system, sans-serif;
            background: #000000;
            color: #fff;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0;
            overflow: hidden;
        }

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

        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            animation: float 20s infinite ease-in-out;
        }

        .shape:nth-child(1) {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, #ff004d, #a10035);
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, #ff1e56, #ff5500);
            top: 60%;
            right: 15%;
            animation-delay: 3s;
        }

        .shape:nth-child(3) {
            width: 350px;
            height: 350px;
            background: linear-gradient(135deg, #ff2d55, #7a001f);
            bottom: 10%;
            left: 50%;
            animation-delay: 6s;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            33% {
                transform: translate(50px, -50px) scale(1.1);
            }
            66% {
                transform: translate(-50px, 50px) scale(0.9);
            }
        }

        .main-content {
            position: relative;
            z-index: 1;
            padding: 8rem 5% 4rem;
            max-width: 1000px;
            margin: 0 auto;
        }

        .page-heading {
            text-align: center;
            margin-bottom: 3rem;
        }

        .page-heading .eyebrow {
            display: inline-block;
            background: rgba(255, 0, 77, 0.1);
            color: #ff4d73;
            padding: 0.25rem 1.25rem;
            border-radius: 999px;
            font-size: 0.95rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(255, 0, 77, 0.3);
        }

        .main-title {
            font-size: 3.2rem;
            font-weight: 800;
            line-height: 1.3;
            margin-bottom: 1rem;
            color: #fff;
        }

        .page-heading .lead-text {
            color: rgba(255, 255, 255, 0.75);
            font-size: 1.15rem;
            line-height: 2;
        }

        .section-box {
            background: rgba(10, 10, 10, 0.8);
            border: 1px solid rgba(255, 0, 77, 0.2);
            border-radius: 28px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(20px);
        }

        .section-title {
            font-size: 1.8rem;
            color: #ff4d73;
            font-weight: 700;
            margin-bottom: 1.25rem;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff004d, #ff8f1f);
            box-shadow: 0 0 20px rgba(255, 0, 77, 0.8);
        }

        .section-text {
            font-size: 1.08rem;
            line-height: 2.25;
            color: rgba(255, 255, 255, 0.85);
        }

        .section-text strong {
            color: #fff;
        }

        .back-btn {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            width: 54px;
            height: 54px;
            background: linear-gradient(135deg, #ff004d, #ff8f1f);
            border: none;
            border-radius: 50%;
            color: #fff;
            font-size: 1.4rem;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 15px 40px rgba(255, 0, 77, 0.35);
        }

        .back-btn:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 20px 45px rgba(255, 0, 77, 0.45);
        }

        .footer {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 2rem 1rem 3rem;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.95rem;
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 7rem 1.25rem 3rem;
            }

            .main-title {
                font-size: 2.2rem;
            }

            .section-box {
                padding: 1.75rem;
            }

            .back-btn {
                top: 1rem;
                right: 1rem;
                width: 48px;
                height: 48px;
            }
        }
    </style>
</head>

<body>
<div class="animated-bg">
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
</div>

<button class="back-btn" onclick="window.location.href='/'" aria-label="بازگشت به صفحه اصلی">
    <i class="bi bi-arrow-right"></i>
</button>

<main class="main-content">
    <section class="page-heading">
        <span class="eyebrow">قوانین داخلی منطقه هیجان</span>
        <h1 class="main-title">قوانین و مقررات منطقه هیجان</h1>
        <p class="lead-text">برای تضمین تجربه‌ای منظم و امن، رعایت موارد زیر برای تمامی اعضا الزامی است.</p>
    </section>

    <section class="section-box">
        <h2 class="section-title">قوانین عمومی</h2>
        <p class="section-text">
            1. کاربران مجاز به تغییر ایمیل، شناسه آنلاین و رمز عبور اکانت نیستند.<br>
            2. پس از پایان اشتراک، حذف و غیرفعال‌سازی اکانت الزامی است.<br>
            3. هر اشتراک تنها برای یک کنسول مجاز است.<br>
            4. بازی‌های ظرفیت دوم باید با یوزر شخصی استفاده شوند.<br>
            5. سهل‌انگاری در تعویض بازی بر عهده کاربر است و ممکن است باعث تأخیر شود.<br>
            6. مالکیت کامل اکانت‌ها متعلق به منطقه هیجان است و پس از پایان اشتراک باید حذف شوند.<br>
            7. پشتیبانی از ساعت 16 تا 21 فعال است؛ درخواست بازی 24 ساعته از پنل انجام می‌شود.<br>
            8. استفاده از مرورگر و پلتفرم ثابت الزامی است.<br>
            9. استعلام ظرفیت بازی امکان‌پذیر نیست.<br>
            10. ارسال مدارک باید فقط به‌صورت عکس واضح باشد؛ ویدیو مجاز نیست.<br>
            11. تحویل بازی از طریق QR انجام می‌شود و ارسال کد ۱۵ دقیقه پس از آماده‌سازی باید صورت گیرد.<br>
            12. ورود به حساب سونی در موبایل ممنوع است.<br>
            13. تعویض بازی تنها با راهنمای پشتیبانی باید انجام شود.<br>
            14. توهین یا بی‌احترامی موجب لغو اشتراک بدون عودت وجه خواهد شد.<br>
            15. مشکلات باید کوتاه، واضح و رسمی ارسال شوند (بدون فینگلیش).<br>
            16. پیش از ورود به اکانت، هماهنگی با پشتیبانی الزامی است.
        </p>
    </section>

    <section class="section-box">
        <h2 class="section-title">جرایم نقض قوانین</h2>
        <p class="section-text">
            1. لغو اشتراک بدون بازگشت هزینه برای هرگونه نقض قوانین.<br>
            2. بن شدن کنسول در صورت تخلفات شدید یا مکرر، با مسدودسازی دائمی دسترسی.<br>
            3. کاهش مدت زمان اشتراک بدون عودت وجه، بسته به نوع تخلف.<br>
            4. تأخیر در انجام درخواست‌ها در صورت عدم رعایت قوانین تعویض یا مدارک.
        </p>
    </section>

    <section class="section-box">
        <h2 class="section-title">نکات نهایی</h2>
        <p class="section-text">
            این قوانین به‌منظور حفظ کیفیت خدمات و ایجاد محیطی امن و حرفه‌ای برای تمامی کاربران تدوین شده‌اند.
            با رعایت این مقررات، تجربه‌ای لذت‌بخش و بدون مشکل از سرویس منطقه هیجان خواهید داشت.
        </p>
    </section>
</main>

<footer class="footer">
    © تمامی حقوق متعلق به منطقه هیجان است.
</footer>
</body>
</html>
