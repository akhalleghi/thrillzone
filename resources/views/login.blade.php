<![CDATA[<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود به منطقه هیجان</title>

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
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background Particles */
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
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translate(var(--tx), var(--ty)) scale(0);
                opacity: 0;
            }
        }

        /* Glowing Background Orbs */
        .glow-orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.4;
            animation: pulse 10s infinite ease-in-out;
        }

        .orb-1 {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, #00ffff, transparent);
            top: -150px;
            right: -150px;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, #ff00ff, transparent);
            bottom: -150px;
            left: -150px;
            animation-delay: 2s;
        }

        .orb-3 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, #00ffaa, transparent);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: 4s;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.3;
            }
            50% {
                transform: scale(1.3);
                opacity: 0.6;
            }
        }

        /* Login Container */
        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 480px;
            padding: 2rem;
        }

        .login-card {
            background: linear-gradient(135deg, rgba(15, 25, 50, 0.95), rgba(30, 20, 60, 0.95));
            border-radius: 30px;
            border: 3px solid rgba(0, 255, 255, 0.3);
            backdrop-filter: blur(30px);
            padding: 3rem 2.5rem;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.6);
            position: relative;
            overflow: hidden;
            animation: cardFloat 6s infinite ease-in-out;
        }

        @keyframes cardFloat {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0, 255, 255, 0.1), rgba(255, 0, 255, 0.1));
            border-radius: 30px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .login-card:hover::before {
            opacity: 1;
        }

        .login-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.05), transparent);
            transform: rotate(45deg);
            animation: shine 8s infinite;
        }

        @keyframes shine {
            0% {
                top: -50%;
                left: -50%;
            }
            100% {
                top: 150%;
                left: 150%;
            }
        }

        /* Logo */
        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            animation: logoRotate 20s infinite linear;
            box-shadow: 0 10px 40px rgba(0, 255, 255, 0.6);
            position: relative;
            margin-bottom: 1rem;
        }

        .logo-icon::before {
            content: '';
            position: absolute;
            inset: -5px;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            border-radius: 25px;
            z-index: -1;
            opacity: 0.5;
            filter: blur(20px);
            animation: logoPulse 3s infinite;
        }

        @keyframes logoRotate {
            0%, 100% {
                transform: rotateY(0deg);
            }
            50% {
                transform: rotateY(360deg);
            }
        }

        @keyframes logoPulse {
            0%, 100% {
                opacity: 0.3;
                transform: scale(1);
            }
            50% {
                opacity: 0.8;
                transform: scale(1.2);
            }
        }

        .logo-text {
            font-size: 2rem;
            font-weight: bold;
            background: linear-gradient(135deg, #00ffff, #ff00ff, #00ffaa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 0 20px rgba(0, 255, 255, 0.5));
            margin-bottom: 0.5rem;
        }

        .welcome-text {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
            margin-bottom: 0;
        }

        /* Form Styles */
        .static-label {
            color: #00ffff;
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .static-label i {
            font-size: 1.2rem;
            color: #ff00ff;
        }

        /* Floating Label Form Group */
        .form-group {
            position: relative;
            margin-bottom: 2rem;
        }

        .form-label-float {
            position: absolute;
            top: 50%;
            right: 1.5rem;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
            font-size: 1.1rem;
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .form-label-float i {
            font-size: 1.2rem;
            transition: color 0.3s;
        }

        .form-control:focus ~ .form-label-float,
        .form-control:not(:placeholder-shown) ~ .form-label-float {
            top: -12px;
            right: 1rem;
            font-size: 0.9rem;
            color: #00ffff;
            background: #121a3a; /* Match the card's inner gradient */
            padding: 0 0.5rem;
            border-radius: 5px;
        }

        .form-control:focus ~ .form-label-float i {
            color: #ff00ff;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(0, 255, 255, 0.3);
            border-radius: 15px;
            padding: 1rem 1.5rem;
            color: #fff;
            font-size: 1.1rem;
            transition: all 0.3s;
            direction: ltr;
            text-align: right;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: #ff00ff;
            box-shadow: 0 0 25px rgba(255, 0, 255, 0.4);
            color: #fff;
            outline: none;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.4);
            direction: rtl;
        }


        .input-icon {
            position: absolute;
            left: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            color: #00ffff;
            font-size: 1.3rem;
            z-index: 10;
            transition: all 0.3s;
        }

        .form-control:focus ~ .input-icon {
            color: #ff00ff;
            transform: translateY(-50%) scale(1.2);
        }

        /* OTP Input */
        .otp-container {
            display: none;
            animation: slideDown 0.5s ease-out;
        }

        .otp-container.active {
            display: block;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .otp-inputs {
            display: flex;
            gap: 0.8rem;
            justify-content: center;
            margin-bottom: 1.5rem;
            direction: ltr;
        }

        .otp-input {
            width: 55px;
            height: 55px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(0, 255, 255, 0.3);
            border-radius: 12px;
            color: #fff;
            transition: all 0.3s;
        }

        .otp-input:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: #ff00ff;
            box-shadow: 0 0 25px rgba(255, 0, 255, 0.4);
            outline: none;
            transform: scale(1.1);
        }

        /* Timer */
        .timer-text {
            text-align: center;
            color: #00ffff;
            font-size: 0.95rem;
            margin-bottom: 1rem;
        }

        .timer-text.expired {
            color: #ff00ff;
        }

        /* Buttons */
        .btn-neon {
            width: 100%;
            background: linear-gradient(135deg, #00ffff, #ff00ff);
            border: none;
            padding: 1.2rem;
            border-radius: 15px;
            color: #fff;
            font-weight: bold;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 255, 255, 0.4);
            margin-bottom: 1rem;
        }

        .btn-neon::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.8s, height 0.8s;
        }

        .btn-neon:hover::before {
            width: 500px;
            height: 500px;
        }

        .btn-neon:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 15px 40px rgba(255, 0, 255, 0.6);
        }

        .btn-neon:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(0, 255, 255, 0.3);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: #00ffff;
        }

        /* Links */
        .text-link {
            color: #00ffff;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            position: relative;
        }

        .text-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #00ffff, #ff00ff);
            transition: width 0.3s;
        }

        .text-link:hover {
            color: #ff00ff;
        }

        .text-link:hover::after {
            width: 100%;
        }

        .divider {
            text-align: center;
            margin: 1.5rem 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(0, 255, 255, 0.3), transparent);
        }

        .divider span {
            background: linear-gradient(135deg, rgba(15, 25, 50, 0.95), rgba(30, 20, 60, 0.95));
            padding: 0 1rem;
            position: relative;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
        }

        /* Alert Messages */
        .alert-custom {
            background: rgba(255, 0, 255, 0.1);
            border: 2px solid rgba(255, 0, 255, 0.3);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            color: #ff00ff;
            font-size: 0.95rem;
            display: none;
            animation: slideDown 0.3s ease-out;
        }

        .alert-custom.show {
            display: block;
        }

        .alert-custom i {
            margin-left: 0.5rem;
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

        /* Responsive */
        @media (max-width: 576px) {
            .login-card {
                padding: 2rem 1.5rem;
            }

            .logo-icon {
                width: 70px;
                height: 70px;
                font-size: 2rem;
            }

            .logo-text {
                font-size: 1.7rem;
            }

            .otp-input {
                width: 45px;
                height: 45px;
                font-size: 1.2rem;
            }

            .back-btn {
                top: 1rem;
                right: 1rem;
                width: 45px;
                height: 45px;
                font-size: 1.3rem;
            }
        }

        /* Footer */
        .footer {
            position: fixed;
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

        .footer a {
            color: #00ffff;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .footer a:hover {
            color: #ff00ff;
            text-shadow: 0 0 10px rgba(255, 0, 255, 0.7);
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

    <!-- Login Container -->
    <div class="login-container">
        <div class="login-card">
            <!-- Logo -->
            <div class="logo-container">
                <div class="logo-icon">🎮</div>
                <h1 class="logo-text">منطقه هیجان</h1>
                <p class="welcome-text">خوش آمدید! لطفا وارد شوید</p>
            </div>

            <!-- Alert Message -->
            <div class="alert-custom" id="alertMessage">
                <i class="bi bi-exclamation-circle"></i>
                <span id="alertText"></span>
            </div>

            <!-- Phone Number Form -->
            <form id="phoneForm">
                <div class="form-group">
                    <input 
                        type="tel" 
                        class="form-control" 
                        id="phoneInput" 
                        placeholder=" "
                        maxlength="11"
                        required
                    >
                    <label for="phoneInput" class="form-label-float">
                        <i class="bi bi-phone"></i>
                        شماره موبایل
                    </label>
                    <i class="bi bi-phone-fill input-icon"></i>
                </div>

                <button type="submit" class="btn-neon" id="sendOtpBtn">
                    ارسال کد تایید
                </button>
            </form>

            <!-- OTP Verification Form -->
            <div class="otp-container" id="otpContainer">
                <form id="otpForm">
                    <label class="static-label">
                        <i class="bi bi-shield-check"></i>
                        کد تایید را وارد کنید
                    </label>
                    
                    <div class="otp-inputs">
                        <input type="text" class="otp-input" maxlength="1" data-index="0">
                        <input type="text" class="otp-input" maxlength="1" data-index="1">
                        <input type="text" class="otp-input" maxlength="1" data-index="2">
                        <input type="text" class="otp-input" maxlength="1" data-index="3">
                        <input type="text" class="otp-input" maxlength="1" data-index="4">
                        <input type="text" class="otp-input" maxlength="1" data-index="5">
                    </div>

                    <div class="timer-text" id="timerText">
                        زمان باقی‌مانده: <span id="timer">02:00</span>
                    </div>

                    <button type="submit" class="btn-neon" id="verifyOtpBtn">
                        تایید و ورود
                    </button>

                    <button type="button" class="btn-neon btn-secondary" id="resendOtpBtn" disabled>
                        ارسال مجدد کد
                    </button>

                    <button type="button" class="btn-neon btn-secondary" id="changeNumberBtn">
                        تغییر شماره موبایل
                    </button>
                </form>
            </div>

            <!-- Divider -->
            <div class="divider">
                <span>یا</span>
            </div>

            <!-- Additional Links -->
            <div class="text-center">
                <!-- <p class="mb-2" style="color: rgba(255, 255, 255, 0.7);">
                    حساب کاربری ندارید؟
                    <a href="#" class="text-link">ثبت نام کنید</a>
                </p> -->
                <p class="mb-0" style="color: rgba(255, 255, 255, 0.7); font-size: 0.9rem;">
                    <a href="/tutorial" class="text-link">راهنما و پشتیبانی</a>
                </p>
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

        // Elements
        const phoneForm = document.getElementById('phoneForm');
        const phoneInput = document.getElementById('phoneInput');
        const otpContainer = document.getElementById('otpContainer');
        const otpInputs = document.querySelectorAll('.otp-input');
        const otpForm = document.getElementById('otpForm');
        const alertMessage = document.getElementById('alertMessage');
        const alertText = document.getElementById('alertText');
        const timerText = document.getElementById('timerText');
        const timerSpan = document.getElementById('timer');
        const resendOtpBtn = document.getElementById('resendOtpBtn');
        const changeNumberBtn = document.getElementById('changeNumberBtn');

        let timerInterval;
        let timeLeft = 120; // 2 minutes

        // Show Alert
        function showAlert(message, duration = 3000) {
            alertText.textContent = message;
            alertMessage.classList.add('show');
            setTimeout(() => {
                alertMessage.classList.remove('show');
            }, duration);
        }

        // Validate Phone Number
        function validatePhone(phone) {
            const phoneRegex = /^09[0-9]{9}$/;
            return phoneRegex.test(phone);
        }

        // Start Timer
        function startTimer() {
            timeLeft = 120;
            resendOtpBtn.disabled = true;
            timerText.classList.remove('expired');
            
            timerInterval = setInterval(() => {
                timeLeft--;
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timerSpan.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    timerText.classList.add('expired');
                    timerSpan.textContent = 'منقضی شده';
                    resendOtpBtn.disabled = false;
                }
            }, 1000);
        }

        // Phone Form Submit
        phoneForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const phone = phoneInput.value.trim();

            if (!validatePhone(phone)) {
                showAlert('لطفا شماره موبایل معتبر وارد کنید');
                return;
            }

            // Simulate sending OTP
            showAlert('کد تایید به شماره ' + phone + ' ارسال شد');
            phoneForm.style.display = 'none';
            otpContainer.classList.add('active');
            startTimer();
            otpInputs[0].focus();
        });

        // OTP Input Handling
        otpInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                const value = e.target.value;
                
                if (value.length === 1 && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });

            // Only allow numbers
            input.addEventListener('keypress', (e) => {
                if (!/[0-9]/.test(e.key)) {
                    e.preventDefault();
                }
            });
        });

        // OTP Form Submit
        otpForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            let otp = '';
            otpInputs.forEach(input => {
                otp += input.value;
            });

            if (otp.length !== 6) {
                showAlert('لطفا کد 6 رقمی را کامل وارد کنید');
                return;
            }

            // Simulate OTP verification
            showAlert('در حال ورود...', 2000);
            setTimeout(() => {
                // Redirect to main page or dashboard
                window.location.href = 'index2.html';
            }, 2000);
        });

        // Resend OTP
        resendOtpBtn.addEventListener('click', () => {
            showAlert('کد تایید مجدد ارسال شد');
            otpInputs.forEach(input => input.value = '');
            otpInputs[0].focus();
            startTimer();
        });

        // Change Number
        changeNumberBtn.addEventListener('click', () => {
            clearInterval(timerInterval);
            otpContainer.classList.remove('active');
            phoneForm.style.display = 'block';
            otpInputs.forEach(input => input.value = '');
            phoneInput.value = '';
            phoneInput.focus();
        });

        // Initialize
        createParticles();
        phoneInput.focus();
    </script>
</body>
</html>
