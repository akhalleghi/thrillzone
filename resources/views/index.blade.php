<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon-32x32.png') }}">
    <title>منطقه هیجان - اشتراک‌ها و اشتراک‌های قانونی پلی‌استیشن</title>
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet">
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

        /* Animated Background */
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
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
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

        /* Header */
        header {
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(30px);
            padding: 1.2rem 5%;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(255, 0, 77, 0.15);
            transition: all 0.3s ease;
        }

        header.scrolled {
            padding: 0.8rem 5%;
            box-shadow: 0 10px 40px rgba(255, 0, 77, 0.1);
        }

        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo-icon {
            width: 58px;
            height: 58px;
            background: linear-gradient(135deg, #ff004d 0%, #a10035 100%);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 6px;
            box-shadow: 0 0 30px rgba(255, 0, 77, 0.5);
            animation: logoGlow 3s ease-in-out infinite;
        }

        .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 10px;
            background: #000;
        }

        @keyframes logoGlow {
            0%, 100% { box-shadow: 0 0 30px rgba(255, 0, 77, 0.5); }
            50% { box-shadow: 0 0 50px rgba(255, 0, 77, 0.8); }
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.5px;
        }

        .nav-menu {
            display: flex;
            gap: 35px;
            align-items: center;
        }

        .nav-link {
            color: #b0b0b0;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #ff004d, #a10035);
            transition: width 0.3s ease;
        }

        .nav-link:hover {
            color: #ff004d;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .auth-btn {
            background: linear-gradient(135deg, #ff004d 0%, #a10035 100%);
            color: #000;
            padding: 11px 30px;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 5px 20px rgba(255, 0, 77, 0.3);
            position: relative;
            overflow: hidden;
        }

        .auth-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .auth-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(255, 0, 77, 0.5);
        }

        .menu-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            z-index: 1001;
        }

        .menu-toggle span {
            width: 25px;
            height: 3px;
            background: #ff004d;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        /* Container */
        .container {
            position: relative;
            z-index: 1;
            max-width: 1400px;
            margin: 0 auto;
            padding: 130px 5% 60px;
        }

        /* Hero */
        .hero {
            text-align: center;
            margin-bottom: 120px;
            position: relative;
            padding: 60px 0;
        }

        .hero-particles {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: #ff004d;
            border-radius: 50%;
            animation: particleFloat 6s infinite ease-in-out;
        }

        @keyframes particleFloat {
            0%, 100% {
                transform: translateY(0) translateX(0);
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
        }

        .hero-badge {
            display: inline-block;
            background: rgba(255, 0, 77, 0.15);
            border: 1px solid rgba(255, 0, 77, 0.4);
            padding: 10px 24px;
            border-radius: 25px;
            font-size: 0.85rem;
            color: #ff004d;
            margin-bottom: 30px;
            font-weight: 600;
            animation: fadeInDown 1s ease;
            letter-spacing: 0.5px;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero h1 {
            font-size: 4.5rem;
            margin-bottom: 25px;
            font-weight: 900;
            line-height: 1.15;
            background: linear-gradient(135deg, #ffffff 0%, #ff004d 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: fadeInUp 1s ease 0.2s both;
            letter-spacing: -2px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero p {
            font-size: 1.3rem;
            color: #b0b0b0;
            max-width: 700px;
            margin: 0 auto 45px;
            line-height: 1.8;
            animation: fadeInUp 1s ease 0.4s both;
        }

        .hero-cta {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeInUp 1s ease 0.6s both;
        }

        .cta-primary {
            background: linear-gradient(135deg, #ff004d 0%, #a10035 100%);
            color: #000;
            padding: 16px 40px;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 30px rgba(255, 0, 77, 0.4);
        }

        .cta-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(255, 0, 77, 0.6);
        }

        .cta-secondary {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            padding: 16px 40px;
            border: 2px solid rgba(255, 0, 77, 0.3);
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .cta-secondary:hover {
            background: rgba(255, 0, 77, 0.1);
            border-color: #ff004d;
            transform: translateY(-3px);
        }

        /* Section */
        .section {
            margin-bottom: 120px;
            animation: fadeInUp 1s ease both;
        }

        .section-header {
            text-align: center;
            margin-bottom: 70px;
        }

        .section-title {
            font-size: 3rem;
            font-weight: 900;
            margin-bottom: 20px;
            color: #fff;
            letter-spacing: -1px;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: #888;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.7;
        }

        /* Plans Grid */
        .plans-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 35px;
            margin-bottom: 120px;
        }

        .plan-card {
            background: rgba(15, 15, 15, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 40px 35px;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .plan-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, transparent, #ff004d, transparent);
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .plan-card::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255, 0, 77, 0.15) 0%, transparent 70%);
            transform: translate(-50%, -50%) scale(0);
            transition: transform 0.6s ease;
            border-radius: 50%;
        }

        .plan-card:hover::after {
            transform: translate(-50%, -50%) scale(1);
        }

        .plan-card:hover {
            transform: translateY(-10px) scale(1.02);
            border-color: rgba(255, 0, 77, 0.4);
            box-shadow: 0 25px 70px rgba(255, 0, 77, 0.2);
        }

        .plan-card:hover::before {
            opacity: 1;
        }

        .plan-badge,
        .plan-price,
        .plan-period {
            display: none !important; /* قیمت/بج/دوره مخفی تا ساختار حفظ شود */
        }

        .plan-badge {
            display: inline-block;
            background: rgba(255, 0, 77, 0.15);
            color: #ff004d;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            margin-bottom: 24px;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            z-index: 1;
        }

        .plan-name {
            font-size: 1.9rem;
            font-weight: 900;
            margin-bottom: 12px;
            color: #fff;
            position: relative;
            z-index: 1;
        }

        .plan-divider {
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 0, 77, 0.3), transparent);
            margin: 25px 0;
        }

        .plan-features {
            list-style: none;
            margin: 30px 0;
            position: relative;
            z-index: 1;
        }

        .plan-features li {
            padding: 12px 0;
            padding-right: 30px;
            color: #c0c0c0;
            position: relative;
            font-size: 0.95rem;
            line-height: 1.7;
            transition: all 0.3s ease;
        }

        .plan-features li:hover {
            color: #fff;
            padding-right: 35px;
        }

        .plan-features li.plan-feature-unavailable {
            color: #666;
            opacity: 0.6;
        }

        .plan-features li.plan-feature-unavailable::before {
            content: '×';
            color: #ff1e56;
        }

        .plan-features li::before {
            content: '✓';
            position: absolute;
            right: 0;
            color: #ff004d;
            font-weight: bold;
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }

        .plan-features li:hover::before {
            transform: scale(1.2);
        }

        .plan-btn {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            padding: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s ease;
            text-decoration: none;
            display: block;
            text-align: center;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        .plan-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .plan-btn:hover::before {
            left: 100%;
        }

        .plan-btn:hover {
            background: linear-gradient(135deg, #ff004d 0%, #a10035 100%);
            color: #000;
            border-color: transparent;
            box-shadow: 0 10px 35px rgba(255, 0, 77, 0.4);
            transform: translateY(-2px);
        }

        /* Features Grid */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .feature-card {
            text-align: center;
            padding: 40px 30px;
            background: rgba(15, 15, 15, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            transition: all 0.4s ease;
            cursor: pointer;
        }

        .feature-card:hover {
            border-color: rgba(255, 0, 77, 0.3);
            transform: translateY(-8px);
            box-shadow: 0 15px 50px rgba(255, 0, 77, 0.15);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 25px;
            background: linear-gradient(135deg, rgba(255, 0, 77, 0.15) 0%, rgba(140, 0, 35, 0.15) 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            transition: all 0.4s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 10px 30px rgba(255, 0, 77, 0.3);
        }

        .feature-title {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 12px;
            color: #fff;
        }

        .feature-desc {
            color: #888;
            font-size: 0.95rem;
            line-height: 1.7;
        }

        /* Video Section */
        .video-section {
            background: rgba(15, 15, 15, 0.6);
            border: 1px solid rgba(255, 0, 77, 0.1);
            border-radius: 30px;
            padding: 60px 50px;
            position: relative;
            overflow: hidden;
        }

        .video-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 0, 77, 0.05) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .video-content {
            position: relative;
            z-index: 1;
        }

        .video-wrapper {
            position: relative;
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }

        .video-thumbnail {
            width: 100%;
            aspect-ratio: 16 / 9;
            background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .video-thumbnail:hover {
            transform: scale(1.02);
        }

        .play-button {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #ff004d 0%, #a10035 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: #000;
            box-shadow: 0 10px 40px rgba(255, 0, 77, 0.5);
            transition: all 0.3s ease;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 10px 40px rgba(255, 0, 77, 0.5);
            }
            50% {
                transform: scale(1.1);
                box-shadow: 0 15px 60px rgba(255, 0, 77, 0.8);
            }
        }

        .video-thumbnail:hover .play-button {
            transform: scale(1.15);
        }

        /* FAQ Section */
        .faq-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .faq-item {
            background: rgba(15, 15, 15, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            margin-bottom: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            border-color: rgba(255, 0, 77, 0.3);
        }

        .faq-question {
            padding: 25px 30px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
            font-size: 1.05rem;
            color: #fff;
            transition: all 0.3s ease;
            user-select: none;
        }

        .faq-question:hover {
            color: #ff004d;
        }

        .faq-icon {
            font-size: 1.5rem;
            color: #ff004d;
            transition: transform 0.3s ease;
        }

        .faq-item.active .faq-icon {
            transform: rotate(45deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease, padding 0.4s ease;
            padding: 0 30px;
            color: #b0b0b0;
            line-height: 1.8;
        }

        .faq-item.active .faq-answer {
            max-height: 500px;
            padding: 0 30px 25px;
        }

        /* About Section */
        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .about-content h3 {
            font-size: 2.5rem;
            font-weight: 900;
            margin-bottom: 25px;
            color: #fff;
            line-height: 1.3;
        }

        .about-content p {
            font-size: 1.05rem;
            color: #b0b0b0;
            line-height: 1.9;
            margin-bottom: 20px;
        }

        .about-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-top: 40px;
        }

        .stat-card {
            text-align: center;
            padding: 25px;
            background: rgba(255, 0, 77, 0.05);
            border: 1px solid rgba(255, 0, 77, 0.2);
            border-radius: 16px;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(255, 0, 77, 0.2);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 900;
            color: #ff004d;
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #888;
            font-weight: 500;
        }

        .about-image {
            position: relative;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }

        .about-image-placeholder {
            width: 100%;
            aspect-ratio: 4 / 3;
            background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
        }

        .about-image-placeholder iframe {
            width: 100%;
            height: 100%;
            border: 0;
            border-radius: 20px;
        }

        /* Footer */
        footer {
            background: rgba(0, 0, 0, 0.8);
            padding: 60px 5% 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            margin-top: 120px;
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* حذف لینک‌ها/آیکن‌ها در فوتر طبق درخواست */
        .footer-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            align-items: center;
            gap: 30px;
            margin-bottom: 30px;
        }
        .footer-brand h3 { font-size: 1.5rem; font-weight: 800; margin-bottom: 15px; color: #fff; }
        .footer-brand p { color: #888; line-height: 1.7; margin-bottom: 12px; }
        .footer-support { font-size: 1.1rem; color: #ff004d; font-weight: 700; }
        .enamad-badge { display: flex; justify-content: flex-start; }
        .enamad-badge a { display: inline-flex; padding: 10px; border-radius: 12px; background: rgba(255, 255, 255, 0.04); overflow: hidden; }
        .enamad-badge img { width: 120px; height: auto; display: block; }
        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            color: #666;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .footer-grid {
                grid-template-columns: 1fr;
                text-align: center;
            }
            .enamad-badge {
                justify-content: center;
                margin-top: 15px;
            }
        }

        /* Scroll to Top */
        .scroll-top {
            position: fixed;
            bottom: 30px;
            left: 30px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #ff004d 0%, #a10035 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-size: 1.5rem;
            cursor: pointer;
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px rgba(255, 0, 77, 0.4);
            z-index: 999;
        }

        .scroll-top.visible {
            opacity: 1;
            pointer-events: auto;
        }

        .scroll-top:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(255, 0, 77, 0.6);
        }

        .whatsapp-float {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff004d 0%, #a10035 100%);
            color: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 20px rgba(255, 0, 77, 0.4);
            z-index: 1200;
            transition: all 0.3s ease;
        }

        .whatsapp-float:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(255, 0, 77, 0.6);
        }

        .whatsapp-float svg {
            width: 24px;
            height: 24px;
            fill: currentColor;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .plans-grid {
                grid-template-columns: 1fr;
                max-width: 500px;
                margin: 0 auto 120px;
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .about-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
        }

        @media (max-width: 768px) {
            .nav-menu {
                position: fixed;
                top: 0;
                right: -100%;
                width: 80%;
                height: 100vh;
                background: rgba(0, 0, 0, 0.98);
                backdrop-filter: blur(20px);
                flex-direction: column;
                justify-content: center;
                gap: 30px;
                transition: right 0.3s ease;
                border-left: 1px solid rgba(255, 0, 77, 0.2);
            }

            .nav-menu.active {
                right: 0;
            }

            .menu-toggle {
                display: flex;
            }

            .menu-toggle.active span:nth-child(1) {
                transform: rotate(45deg) translate(7px, 7px);
            }

            .menu-toggle.active span:nth-child(2) {
                opacity: 0;
            }

            .menu-toggle.active span:nth-child(3) {
                transform: rotate(-45deg) translate(7px, -7px);
            }

            .hero h1 {
                font-size: 2.5rem;
                letter-spacing: -1px;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .hero-cta {
                flex-direction: column;
            }

            .cta-primary, .cta-secondary {
                width: 100%;
                justify-content: center;
            }

            .section-title {
                font-size: 2rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .about-stats {
                grid-template-columns: 1fr;
            }

            .video-section {
                padding: 40px 25px;
            }
        }

        /* Loading Animation */
        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }
            100% {
                background-position: 1000px 0;
            }
        }

        .shimmer {
            animation: shimmer 2s infinite;
            background: linear-gradient(to right, transparent 0%, rgba(255, 0, 77, 0.1) 50%, transparent 100%);
            background-size: 1000px 100%;
        }
        footer, .footer-bottom, .footer-content {
  position: relative;
  z-index: 10;
}

    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="animated-bg">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
    </div>

    <!-- Header -->
    <header id="header">
        <div class="header-content">
            <div class="logo">
                <div class="logo-icon">
                    <img src="{{ asset('images/thrill-logo.png') }}" alt="منطقه هیجان">
                </div>
                <div class="logo-text">منطقه هیجان</div>
            </div>
            <nav class="nav-menu" id="navMenu">
                <a href="#plans" class="nav-link">پلن‌ها</a>
                <a href="#features" class="nav-link">ویژگی‌ها</a>
                <a href="#video" class="nav-link">آموزش</a>
                <a href="#faq" class="nav-link">سوالات</a>
                <a href="#about" class="nav-link">درباره ما</a>
                @auth
                        <a href="{{ route('user.dashboard') }}" class="auth-btn" role="button">پنل کاربری</a>
                    @else
                        <a href="/login" class="auth-btn" role="button">ورود / ثبت نام</a>
                    @endauth
            </nav>
            <div class="menu-toggle" id="menuToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <div class="container">
        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-particles" id="heroParticles"></div>
            <div class="hero-badge">🎮 اشتراک‌های قانونی منطقه هیجان</div>
            <h1>دنیای بازی‌های<br>پلی استیشن را به‌صورت قانونی و نامحدود تجربه کنید</h1> 
            <p>با اشتراک های منطقه هیجان، دسترسی امن و قانونی به بازی‌های استور سونی، تعویض دوره‌ای بازی‌ها و نصب دیتای حضوری رایگان را تجربه کنید.</p>
            <div class="hero-cta">
                <a href="#plans" class="cta-primary">
                    <span>مشاهده پلن‌ها</span>
                    <span>⬅</span>
                </a>
                <a href="#video" class="cta-secondary">
                    <span>▶</span>
                    <span>آموزش فعال‌سازی</span>
                </a>
            </div>
        </section>

        <!-- Plans Section -->
        <section class="section" id="plans">
            <div class="section-header">
                <h2 class="section-title">اشتراک های منطقه ی هیجان</h2>
                <p class="section-subtitle">سه سطح خدمات: لایت، پرو و مکس — همه با مدت‌زمان‌های ۳ ماهه، ۶ ماهه و ۱۲ ماهه</p>
            </div>

            <div class="plans-grid">
                <!-- Plan 1: Zone Light -->
                <div class="plan-card">
                    <span class="plan-badge">سه‌مدتی</span>
                    <h3 class="plan-name">اشتراک «Zone Lite»</h3>
                    <div class="plan-price"></div>
                    <p class="plan-period"></p>

                    <div class="plan-divider"></div>

                    <ul class="plan-features">
                        <li>پلتفرم: پلی‌استیشن ۵ و ۴</li>
                        <li>تعداد بازی همزمان: ۲ عدد</li>
                        <li>نوع بازی: قانونی ظرفیت ۳ (درصورت موجود بودن ظرفیت ۲)</li>
                        <li>لیست بازی‌ها: کلیه بازی‌های استور سونی</li>
                        <li>تعداد بازی انتخابی لیست سطح یک: ۱ عدد</li>
                        <li>محدودیت تعویض رایگان بازی: ۱ ماه</li>
                        <li>نصب دیتا: به صورت حضوری رایگان</li>

                        <li class="plan-feature-unavailable">تخفیف خرید از سایت و فروشگاه حضوری: ۱۰٪</li>

                        <li class="plan-feature-unavailable">بازی رایگان: ۱ از ۵ ماهانه</li>
                        <li>مدت‌زمان‌ها: ۳ ماهه، ۶ ماهه، ۱۲ ماهه</li>
                    </ul>

                    @auth
                        <a href="{{ route('user.dashboard') }}" class="plan-btn" >پنل کاربری</a>
                    @else
                        <a href="/login" class="plan-btn" >ورود / ثبت نام</a>
                    @endauth
                </div>

                <!-- Plan 2: Zone Pro -->
                <div class="plan-card">
                    <span class="plan-badge">سه‌مدتی</span>
                    <h3 class="plan-name">اشتراک «Zone Pro»</h3>
                    <div class="plan-price"></div>
                    <p class="plan-period"></p>

                    <div class="plan-divider"></div>

                    <ul class="plan-features">
                        <li>پلتفرم: پلی‌استیشن ۵ و ۴</li>
                        <li>تعداد بازی همزمان: ۳ عدد</li>
                        <li>نوع بازی: قانونی ظرفیت ３ (درصورت موجود بودن ظرفیت ２)</li>
                        <li>لیست بازی‌ها: کلیه بازی‌های استور سونی</li>
                        <li>تعداد بازی انتخابی لیست سطح یک: ۱ عدد</li>
                        <li>محدودیت تعویض رایگان بازی: ۱ ماه</li>
                        <li>نصب دیتا: به صورت حضوری رایگان</li>

                        <li class="plan-feature-unavailable">تخفیف خرید از سایت و فروشگاه حضوری: ۱۰٪</li>

                        <li class="plan-feature-unavailable">بازی رایگان: ۱ از ۵ ماهانه</li>
                        <li>مدت‌زمان‌ها: ۳ ماهه، ۶ ماهه، ۱۲ ماهه</li>
                    </ul>

                    @auth
                        <a href="{{ route('user.dashboard') }}" class="plan-btn" >پنل کاربری</a>
                    @else
                        <a href="/login" class="plan-btn" >ورود / ثبت نام</a>
                    @endauth
                </div>

                <!-- Plan 3: Zone Max -->
                <div class="plan-card">
                    <span class="plan-badge">سه‌مدتی</span>
                    <h3 class="plan-name">اشتراک «Zone Max»</h3>
                    <div class="plan-price"></div>
                    <p class="plan-period"></p>

                    <div class="plan-divider"></div>

                    <ul class="plan-features">
                        <li>پلتفرم: پلی‌استیشن ۵ و ۴</li>
                        <li>تعداد بازی همزمان: ۵ عدد</li>
                        <li>نوع بازی: قانونی ظرفیت ۳ (درصورت موجود بودن ظرفیت ۲)</li>
                        <li>لیست بازی‌ها: کلیه بازی‌های استور سونی</li>
                        <li>تعداد بازی انتخابی لیست سطح یک: ۲ عدد</li>
                        <li>محدودیت تعویض رایگان بازی: ۱۵ روز</li>
                        <li>نصب دیتا: به صورت حضوری رایگان</li>
                        <li>تخفیف خرید از سایت و فروشگاه حضوری: ۱۰٪</li>
                        <li>بازی رایگان: ۱ از ۵ ماهانه</li>
                        <li>مدت‌زمان‌ها: ۳ ماهه، ۶ ماهه، ۱۲ ماهه</li>
                    </ul>

                    @auth
                        <a href="{{ route('user.dashboard') }}" class="plan-btn" >پنل کاربری</a>
                    @else
                        <a href="/login" class="plan-btn" >ورود / ثبت نام</a>
                    @endauth
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="section" id="features">
            <div class="section-header">
                <h2 class="section-title">چرا منطقه هیجان؟</h2>
                <p class="section-subtitle">بهترین خدمات و پشتیبانی برای گیمرهای ایرانی</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3 class="feature-title">تحویل هماهنگ</h3>
                    <p class="feature-desc">فعالسازی سریع اشتراک و شروع بازی‌ها</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🔒</div>
                    <h3 class="feature-title">امنیت کامل</h3>
                    <p class="feature-desc">ظرفیت‌های قانونی و حفاظت از اطلاعات</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">💎</div>
                    <h3 class="feature-title">کیفیت اورجینال</h3>
                    <p class="feature-desc">دسترسی به بازی‌های استور رسمی سونی</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🎯</div>
                    <h3 class="feature-title">پشتیبانی دائمی</h3>
                    <p class="feature-desc">تیم حرفه‌ای همیشه آماده پاسخگویی</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">💰</div>
                    <h3 class="feature-title">قیمت بصرفه</h3>
                    <p class="feature-desc">تضمین بهترین قیمت در سرتاسر ایران</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🎁</div>
                    <h3 class="feature-title">مزایای ویژه</h3>
                    <p class="feature-desc">تخفیف ویژه اشتراک مکس و بازیٔ رایگان دوره‌ای</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">🚀</div>
                    <h3 class="feature-title">تعویض رایگان</h3>
                    <p class="feature-desc">طبق پلن انتخابی هر ۱۵ روز یا هر ۱ ماه</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">✨</div>
                    <h3 class="feature-title">نصب دیتا حضوری</h3>
                    <p class="feature-desc">برای همه‌ی اشتراک‌ها رایگان</p>
                </div>
            </div>
        </section>

        <!-- Video Section -->
        <section class="section video-section" id="video">
            <div class="video-content">
                <div class="section-header">
                    <h2 class="section-title">آموزش خرید و فعالسازی اشتراک</h2>
                    <p class="section-subtitle">در این ویدیو، مراحل انتخاب و فعال‌سازی اشتراک خود را به صورت گام به گام ببینید</p>
                </div>

                <div class="video-wrapper">
                    <!-- Aparat Embed -->
                    <style>.h_iframe-aparat_embed_frame{position:relative;}.h_iframe-aparat_embed_frame .ratio{display:block;width:100%;height:auto;}.h_iframe-aparat_embed_frame iframe{position:absolute;top:0;left:0;width:100%;height:100%;}</style><div class="h_iframe-aparat_embed_frame"><span style="display: block;padding-top: 57%"></span><iframe src="https://www.aparat.com/video/video/embed/videohash/nfw748j/vt/frame"  allowFullScreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe></div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="section" id="faq">
            <div class="section-header">
                <h2 class="section-title">سوالات متداول</h2>
                <p class="section-subtitle">پاسخ سوالات رایج درباره اشتراک‌های منطقه هیجان</p>
            </div>

            <div class="faq-container">
                <div class="faq-item">
                    <div class="faq-question">
                        <span>چگونه اشتراک انتخابی را فعال می‌کنید؟</span>
                        <span class="faq-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        پس از انتخاب پلن، هماهنگی برای فعال‌سازی روی کنسول پلی‌استیشن شما انجام می‌شود و بازی‌ها طبق ظرفیت قانونی فعال می‌گردند. نصب دیتا حضوری و رایگان است.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>آیا این اشتراک‌ها با حساب ایران سازگارند؟</span>
                        <span class="faq-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        بله، اشتراک‌ها با حساب‌های پلی‌استیشن شما سازگار هستند و بر مبنای قوانین ظرفیت قانونی راه‌اندازی می‌شوند.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>امکان تعویض رایگان بازی‌ها چگونه است؟</span>
                        <span class="faq-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        در اشتراک لایت و پرو هر «۱ ماه» یک بار و در اشتراک مکس هر «۱۵ روز» یک بار می‌توانید یک بازی سطح یک را رایگان تعویض کنید.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>در صورت مشکل چه کار کنم؟</span>
                        <span class="faq-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        تیم پشتیبانی ما به‌صورت «دائمی» آماده پاسخگویی است. از طریق شماره پشتیبانی درج‌شده در پایین سایت با ما در ارتباط باشید.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>مدت‌زمان‌های اشتراک چگونه‌اند؟</span>
                        <span class="faq-icon">+</span>
                    </div>
                    <div class="faq-answer">
                        تمام اشتراک‌ها با سه مدت‌زمان «۳ ماهه»، «۶ ماهه» و «۱۲ ماهه» ارائه می‌شوند.
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section class="section" id="about">
            <div class="section-header">
                <h2 class="section-title">درباره منطقه هیجان</h2>
                <p class="section-subtitle"> مرجع تخصصی اشتراک های قانونی پلی‌استیشن</p>
            </div>

            <div class="about-grid">
                <div class="about-content">
                    <h3>ما چه کسانی هستیم؟</h3>
                    <p>
                        منطقه هیجان از سال «۱۳۹۸» با هدف ارائه خدمات مطمئن و با کیفیت به گیمرهای ایرانی شروع به کار کرد. ما با تمرکز بر رضایت مشتری و ارائه محصولات اورجینال، توانسته‌ایم اعتماد بیش از «۷۶۳» کاربر را جلب کنیم.
                    </p>
                    <p>
                        تیم ما متشکل از گیمرهای حرفه‌ای و متخصصان فنی است که همیشه آماده ارائه بهترین خدمات و پشتیبانی به شما عزیزان هستند. هدف ما ساده است: بهترین تجربه خرید و بهترین قیمت برای شما.
                    </p>

                    <div class="about-stats">
                        <div class="stat-card">
                            <div class="stat-number">۷۶۳</div>
                            <div class="stat-label">کاربر فعال</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">دائمی</div>
                            <div class="stat-label">پشتیبانی</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">۱۰۰٪</div>
                            <div class="stat-label">رضایت مشتری</div>
                        </div>
                    </div>
                </div>

                <div class="about-image">
                    <div class="about-image-placeholder">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d217.12868105755763!2d55.68099289484856!3d29.456290453010464!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2s!4v1762618292298!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-grid">
                <div class="footer-brand">
                    <h3>🎮 منطقه هیجان</h3>
                    <p>مرجع خرید و فعال‌سازی اشتراک‌های قانونی پلی‌استیشن در ایران. با ارائه خدمات باکیفیت و پشتیبانی «دائمی»، بهترین تجربه را برای شما فراهم می‌کنیم.</p>
                    <div class="footer-support">پشتیبانی: ۰۹۰۵۱۴۰۱۰۲۹</div>
                </div>
                <div class="enamad-badge">
                    <a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=516785&Code=89iDJBwRSQD3wgQdL1VAECmTIW72DY75'><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=516785&Code=89iDJBwRSQD3wgQdL1VAECmTIW72DY75' alt='' style='cursor:pointer' code='89iDJBwRSQD3wgQdL1VAECmTIW72DY75'></a>
                    <a href="https://zibal.ir/" target="_blank" rel="noopener">
                        <img src="{{ asset('images/Zibal-Logo.png') }}" alt="Zibal Logo">
                    </a>
                </div>
            </div>

            <div class="footer-bottom">
  <p>© ۱۴۰۴ منطقه هیجان. تمامی حقوق محفوظ است. | طراحی و توسعه با ♥️ توسط 
    <a href="https://wa.me/989137640338" target="_blank" 
       style="color:#ff004d; text-decoration:none; font-weight:700; cursor:pointer;">
       امین
    </a>
  </p>
</div>


        </div>
    </footer>

    <!-- Scroll to Top -->
    <div class="scroll-top" id="scrollTop">↑</div>
    <a href="https://wa.me/989051401029" class="whatsapp-float" target="_blank" rel="noopener" aria-label="چت واتس‌اپ">
        <svg viewBox="0 0 32 32" aria-hidden="true">
            <path d="M16 2.7c-6.97 0-12.63 5.66-12.63 12.63 0 2.22.58 4.39 1.69 6.31L3 29l7.57-1.98c1.85 1 3.94 1.52 6.06 1.52 6.97 0 12.63-5.66 12.63-12.63S22.97 2.7 16 2.7zm0 22.9c-1.86 0-3.7-.5-5.3-1.44l-.38-.23-3.84 1 1.03-3.74-.25-.39A9.85 9.85 0 0 1 6.16 15C6.16 9.97 10.97 5.7 16 5.7s9.84 4.27 9.84 9.3-4.81 9.3-9.84 9.3zm5.27-6.93c-.29-.15-1.71-.85-1.98-.95-.27-.1-.47-.15-.67.15-.2.29-.77.95-.94 1.14-.17.19-.35.22-.64.07-.29-.15-1.23-.45-2.35-1.43-.87-.78-1.46-1.74-1.63-2.03-.17-.29-.02-.45.13-.6.13-.13.29-.35.44-.52.15-.17.2-.29.3-.48.1-.19.05-.36-.02-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.5-.5-.67-.5-.17 0-.36 0-.55.02-.19.02-.52.08-.79.36-.27.29-1.04 1.02-1.04 2.48s1.07 2.88 1.22 3.08c.15.19 2.11 3.22 5.1 4.38.71.31 1.26.5 1.69.64.71.23 1.36.2 1.87.12.57-.08 1.71-.7 1.95-1.37.24-.67.24-1.24.17-1.37-.07-.13-.26-.21-.55-.36z"/>
        </svg>
    </a>

    <script>
        // Header Scroll Effect
        const header = document.getElementById('header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Mobile Menu Toggle
        const menuToggle = document.getElementById('menuToggle');
        const navMenu = document.getElementById('navMenu');

        menuToggle.addEventListener('click', () => {
            menuToggle.classList.toggle('active');
            navMenu.classList.toggle('active');
        });

        // Close menu when clicking on a link
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                menuToggle.classList.remove('active');
                navMenu.classList.remove('active');
            });
        });

        // Smooth Scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const headerHeight = header.offsetHeight;
                    const targetPosition = target.offsetTop - headerHeight - 20;
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // FAQ Toggle
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const faqItem = question.parentElement;
                const isActive = faqItem.classList.contains('active');

                // Close all FAQ items
                document.querySelectorAll('.faq-item').forEach(item => {
                    item.classList.remove('active');
                });

                // Toggle current item
                if (!isActive) {
                    faqItem.classList.add('active');
                }
            });
        });

        // Scroll to Top Button
        const scrollTop = document.getElementById('scrollTop');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 500) {
                scrollTop.classList.add('visible');
            } else {
                scrollTop.classList.remove('visible');
            }
        });

        scrollTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Generate Hero Particles
        const heroParticles = document.getElementById('heroParticles');
        for (let i = 0; i < 20; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.top = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 6 + 's';
            particle.style.animationDuration = (Math.random() * 4 + 4) + 's';
            heroParticles.appendChild(particle);
        }

        // Intersection Observer for Animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe all sections and cards
        document.querySelectorAll('.section, .plan-card, .feature-card, .faq-item').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.8s ease';
            observer.observe(el);
        });

        // Add hover effect to plan cards
        document.querySelectorAll('.plan-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
            });
        });
    </script>
</body>
</html>


