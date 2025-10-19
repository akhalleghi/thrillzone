<![CDATA[<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>درباره ما - منطقه هیجان</title>

    <!-- Vazir Font -->
    <link href="https://cdn.jsdelivr.net/npm/vazir-font@30.1.0/dist/font-face.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Vazir', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0a0e27 0%, #1a1a2e 50%, #16213e 100%);
            color: #fff;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Background Elements */
        .particles { position: fixed; width: 100%; height: 100%; overflow: hidden; top: 0; left: 0; z-index: 0; }
        .particle { position: absolute; width: 3px; height: 3px; background: rgba(0, 255, 255, 0.5); border-radius: 50%; animation: float 15s infinite ease-in-out; }
        @keyframes float { 0%, 100% { transform: translate(0, 0) scale(1); opacity: 0; } 10% { opacity: 1; } 90% { opacity: 1; } 100% { transform: translate(var(--tx), var(--ty)) scale(0); opacity: 0; } }
        .glow-orb { position: fixed; border-radius: 50%; filter: blur(100px); opacity: 0.4; animation: pulse 10s infinite ease-in-out; }
        .orb-1 { width: 500px; height: 500px; background: radial-gradient(circle, #00ffff, transparent); top: -150px; right: -150px; animation-delay: 0s; }
        .orb-2 { width: 450px; height: 450px; background: radial-gradient(circle, #ff00ff, transparent); bottom: -150px; left: -150px; animation-delay: 2s; }
        .orb-3 { width: 400px; height: 400px; background: radial-gradient(circle, #00ffaa, transparent); top: 50%; left: 50%; transform: translate(-50%, -50%); animation-delay: 4s; }
        @keyframes pulse { 0%, 100% { transform: scale(1); opacity: 0.3; } 50% { transform: scale(1.3); opacity: 0.6; } }

        /* Main Content */
        .main-content {
            position: relative;
            z-index: 1;
            padding: 4rem 2rem;
            min-height: calc(100vh - 45px);
        }

        .main-title {
            font-size: 3.5rem;
            font-weight: bold;
            background: linear-gradient(135deg, #00ffff, #ff00ff, #00ffaa, #00ffff);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
            margin-bottom: 1.5rem;
            animation: titleFloat 4s infinite ease-in-out, gradientShift 5s infinite;
            filter: drop-shadow(0 0 30px rgba(0, 255, 255, 0.6));
        }
        @keyframes titleFloat { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        @keyframes gradientShift { 0%, 100% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } }

        .subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.7);
            max-width: 700px;
            margin: 0 auto 4rem auto;
        }

        .about-card {
            background: linear-gradient(135deg, rgba(15, 25, 50, 0.8), rgba(30, 20, 60, 0.8));
            border-radius: 20px;
            border: 2px solid rgba(0, 255, 255, 0.2);
            backdrop-filter: blur(20px);
            padding: 3rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }

        .section-title {
            font-size: 2rem;
            font-weight: bold;
            color: #00ffff;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, #00ffff, #ff00ff);
            border-radius: 3px;
            box-shadow: 0 0 15px rgba(0, 255, 255, 0.8);
        }

        .about-text {
            font-size: 1.1rem;
            line-height: 2;
            color: rgba(255, 255, 255, 0.85);
        }

        .features-grid {
            margin-top: 3rem;
        }

        .feature-item {
            text-align: center;
            padding: 2rem;
            background: rgba(0, 255, 255, 0.05);
            border-radius: 15px;
            border: 1px solid rgba(0, 255, 255, 0.1);
            transition: all 0.3s;
        }
        .feature-item:hover {
            transform: translateY(-10px);
            background: rgba(0, 255, 255, 0.1);
            border-color: #00ffff;
            box-shadow: 0 10px 30px rgba(0, 255, 255, 0.2);
        }

        .feature-icon {
            font-size: 3rem;
            color: #ff00ff;
            margin-bottom: 1rem;
            text-shadow: 0 0 20px rgba(255, 0, 255, 0.7);
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #fff;
            margin-bottom: 0.5rem;
        }

        .feature-text {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .btn-neon {
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            border: none;
            padding: 0.8rem 2.5rem;
            border-radius: 50px;
            color: #fff;
            font-weight: bold;
            font-size: 1.1rem;
            transition: all 0.4s;
            box-shadow: 0 5px 25px rgba(0, 255, 255, 0.4);
            text-decoration: none;
            display: inline-block;
        }
        .btn-neon:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 15px 40px rgba(255, 0, 255, 0.6);
            color: #fff;
        }

        /* Back Button & Footer */
        .back-btn { position: fixed; top: 2rem; right: 2rem; width: 50px; height: 50px; background: linear-gradient(135deg, #00ffff, #ff00ff); border: none; border-radius: 50%; color: #fff; font-size: 1.5rem; cursor: pointer; transition: all 0.4s; box-shadow: 0 5px 20px rgba(0, 255, 255, 0.4); z-index: 100; display: flex; align-items: center; justify-content: center; }
        .back-btn:hover { transform: scale(1.1) rotate(360deg); box-shadow: 0 10px 30px rgba(255, 0, 255, 0.6); }
        .footer { position: relative; bottom: 0; left: 0; width: 100%; padding: 0.8rem 0; text-align: center; font-size: 0.85rem; color: rgba(255, 255, 255, 0.4); z-index: 100; background: linear-gradient(135deg, rgba(10, 14, 39, 0.5), rgba(26, 26, 46, 0.5)); backdrop-filter: blur(10px); border-top: 1px solid rgba(0, 255, 255, 0.1); }
        .footer a { color: #00ffff; text-decoration: none; font-weight: 600; transition: all 0.3s; }
        .footer a:hover { color: #ff00ff; text-shadow: 0 0 10px rgba(255, 0, 255, 0.7); }

        @media (max-width: 768px) {
            .main-title { font-size: 2.8rem; }
            .about-card { padding: 2rem; }
        }
    </style>
</head>
<body>
    <!-- Background Elements -->
    <div class="particles" id="particles"></div>
    <div class="glow-orb orb-1"></div>
    <div class="glow-orb orb-2"></div>
    <div class="glow-orb orb-3"></div>

    <!-- Back Button -->
    <button class="back-btn" onclick="window.location.href='/'">
        <i class="bi bi-arrow-right"></i>
    </button>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <h1 class="main-title">درباره منطقه هیجان</h1>
            <p class="subtitle">
                دروازه ورود شما به دنیای بی‌کران سرگرمی‌های پلی‌استیشن. ما اینجا هستیم تا بهترین تجربه گیمینگ را با ساده‌ترین و به‌صرفه‌ترین روش در اختیار شما قرار دهیم.
            </p>

            <div class="about-card">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <h2 class="section-title">ماموریت ما</h2>
                        <p class="about-text">
                            در «منطقه هیجان»، ما با شور و اشتیاق به دنیای بازی‌های ویدیویی، ماموریت خود را ارائه دسترسی آسان، سریع و مقرون‌به‌صرفه به جدیدترین و محبوب‌ترین بازی‌های پلی‌استیشن برای گیمرهای ایرانی تعریف کرده‌ایم. ما معتقدیم که هر بازیکنی شایسته تجربه بهترین‌هاست و به همین دلیل، پلتفرمی را ایجاد کرده‌ایم که این امکان را برای شما فراهم می‌کند.
                        </p>
                    </div>
                </div>

                <div class="row features-grid gy-4">
                    <h2 class="section-title mt-5">چه چیزی ارائه می‌دهیم؟</h2>
                    <p class="about-text mb-3">
                        ما با ارائه اشتراک‌های متنوع، به شما اجازه می‌دهیم تا متناسب با نیاز و بودجه خود، به دنیایی از بازی‌ها دسترسی پیدا کنید. اشتراک‌های ما در سه بازه زمانی اصلی ارائه می‌شوند:
                    </p>
                    <!-- Feature 1 -->
                    <div class="col-md-4">
                        <div class="feature-item">
                            <div class="feature-icon"><i class="bi bi-calendar3"></i></div>
                            <h3 class="feature-title">اشتراک ۳ ماهه</h3>
                            <p class="feature-text">ایده‌آل برای شروع یک ماجراجویی جدید و تجربه بازی‌های فصلی.</p>
                        </div>
                    </div>
                    <!-- Feature 2 -->
                    <div class="col-md-4">
                        <div class="feature-item">
                            <div class="feature-icon"><i class="bi bi-calendar2-range"></i></div>
                            <h3 class="feature-title">اشتراک ۶ ماهه</h3>
                            <p class="feature-text">محبوب‌ترین انتخاب برای گیمرهای حرفه‌ای که می‌خواهند عمیق‌تر شوند.</p>
                        </div>
                    </div>
                    <!-- Feature 3 -->
                    <div class="col-md-4">
                        <div class="feature-item">
                            <div class="feature-icon"><i class="bi bi-calendar-check"></i></div>
                            <h3 class="feature-title">اشتراک ۱۲ ماهه</h3>
                            <p class="feature-text">به‌صرفه‌ترین گزینه برای دسترسی نامحدود و یک سال سرگرمی بی وقفه.</p>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <a href="/" class="btn-neon">مشاهده پکیج‌ها</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <span>© تمامی حقوق برای </span>
        <a href="https://thrillstore.ir" target="_blank">فروشگاه هیجان</a>
        <span> محفوظ است. طراحی و توسعه توسط </span>
        <a href="https://wa.me/989137640338" target="_blank">امین</a>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Create Particles
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            if (!particlesContainer) return;
            for (let i = 0; i < 80; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.setProperty('--tx', (Math.random() - 0.5) * 300 + 'px');
                particle.style.setProperty('--ty', (Math.random() - 0.5) * 300 + 'px');
                particle.style.animationDelay = Math.random() * 15 + 's';
                particlesContainer.appendChild(particle);
            }
        }
        createParticles();
    </script>
</body>
</html>]]>
