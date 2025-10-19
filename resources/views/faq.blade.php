<![CDATA[<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سوالات متداول - منطقه هیجان</title>

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

        /* Background Elements (Particles & Orbs) */
        .particles {
            position: fixed;
            width: 100%;
            height: 100%;
            overflow: hidden;
            top: 0;
            left: 0;
            z-index: 0;
        }

        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: rgba(0, 255, 255, 0.5);
            border-radius: 50%;
            animation: float 15s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translate(var(--tx), var(--ty)) scale(0); opacity: 0; }
        }

        .glow-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.4;
            animation: pulse 10s infinite ease-in-out;
        }
        .orb-1 { width: 500px; height: 500px; background: radial-gradient(circle, #00ffff, transparent); top: -150px; right: -150px; animation-delay: 0s; }
        .orb-2 { width: 450px; height: 450px; background: radial-gradient(circle, #ff00ff, transparent); bottom: -150px; left: -150px; animation-delay: 2s; }
        .orb-3 { width: 400px; height: 400px; background: radial-gradient(circle, #00ffaa, transparent); top: 50%; left: 50%; transform: translate(-50%, -50%); animation-delay: 4s; }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.3); opacity: 0.6; }
        }

        /* Header */
        .header {
            position: relative;
            z-index: 1000;
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.95), rgba(26, 26, 46, 0.95));
            backdrop-filter: blur(30px);
            border-bottom: 2px solid transparent;
            border-image: linear-gradient(90deg, #00ffff, #ff00ff, #00ffaa) 1;
            padding: 1.2rem 0;
            box-shadow: 0 10px 40px rgba(0, 255, 255, 0.2);
        }
        .logo-container { display: flex; align-items: center; gap: 1rem; }
        .logo-icon { width: 50px; height: 50px; background: linear-gradient(135deg, #00ffff, #ff00ff); border-radius: 15px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; box-shadow: 0 5px 25px rgba(0, 255, 255, 0.5); }
        .logo { font-size: 2rem; font-weight: bold; background: linear-gradient(135deg, #00ffff, #ff00ff, #00ffaa); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; filter: drop-shadow(0 0 20px rgba(0, 255, 255, 0.5)); }

        /* Main Content */
        .main-content {
            position: relative;
            z-index: 1;
            padding: 4rem 2rem;
            min-height: calc(100vh - 45px); /* Adjust for footer */
        }

        .main-title {
            font-size: 3rem;
            font-weight: bold;
            background: linear-gradient(135deg, #00ffff, #ff00ff, #00ffaa, #00ffff);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
            margin-bottom: 3rem;
            animation: titleFloat 4s infinite ease-in-out, gradientShift 5s infinite;
            filter: drop-shadow(0 0 30px rgba(0, 255, 255, 0.6));
        }

        @keyframes titleFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        /* Accordion Styles */
        .accordion-custom {
            max-width: 900px;
            margin: 0 auto;
            background: linear-gradient(135deg, rgba(15, 25, 50, 0.8), rgba(30, 20, 60, 0.8));
            border-radius: 20px;
            border: 2px solid rgba(0, 255, 255, 0.2);
            backdrop-filter: blur(20px);
            padding: 2rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }

        .accordion-item {
            background: transparent;
            border: none;
            border-bottom: 1px solid rgba(0, 255, 255, 0.15);
        }
        .accordion-item:last-child {
            border-bottom: none;
        }

        .accordion-header .accordion-button {
            background: transparent;
            color: #fff;
            font-size: 1.2rem;
            font-weight: 600;
            padding: 1.5rem 1rem;
            border: none;
            box-shadow: none;
            transition: all 0.3s;
            position: relative;
        }

        .accordion-button:not(.collapsed) {
            color: #00ffff;
            background: rgba(0, 255, 255, 0.05);
        }

        .accordion-button:focus {
            box-shadow: none;
        }

        .accordion-button::after {
            content: '\F282'; /* Bootstrap icon chevron down */
            font-family: 'bootstrap-icons';
            font-size: 1.2rem;
            color: #ff00ff;
            transform: rotate(0deg);
            transition: transform 0.3s;
            background-image: none;
        }

        .accordion-button:not(.collapsed)::after {
            transform: rotate(-180deg);
            color: #00ffff;
        }

        .accordion-body {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
            line-height: 1.8;
            padding: 0 1rem 1.5rem 1rem;
            border-top: 1px solid rgba(0, 255, 255, 0.1);
        }

        /* Back Button */
        .back-btn {
            position: fixed;
            top: 2rem;
            right: 2rem;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            border: none;
            border-radius: 50%;
            color: #fff;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.4s;
            box-shadow: 0 5px 20px rgba(0, 255, 255, 0.4);
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .back-btn:hover {
            transform: scale(1.1) rotate(360deg);
            box-shadow: 0 10px 30px rgba(255, 0, 255, 0.6);
        }

        /* Footer */
        .footer {
            position: relative;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 0.8rem 0;
            text-align: center;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.4);
            z-index: 100;
            background: linear-gradient(135deg, rgba(10, 14, 39, 0.5), rgba(26, 26, 46, 0.5));
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(0, 255, 255, 0.1);
        }
        .footer a { color: #00ffff; text-decoration: none; font-weight: 600; transition: all 0.3s; }
        .footer a:hover { color: #ff00ff; text-shadow: 0 0 10px rgba(255, 0, 255, 0.7); }

        @media (max-width: 768px) {
            .main-title { font-size: 2.5rem; }
            .accordion-custom { padding: 1.5rem; }
            .accordion-header .accordion-button { font-size: 1.1rem; padding: 1.2rem 0.8rem; }
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
            <h1 class="main-title">سوالات متداول</h1>

            <div class="accordion-custom">
                <div class="accordion" id="faqAccordion">
                    <!-- FAQ Item 1 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                چگونه می‌توانم اشتراک بخرم؟
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                برای خرید اشتراک، ابتدا از صفحه اصلی یکی از پکیج‌های مورد نظر خود را انتخاب کرده و روی دکمه "ورود و خرید اشتراک" کلیک کنید. سپس وارد صفحه پرداخت شده و پس از تکمیل اطلاعات، اشتراک شما فعال خواهد شد.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                آیا می‌توانم پکیج خود را ارتقا دهم؟
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                بله، شما در هر زمان می‌توانید با پرداخت ما به التفاوت، پکیج اشتراک خود را به سطح بالاتری ارتقا دهید. برای این کار به پنل کاربری خود مراجعه کرده و گزینه ارتقا اشتراک را انتخاب کنید.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 3 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                بازی‌ها روی چه دستگاه‌هایی قابل اجرا هستند؟
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                سرویس ما از طیف گسترده‌ای از دستگاه‌ها پشتیبانی می‌کند، از جمله کامپیوترهای شخصی (ویندوز و مک)، کنسول‌های بازی (پلی‌استیشن و ایکس‌باکس) و دستگاه‌های موبایل (اندروید و iOS).
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 4 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                روش‌های پرداخت به چه صورت است؟
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                شما می‌توانید هزینه اشتراک خود را از طریق تمامی کارت‌های عضو شتاب و با استفاده از درگاه پرداخت امن ما پرداخت نمایید.
                            </div>
                        </div>
                    </div>
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
